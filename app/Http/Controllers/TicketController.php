<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Special_validity_type;
use DateTime;
use DateTimeZone;
use App\Event;
use App\Ticket;
use Validator;
use DB;


class TicketController extends Controller
{
  public function index($slug)
  {
    // Get slug
    $event = Event::where('event_slug', '=', $slug)->first();

    // Get the special validity data 
  	$types = $this->getSpecialValidityTypes();


    return view('CreateTicket', compact('event', 'types'));
  }

  public function create(Request $request, $slug)
  {
    // Get slug
    $event = Event::where('event_slug', '=', $slug)->first();

  	if($request->isMethod('post') )
    {
      $validator = Validator::make($request -> all(), [
        'ticket_name' => 'required|regex:/^[A-Z][A-Za-z\s]*$/',
        'ticket_cost' => 'required|regex:/^[0-9]+[.]{0,1}[0-9]+$/',
        'special_validity' => 'required',
        'max_tickets' => 'required|regex:/^[0-9]*$/',
      ]);

      if($validator->fails())
      {
        return redirect('event/'.$slug.'/create_ticket')->withErrors($validator);
      }
      else
      {
        $eventId = $event->id;

        $ticket = new Ticket;
        $ticket_end_date = new DateTime($request->ticket_end_date);
        $ticket->ticket_name = $request->ticket_name;
        $ticket->event_id = $eventId;
        $ticket->ticket_cost = $request->ticket_cost;
        $ticket->special_validities_id = $request->special_validity;
        $ticket->max_tickets = $request->max_tickets;
        $ticket->tickets_left = $request->max_tickets;
        $ticket->tickets_sell_by_date = $ticket_end_date;
        $insert = $ticket->save();

        if($insert)
        {
          return redirect('event/'.$slug)->with('success', 'Ticket successfully created');
        }
        else
        {
          return redirect('event/'.$slug.'/create_ticket')->with('alertmessage', "An error occurred when creating the ticket. Please try again.");
        }
      }
    }
    return view('EventOverview');
  }

  public function deleteTicket($slug, $id){
    // Get ticket from id
    $ticket = Ticket::where('id', '=', $id)->delete();

    return redirect('event/'.$slug.'/manage')->with('success', 'Ticket deleted');
  }

  public function displayUpdateTicket($slug, $id){
    //  Get ticket from id
    $ticket = Ticket::where('id', '=', $id)->first();

    // Get slug
    $event = Event::where('event_slug', '=', $slug)->first();
    
    return view('UpdateTicket', compact(['ticket', 'event','id']));
  }

  public function storeUpdateTicket(Request $request, $slug){
     // Get slug
    $event = Event::where('event_slug', '=', $slug)->first();

    // $ticket = Ticket::where('id', '=', $request->id)->first();
    $ticketId = $request->input('ticketID');

    if($request->isMethod('post') )
    {
      $validator = Validator::make($request -> all(), [
        'ticket_name' => 'required',
        'ticket_cost' => 'required',
        // 'special_validity' => 'required',
        'tickets_left' => 'required',
        'ticket_end_date' => 'required'
      ]);

      if($validator->fails())
      {
        return redirect('event/'.$slug.'/update-ticket/'.$ticketId)->withErrors($validator);
      }
      else
      {
        DB::table('tickets')
        ->where('id', '=', $ticketId)
        ->update([
          'ticket_name'=>$request->ticket_name,
          'ticket_cost'=>$request->ticket_cost,
          'tickets_left'=>$request->tickets_left,
          'tickets_sell_by_date'=>$request->ticket_end_date,
        ]);

        return redirect('event/'.$slug.'/manage/')->with('success', 'Ticket updated');
        // if($insert)
        // {
        //   return redirect('event/'.$slug)-
        // }
        // else
        // {
        //   return redirect('event/'.$slug.'/manage')->with('alertmessage', "An error occurred when creating the ticket. Please try again.");
        // }
      }
    }
    return view('EventOverview');
  }

  private function getSpecialValidityTypes(){
  	$types = [];

  	$validity_type = Special_validity_type::all();

  	foreach ($validity_type as $type) {
  		$value = $type->validity_type;
  		$key = $type->id;
  		$types[$key] = $value;
  	}

  	return $types;
  }
}
