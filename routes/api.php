<?php

use Illuminate\Http\Request;

//===============================================================
//
// MEDIA SERVICE
//
//===============================================================


Route::post("/media", "MediaController@upload");

//===============================================================
//
// AUTHENTICATION
//
//===============================================================

Route::post("/register", "AuthController@register");
Route::post("/login", "AuthController@login");



Route::post("/phone/send", "AccountController@requestPhoneIdentityConfirm");


//===============================================================
//
// FORGET PASSWORD
//
//===============================================================

Route::post("/forget", "AccountController@forgetPassword");
Route::post("/forget/reset/{token}", "AccountController@resetPassword");


//===============================================================
//
// UTILITIES
//
//===============================================================

Route::get("utilities/countries","UtilityController@countries");
Route::get("utilities/cities","UtilityController@cities");
Route::get("utilities/categories","UtilityController@categories");
Route::get("utilities/page/{slug}","UtilityController@page");
Route::get("utilities/contacts","UtilityController@contacts");
Route::get("utilities/services","UtilityController@services");
Route::get("utilities/payment-methods","UtilityController@payment_methods");


//===============================================================
//
// PRODUCTS
//
//===============================================================

Route::get("search/best-seller", "ProductController@bestSeller");
Route::get("search/{type?}", "ProductController@search");
Route::get("product/{product}", "ProductController@show");
Route::get("product/{product}/comments", "ProductController@comments");



Route::group(["middleware" => "auth:api"], function () {

    Route::post("change-password", "AccountController@changePassword");
    Route::put("profile", "AccountController@updateProfile");

    //===============================================================
    //
    // RATINGS
    //
    //===============================================================

    Route::resource("rate", "RateController");


    //===============================================================
    //
    // CART
    //
    //===============================================================

    Route::resource("cart", "CartController");



    //===============================================================
    //
    // PHONE ACTIVATION
    //
    //===============================================================

    Route::post("/activate/phone", "AccountController@activatePhone");

    //===============================================================
    //
    // ADDRESSES
    //
    //===============================================================

    Route::resource("/address", "AddressController")
        -> only("index", "show", "update", "store", "destroy");


    //===============================================================
    //
    // ORDERS
    //
    //===============================================================
    Route::get("/order/{type}", "OrderController@index") -> where("type", \App\Models\Order::PENDING_FILTER . "|" . \App\Models\Order::COMPLETED_FILTER);
    Route::resource("/order", "OrderController") -> only("store", "show", "update", "destroy");
    Route::post("/order/{order}/product", "OrderController@addProduct");
    Route::put("/order/{order}/product", "OrderController@updateProduct");
    Route::delete("/order/{order}/product", "OrderController@deleteProduct");


    //===============================================================
    //
    // SERVICE REQUESTS
    //
    //===============================================================

    Route::resource("/service-request", "ServiceRequestController")
        -> only("index", "show", "update", "store", "destroy");
});