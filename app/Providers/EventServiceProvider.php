<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        "App\Events\PhoneActivationRequest" => ["App\Listeners\SendPhoneActivationCode"],
        "App\Events\ForgetPassword" => ["App\Listeners\GeneratePasswordResetToken"],
        "App\Events\UserRegistered" => ["App\Listeners\SendActivationEmail"],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();


    }
}
