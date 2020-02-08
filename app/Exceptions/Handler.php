<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Auth;
class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        /*if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('organizer') || $request->is('organizer/*')) {
            return redirect()->guest('/login/organizer');
        }
        if ($request->is('attendee') || $request->is('attendee/*')) {
            return redirect()->guest('/login/attendee');
        }
        return redirect()->guest('/login/organizer');*/

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('organizer')) {
            return redirect()->guest('/login/organizer');
        }
        if ($request->is('attendee')) {
            return redirect()->guest('/login/attendee');
        }
        return redirect()->guest('/login/organizer');
    }
}