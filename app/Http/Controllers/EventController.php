<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Event;
use App\Ticket;
use App\Room;
use App\Channel;
use App\Session;
use Auth;

class EventController extends Controller
{

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest:organizer')->except('logout');
        // $this->middleware('guest:attendee')->except('logout');
    }


    // Page to display all events that organizer has
    public function index()
    {
        $events = Event::all();

        $data = DB::table('events')->get()->last();
        $countOrgEvent = DB::table('events')->where('organizer_id', Auth::user()->id)->count();

      // ($events->organizer_id == Auth::user()->id).count();
      // dd($countOrgEvent);
      // $row_count = "";
        $dataArr = [];
        for($i = $data->id; $i > 0; $i--){
          $row_count = DB::table('attendee_register_event')
          ->select(DB::raw("COUNT(id) as count_row"))
          ->where("event_id", "=", $i)
          ->get();

          $value = $row_count[0]->count_row;
          $key = $i;
          $dataArr[$key] = $value;
        }
        if ( $countOrgEvent < 1) {
            return view('ManageEvent', compact(['events', 'dataArr', 'countOrgEvent']));
        }else{
            return view('ManageEvent', compact(['events','dataArr', 'countOrgEvent']));
        }
    }

    // Create method for event creation
    public function create(Request $request)
    {
        // $event = DB::table('events')->first();

        if($request->isMethod('post') )
        {
            $validator = Validator::make($request -> all(), [
                'event_name' => 'required',
                'event_slug' => 'required',
                'event_date' => 'required'
            ]);

            if($validator->fails())
            {
                return redirect()->route('event.create')->withErrors($validator)->withInput();
            }
            else
            {
                $event = new Event;
                $event->event_name = $request->event_name;
                $event->event_slug = $request->event_slug;
                    // $event->organizer_id = $request->organizer;
                $event->organizer_id = Auth::user()->id;
                $event->event_date = $request->event_date;
                $insert = $event->save();

                if($insert)
                {
                    return redirect()->route('event')->with('success', 'Event successfully created');
                }
                else
                {
                    return redirect()->route('event')->with('error', 'An error occured while creating event');
                }
            }
        }
        return view('CreateEvent');
    }

    // Event overview/details page
    public function overview($slug){
        // Get slug from database
        // $event = \DB::table('events')->where('event_slug', $slug)->first();
        $event = Event::where('event_slug', '=', $slug)->first();

        // Get the ticket data
        $ticket = Ticket::all();

        // Get the ticket data
        $session = Session::all();

        // Get the ticket data
        $room = Room::all();

        // Get the ticket data
        $channel = Channel::all();

        // Works for room
        /*$data = DB::table('rooms')
          ->select('channel_id', DB::raw('COUNT(rooms.channel_id) AS total_rooms'))
          ->groupBy('channel_id')
          ->get(); */

          $data = DB::table("channels")
          ->join('rooms', 'channels.id', '=', 'rooms.channel_id')
          ->join('sessions', 'rooms.id', '=', 'sessions.room_id')
          ->select('channels.channel_name', DB::raw('COUNT(sessions.id) AS total_sessions, COUNT(rooms.id) AS total_rooms'))
          ->groupBy('channels.channel_name')
          ->get();

        // dd($ticket);


        // / Get the event based on slug
        // $test = DB::table('events')->where('event_slug', '=', $slug)->get();

        // dd($test);

          return view('EventOverview', compact('event', 'ticket', 'session', 'room', 'channel', 'data'));
      }

      public function manage($slug){
        // Get slug from database
        // $event = \DB::table('events')->where('event_slug', $slug)->first();
        $event = Event::where('event_slug', '=', $slug)->first();

        // Get the ticket data
        $ticket = Ticket::all();

        // Get the ticket data
        $session = Session::all();

        // Get the ticket data
        $room = Room::all();

        // Get the ticket data
        $channel = Channel::all();

        $data = DB::table("channels")
        ->join('rooms', 'channels.id', '=', 'rooms.channel_id')
        ->join('sessions', 'rooms.id', '=', 'sessions.room_id')
        ->select('channels.channel_name', DB::raw('COUNT(sessions.id) AS total_sessions, COUNT(rooms.id) AS total_rooms'))
        ->groupBy('channels.channel_name')
        ->get();

        return view('ManageEventDetails', compact('event', 'ticket', 'session', 'room', 'channel', 'data'));
    }

    public function updateEvent(Request $request, $slug){
    // Get event from slug
        $event = Event::where('event_slug', '=', $slug)->first();

        if($request->isMethod('post') )
        {
          $validator = Validator::make($request -> all(), [
            'event_name' => 'required',
            'event_slug' => 'required',
            'event_date' => 'required'
        ]);

          if($validator->fails())
          {
            return redirect('event/'.$slug.'/manage/')->withErrors($validator);
            }
            else
            {
                $id = $event->id;
                DB::table('events')
                ->where('id', '=', $id) 
                ->update([
                  'event_name'=>$request->event_name,
                  'event_slug'=>$request->event_slug,
                  'event_date'=>$request->event_date
              ]);

            // change redirection to the newSlug saved
                $newSlug = $request->event_slug;
                return redirect('event/'.$newSlug.'/manage/')->with('success', 'Event successfully updated');
            }
        }
    }

    public function deleteEvent($slug){
        // Get event from slug
        $event = Event::where('event_slug', '=', $slug)->first();

        $event->delete();

        return redirect('event')->with('success', 'Event deleted');
    }
}
