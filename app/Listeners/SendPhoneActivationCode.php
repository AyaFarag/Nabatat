<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

class SendPhoneActivationCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $phone = $event -> phone;
        $user  = $event -> user;

        $confirmation_code = join("", array_map(function($value) { return mt_rand(0, 9); }, range(1, 4)));
        $phone -> confirmation_code = $confirmation_code;
        $phone -> save();

        $user -> phone_code_created_at = Carbon::now() -> toDateTimeString();
        $user -> save();

        //send SMS
    }
}
