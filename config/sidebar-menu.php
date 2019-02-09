<?php

return [
  "colors" => [
    "primary" => "#009688",
    "secondary" => "#9c27b0",
    "primary-name" => "teal",
    "secondary-name" => "purple"
  ],
  "logo" => [
    "text"  => "R9 Admin Panel",
    "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/Firefox_Logo%2C_2017.svg/1200px-Firefox_Logo%2C_2017.svg.png"
  ],
  "links" => [
    "logout"  => "admin.logout",
    "profile" => "admin.profile"
  ],
  "items" => [
    [
      "label" => "Dashboard",
      "icon"  => "dashboard",
      "route" => "admin.dashboard"
    ],
    [
      "label" => "Statistics",
      "icon"  => "graphic_eq",
      "route" => "admin.statistics"
    ],
    /////////////////////////////////////////// Users ////////////////////////////////////////////////
    [
      "label" => "Users",
      "icon"  => "person",
      "route" => "admin.user.index",
      "can"   => "view",
      "model" => \App\Models\User::class
    ],
    /////////////////////////////////////////// Moderators ///////////////////////////////////////////
    [
      "label" => "Moderators",
      "icon"  => "security",
      "route" => "admin.moderator.index",
      "can"   => "view",
      "model" => \App\Models\Admin::class
    ],
    //////////////////////////////////////////// Seetings /////////////////////////////////////////////
    [
      "label" => "Payment Methods",
      "icon"  => "shopping_basket",
      "route" => "admin.payment.index",
      "can"   => "view",
      "model" => \App\Models\Payment::class
    ],
    //////////////////////////////////////////// Seetings /////////////////////////////////////////////
    [
      "label" => "Orders",
      "icon"  => "shopping_basket",
      "route" => "admin.order.index",
      "can"   => "view",
      "model" => \App\Models\Order::class
    ],
    [
      "label" => "Requests",
      "icon"  => "local_florist",
      "route" => "admin.request.index",
      "can"   => "view",
      "model" => \App\Models\ServiceRequest::class
    ],
    /////////////////////////////////////////////////////// Countries /////////////////////////////////////
    [
      "label" => "Countries",
      "icon"  => "terrain",
      "route" => "admin.country.index",
      "can"   => "view",
      "model" => \App\Models\Country::class
    ],
    //////////////////////////////////////////////// Cities /////////////////////////////////////////////
    [
      "label" => "Cities",
      "icon"  => "place",
      "route" => "admin.city.index",
      "can"   => "view",
      "model" => \App\Models\City::class
    ],
    ///////////////////////////////////////////// Category /////////////////////////////////////////////
    [
      "label" => "Categories",
      "icon"  => "category",
      "route" => "admin.category.index",
      "can"   => "view",
      "model" => \App\Models\Category::class
    ],
    //////////////////////////////////////////////// pages /////////////////////////////////////////////////////////
    [
      "label" => "Pages",
      "icon"  => "pages",
      "route" => "admin.pages.index",
      "can"   => "view",
      "model" => \App\Models\Page::class
    ],
    //////////////////////////////////////////////// products /////////////////////////////////////////////
    [
      "label" => "Products",
      "icon"  => "store",
      "route" => "admin.product.index",
      "can"   => "view",
      "model" => \App\Models\Product::class
    ],
    ////////////////////////////////////////////// Offers ////////////////////////////////////////////
    [
      "label" => "Offers",
      "icon"  => "local_offer",
      "route" => "admin.offer.index",
      "can"   => "view",
      "model" => \App\Models\Offer::class
    ],
    ////////////////////////////////////////////// Services ////////////////////////////////////////////
    [
      "label" => "Services",
      "icon"  => "toys",
      "route" => "admin.service.index",
      "can"   => "view",
      "model" => \App\Models\Service::class
    ],
    ////////////////////////////////////////////// Setting ////////////////////////////////////////////
    [
      "label" => "Settings",
      "icon"  => "settings",
      "route" => "admin.setting.edit",
      "can"   => "update",
      "model" => \App\Models\Setting::class
    ],
    ////////////////////////////////////////////// Approve Rates ////////////////////////////////////////////
    [
      "label" => "Products Rates",
      "icon"  => "equalizer",
      "route" => "admin.rate.index",
      "can"   => "view",
      "model" => \App\Models\Rate::class,
    ],
    [
      "label" => "Reports",
      "icon"  => "equalizer",
      "route" => "admin.report.index",
      // "can"   => "update",
      "model" => \App\Models\Rate::class,
      
    ],
    ////////////////////////////////////////////// Delivery ////////////////////////////////////////////
    [
      "label" => "Delivery",
      "icon"  => "directions_bus",
      "route" => "admin.delivery.index",
    ]
  ]
];