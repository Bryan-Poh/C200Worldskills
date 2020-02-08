<?php


// Route::get('/dashboard',  'DashboardController@index')->name('dashboard');


use Illuminate\Support\Facades\Route;
Route::get('/logout', 'Auth\LoginController@logout')->name('organizerLogout');

Auth::routes();

// Route::get('/', 'Auth\LoginController@showOrganizerLoginForm');
Route::get('/login/organizer', 'Auth\LoginController@showOrganizerLoginForm');
Route::get('/login/attendee', 'Auth\LoginController@showAttendeeLoginForm');
// Route::get('/register/organizer', 'Auth\RegisterController@showOrganizerRegisterForm');
// Route::get('/register/blogger', 'Auth\RegisterController@showBloggerRegisterForm');

Route::post('/login/organizer', 'Auth\LoginController@organizerLogin');
Route::post('/login/attendee', 'Auth\LoginController@attendeeLogin');
// Route::post('/register/organiser', 'Auth\RegisterController@createAdmin');
// Route::post('/register/blogger', 'Auth\RegisterController@createBlogger');



Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/login/organizer');
});

//ATTENDEE SIGN IN
Route::get('/sign_in', function() {
    return view('sign_in');
});

//ATTENDEE SESSION DETAILS

//Middleware
Route::group(['middleware' => ['auth']], function () {
    // any route here will only be accessible for logged in users
    //
    //

    //--------------- //
    //Manage Events  //
    //------------- //
    Route::get('/event',  'EventController@index')->name('event');
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {

        Route::get('/create', 'EventController@create')->name('create');
        Route::post('/create', 'EventController@create')->name('create');

        Route::get('/overview', 'EventController@overview')->name('overview');

        // event edit
        Route::get('/{slug}/manage', 'EventController@manage')->name('manage_event_details');
        // Update event
        Route::post('/{slug}/manage', 'EventController@updateEvent')->name('update_event');
        // Delete event
        Route::delete('/{slug}/manage', 'EventController@deleteEvent')->name('delete_event');

        //     // --------------- //
        //     // Manage session //
        //     // ------------- //

        Route::get('/{slug}/create_session', 'SessionController@index')->name('create_session');
        Route::get('/{slug}/update_session/{id}', 'SessionController@update')->name('update_session');
        Route::post('/{slug}/store_update_session', 'SessionController@storeUpdate')->name('store_update_session');
        Route::get('{slug}/delete_session/{id}', 'SessionController@delete')->name('delete_session');
        Route::post('/{slug}/store_session', 'SessionController@store')->name('store_session');

        //     // --------------- //
        //     // Manage channel //
        //     // ------------- //
        Route::get('/{slug}/create_channel', 'ChannelController@index')->name('create_channel');
        Route::post('/{slug}/store_channel', 'ChannelController@store')->name('store_channel');
        Route::get('/{slug}/update_channel/{id}', 'ChannelController@update')->name('update_channel');
        Route::post('/{slug}/store_update_channel', 'ChannelController@storeUpdate')->name('store_update_channel');
        Route::get('/{slug}/delete_channel/{id}', 'ChannelController@delete')->name('delete_channel');

        //     //----------------- //
        //     //  Manage Room    //
        //     //----------------//
        Route::get('/room_capacity', 'RoomController@index')->name('room_capacity');
        Route::get('/{slug}/create_room', 'RoomController@create')->name('create_room');
        Route::post('/{slug}/store_room', 'RoomController@store')->name('store_room');
        Route::get('/{slug}/update_room/{id}', 'RoomController@edit')->name('update_room');
        Route::post('/{slug}/store_update_room', 'RoomController@update')->name('store_update_room');
        Route::get('/{slug}/delete_room/{id}', 'RoomController@delete')->name('delete_room');
        // event slug
        Route::get('/{slug}', 'EventController@overview')->name('overview');


        // --------------- //
        // Manage Ticket  //
        // ------------- //
        Route::get('/{slug}/create_ticket', 'TicketController@index')->name('ticket_create');
        Route::post('/{slug}/store_ticket', 'TicketController@create')->name('ticket_create_post');
        // Delete ticket
        Route::get('{slug}/delete-ticket/{id}', 'TicketController@deleteTicket')->name('delete_ticket');
        // Edit ticket
        Route::get('/{slug}/update-ticket/{id}', 'TicketController@displayUpdateTicket')->name('update_ticket');
        Route::post('/{slug}/store-update-ticket', 'TicketController@storeUpdateTicket')->name('store_update_ticket');
    });
});


Route::get('/attendee',  'AttendeeController@index')->name('attendee');
Route::group(['prefix' => 'attendee', 'as' => 'attendee.'], function () {
    Route::get('/event_register/{slug}', 'AttendeeController@eventRegister')->name('event_register');
    Route::post('/home/{slug}', 'AttendeeController@update')->name('ticket_purchase');
    Route::get('/home', 'AttendeeController@dashboard')->name('attendee_home');
    Route::get('/event_agenda/{slug}', 'AttendeeController@eventAgenda')->name('event_agenda');
//    Route::get('/{slug}', 'AttendeeController@getSlug');
});
