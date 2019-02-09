<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\PasswordReset;

class GeneratePasswordResetToken
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
        $phone = $event -> phone;
        $passwordReset = PasswordReset::where("phone", $phone -> phone) -> first();
        $randomString = str_random(50);
        if (is_null($passwordReset)) PasswordReset::create(["token" => bcrypt($randomString), "phone" => $phone -> phone]);
        else $passwordReset -> update(["token" => bcrypt($randomString)]);

        $user -> phones() -> update(["confirmation_code" => null]);
        return $randomString;
    }
}
