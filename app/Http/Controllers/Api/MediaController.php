<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public function upload(Request $request) {
        $request -> validate([
            "images"   => "required",
            "images.*" => "image"
        ]);

        $images = [];

        foreach ($request -> file("images") as $image) {
            $fileName = round(microtime(true) * 1000) . str_random(15) . "." . $image -> extension();
            $image -> storeAs("media", $fileName);

            $images[] = URL("media/" . $fileName);
        }

        return response()
            -> json(compact("images"), 200);
    }

    public function show($name) {
        $path = storage_path("app/media/" . $name);

        return Image::make($path) -> response();
    }
}
