<?php




//===============================================================
//
// AUTHENTICATION
//
//===============================================================

Route::redirect("/", "/admin/login", 301);
Route::get("/login", "LoginController@showLoginForm") -> name("admin.login");
Route::post("/login", "LoginController@login");




Route::group([
    "middleware" => "auth:admin",
    "as"         => "admin."
], function () {
    
    //===============================================================
    //
    // DASHBOARD
    //
    //===============================================================
    
    Route::get("/dashboard", "DashboardController@index") -> name("dashboard");
    
    //===============================================================
    //
    // STATISTICS
    //
    //===============================================================
    
    Route::get("/statistics", "StatisticsController@index") -> name("statistics");
    
    
    
    //===============================================================
    //
    // MODERATORS
    //
    //===============================================================
    
    Route::resource("/moderator", "ModeratorController");
    
    
    
    //===============================================================
    //
    // USERS
    //
    //===============================================================

    Route::get("/user/report", "UserController@report") -> name("user.report");
    Route::resource("/user", "UserController");
    
    
    //===============================================================
    //
    // PAYMENT
    //
    //===============================================================
    
    Route::resource("/payment", "PaymentController") -> only("index", "edit", "update");
    
    
    //===============================================================
    //
    // PROFILE
    //
    //===============================================================
    
    Route::get("/profile", "AdminController@showProfile") -> name("profile");
    Route::put("/profile", "AdminController@updateProfile");
    
    
    
    //===============================================================
    //
    // SETTING
    //
    //===============================================================
    
    Route::get("/setting", "SettingController@edit") -> name("setting.edit");
    Route::put("/setting", "SettingController@update");
    
    //===============================================================
    //
    // Orders
    //
    //===============================================================

    Route::get("/order/report", "OrderController@report") -> name("order.report");
    Route::get("/order", "OrderController@index") -> name("order.index");
    Route::get("/order/{order}", "OrderController@show") -> name("order.show");
    Route::put("/order/{order}/status", "OrderController@changeStatus") -> name("order.status");
    Route::put("/order/{order}/product/{product}", "OrderController@modifyProduct") -> name("order.product.modify");
    Route::get("/assign/delivery/{order}", "OrderController@assignDelivery")->name("order.delivery");
    Route::get("/order/receipt/{order}", "OrderController@orderReceipt")->name("order.receipt");
    
    //===============================================================
    //
    // Countries
    //
    //===============================================================
    
    Route::resource("/country", "CountryController");
    
    //===============================================================
    //
    // Cities
    //
    //===============================================================
    
    Route::resource("/city", "CityController");
    
    //===============================================================
    //
    // Category
    //
    //===============================================================
    
    Route::resource("/category", "CategoryController");
    
    //===============================================================
    //
    // Pages
    //
    //===============================================================
    
    Route::resource("/pages", "PageController");
    
    //===============================================================
    //
    // Products
    //
    //===============================================================
    Route::get("/product/report", "ProductController@report") -> name("product.report");

    Route::resource("/product", "ProductController");
    
    //===============================================================
    //
    // Offer
    //
    //===============================================================
    
    Route::resource("/offer", "OfferController");
    
    //===============================================================
    //
    // Service
    //
    //===============================================================
    
    Route::resource("/service", "ServiceController");
    
    //===============================================================
    //
    // Rates
    //
    //===============================================================
    
    Route::get("/rate", "RateController@index")->name('rate.index');
    Route::get("/rate/approve/{rate}", "RateController@approve")->name('rate.approve');
    Route::get("/rate/reject/{rate}", "RateController@reject")->name('rate.reject');
    
    // Request
    //
    //===============================================================
    
    Route::resource("/request", "RequestController");
    Route::post("/request/{request}/approve", "RequestController@approve")
    -> name("request.approve");
    
    //===============================================================
    //
    // Report
    //
    //===============================================================

    Route::resource("/report", "ReportController")->only('index');
    // Route::get("/report/run/{reportName}", "ReportController@run");
    Route::get("/report/download/{name}", "ReportController@download")
        -> name("report.generate");
  
    //===============================================================
    // Delivery
    //
    //===============================================================
    
    Route::resource("/delivery", "DeliveryController");
    
    //===============================================================
    //
    // LOGOUT
    //
    //===============================================================
    
    Route::get("/logout", "LoginController@logout") -> name("logout");
    
});