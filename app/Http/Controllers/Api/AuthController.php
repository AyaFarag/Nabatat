<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;

use App\Http\Resources\UserResource;

use App\Events\UserRegistered;

use Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        if (filter_var($request -> input("login"), FILTER_VALIDATE_EMAIL)) {
            $user = User::whereEmail($request -> input("login")) -> first();
        } else {
            $user = User::whereHas("phones", function ($query) use ($request) {
                $query -> where("phone", $request -> input("login"));
            }) -> first();
        }
        if ($user) {
            $user -> api_token = str_random(60);
            $user -> device_token = $request -> input("device_token");
            $user -> save();

            return new UserResource($user);
        }

        return response()->json(["error" => trans("auth.failed")], 401);
    }

    public function register(RegisterRequest $request) {
        $user = new User($request -> all());
        $user -> api_token = str_random(60);
        $user -> activated = false;
        $user -> save();
        $user -> phones() -> create(["phone" => $request -> input("phone")]);
        $user -> addresses() -> create([
            "first_name" => $request -> input("first_name"),
            "last_name" => $request -> input("last_name"),
            "phone" => $request -> input("phone"),
            "address" => $request -> input("address"),
            "city_id" => $request -> input("city_id")
        ]);

        // event(new UserRegistered($user));

        return new UserResource($user);
    }
}
