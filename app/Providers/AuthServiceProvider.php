<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Admin;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // ADMIN POLICIES
        "App\Models\Admin"          => "App\Policies\Admin\ModeratorPolicy",
        "App\Models\User"           => "App\Policies\Admin\UserPolicy",
        "App\Models\Setting"        => "App\Policies\Admin\SettingPolicy",
        "App\Models\Payment"        => "App\Policies\Admin\PaymentPolicy",
        "App\Models\Country"        => "App\Policies\Admin\CountryPolicy",
        "App\Models\City"           => "App\Policies\Admin\CityPolicy",
        "App\Models\Category"       => "App\Policies\Admin\CategoryPolicy",
        "App\Models\Page"           => "App\Policies\Admin\PagePolicy",
        "App\Models\Product"        => "App\Policies\Admin\ProductPolicy",
        "App\Models\Offer"          => "App\Policies\Admin\OfferPolicy",
        "App\Models\Service"        => "App\Policies\Admin\ServicePolicy",

        // API POLICIES
        "App\Models\Address"        => "App\Policies\Api\AddressPolicy",
        "App\Models\Cart"           => "App\Policies\Api\CartPolicy",

        // SHARED POLICIES
        "App\Models\ServiceRequest" => "App\Policies\Shared\RequestPolicy",
        "App\Models\Rate"           => "App\Policies\Shared\RatingPolicy",
        "App\Models\Order"          => "App\Policies\Shared\OrderPolicy"
    ];

    public function boot()
    {
        $this -> registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user instanceof Admin && $user -> isSuperAdmin())
                return true;
        });
    }
}
