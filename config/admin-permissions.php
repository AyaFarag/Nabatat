<?php

return [
    "Super Admin" => [
        "admin" => "Super Admin"
    ],
    "Users" => [
        \App\Policies\Admin\UserPolicy::VIEW   => "View",
        \App\Policies\Admin\UserPolicy::CREATE => "Create",
        \App\Policies\Admin\UserPolicy::UPDATE => "Update",
        \App\Policies\Admin\UserPolicy::DELETE => "Delete"
    ],
    "Moderators" => [
        \App\Policies\Admin\ModeratorPolicy::VIEW   => "View",
        \App\Policies\Admin\ModeratorPolicy::CREATE => "Create",
        \App\Policies\Admin\ModeratorPolicy::UPDATE => "Update",
        \App\Policies\Admin\ModeratorPolicy::DELETE => "Delete"
    ],
    "Payment Methods" => [
        \App\Policies\Admin\PaymentPolicy::VIEW => "View",
        \App\Policies\Admin\PaymentPolicy::UPDATE => "Update",
    ],
    "Orders" => [
        \App\Policies\Shared\OrderPolicy::VIEW   => "View",
        \App\Policies\Shared\OrderPolicy::UPDATE => "Update",
        \App\Policies\Shared\OrderPolicy::DELETE => "Delete",
    ],
    "Countries" => [
        \App\Policies\Admin\CountryPolicy::VIEW   => "View",
        \App\Policies\Admin\CountryPolicy::CREATE => "Create",
        \App\Policies\Admin\CountryPolicy::UPDATE => "Update",
        \App\Policies\Admin\CountryPolicy::DELETE => "Delete",
    ],
    "Cities" => [
        \App\Policies\Admin\CityPolicy::VIEW   => "View",
        \App\Policies\Admin\CityPolicy::CREATE => "Create",
        \App\Policies\Admin\CityPolicy::UPDATE => "Update",
        \App\Policies\Admin\CityPolicy::DELETE => "Delete",
    ],
    "Categories" => [
        \App\Policies\Admin\CategoryPolicy::VIEW   => "View",
        \App\Policies\Admin\CategoryPolicy::CREATE => "Create",
        \App\Policies\Admin\CategoryPolicy::UPDATE => "Update",
        \App\Policies\Admin\CategoryPolicy::DELETE => "Delete",
    ],
    "Pages" => [
        \App\Policies\Admin\PagePolicy::VIEW   => "View",
        \App\Policies\Admin\PagePolicy::UPDATE => "Update"
    ],
    "Products" => [
        \App\Policies\Admin\ProductPolicy::VIEW   => "View",
        \App\Policies\Admin\ProductPolicy::CREATE => "Create",
        \App\Policies\Admin\ProductPolicy::UPDATE => "Update",
        \App\Policies\Admin\ProductPolicy::DELETE => "Delete",
    ],
    "Requests" => [
        \App\Policies\Shared\RequestPolicy::VIEW   => "View",
        \App\Policies\Shared\RequestPolicy::UPDATE => "Update",
        \App\Policies\Shared\RequestPolicy::DELETE => "Delete",
    ],
    "Offers" => [
        \App\Policies\Admin\OfferPolicy::VIEW   => "View",
        \App\Policies\Admin\OfferPolicy::CREATE => "Create",
        \App\Policies\Admin\OfferPolicy::UPDATE => "Update",
        \App\Policies\Admin\OfferPolicy::DELETE => "Delete",
    ],
    "Services" => [
        \App\Policies\Admin\ServicePolicy::VIEW   => "View",
        \App\Policies\Admin\ServicePolicy::CREATE => "Create",
        \App\Policies\Admin\ServicePolicy::UPDATE => "Update",
        \App\Policies\Admin\ServicePolicy::DELETE => "Delete",
    ],
    "Settings" => [
        \App\Policies\Admin\SettingPolicy::UPDATE => "Update"
    ]
];