<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "organizer" && Auth::guard($guard)->check()) {
            // dd($this);
        // dd($guard);
             return $next($request);
            // return redirect('/event');
        }
        if ($guard == "attendee" && Auth::guard($guard)->check()) {
            return redirect('/attendee/home');
            // return $next($request);
        }
        if (Auth::guard($guard)->check()) {
        // dd($guard);
            return redirect('/dashboard');
        }
        // else{
        //     Auth::logout(); // user must logout before redirect them
        //   return redirect()->guest('login');
        // }


        return $next($request);
    }
    
    
    // public function handle($request, Closure $next, ...$guards)
    // {

    //     // return redirect('/dashboard');

    //         // return 'adasdasd';

    //     // $this->validate($request, [
    //     //     'email'   => 'required',
    //     //     'password' => 'required'
    //     // ]);

    //     // if (Auth::guard('organizer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    //     //     return redirect()->intended('/event');
    //     //     // return 'adasdasd';
    //     // }
    //     // 
        
    //     if (Auth::guard('organizer')->attempt(['email' => $request->email, 'password' => $request->password])) {
    //         return redirect()->intended('/dashboard');
    //         // return 'adasdasd';
    //     }

    //     return $next($request);
    // }


}
