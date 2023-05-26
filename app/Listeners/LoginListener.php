<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cookie;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(Login $event)
    {
        $authUser = $event->user;
        Cookie::forget('tenant');
        Cookie::queue(Cookie::forever('tenant', encrypt($authUser->database)));
    }
}
