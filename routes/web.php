<?php

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


//===============================================================
//
// MEDIA
//
//==============================================================

Route::get("/media/{name}", "Api\MediaController@show");
Route::get('/activate', 'Web\AccountController@activate') -> name('activate');

//===============================================================
//
// API DOCUMENTATION
//
//===============================================================

Route::get("/docs", function (Request $request) {
    $documentation = new \App\Supports\ApiDocumentation();
    $endpoints = $documentation -> all($request -> input("categories"));
    return view("api-documentation.endpoints", compact("endpoints"));
}) -> name("apidocs");

Route::get("/docs/endpoint", function (Request $request) {
    $documentation = new \App\Supports\ApiDocumentation();
    $endpoint = $documentation -> get($request -> input("route"), $request -> input("method"));
    return view("api-documentation.endpoint", compact("endpoint"));
}) -> name("apidocs.endpoint");


Route::get("/storage/{path}", function ($path) {
    return Image::make(storage_path('app/public/'.$path))->response();
}) -> where("path", ".+");