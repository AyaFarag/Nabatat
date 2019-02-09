<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Mail\ConfirmationMail;

use Mail;

class SendActivationEmail
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

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event -> user;
        $token = str_random(50) . $user -> id;
        $user -> confirmation_code = $token;
        $user -> save();

        Mail::to($user)
            -> send(new ConfirmationMail(route('activate', [ 'token' => $token ])));
    }
}
