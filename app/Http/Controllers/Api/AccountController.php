<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Events\PhoneActivationRequest;
use App\Events\ForgetPassword;

use App\Models\User;
use App\Models\UserPhone;
use App\Models\PasswordReset;

use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\RequestPhoneIdentityConfirmRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\ProfileRequest;

use App\Http\Resources\UserResource;

use Carbon\Carbon;
use Auth;
use Hash;

class AccountController extends Controller
{
    public function changePassword(ChangePasswordRequest $request){
        $user = auth() -> user();
        if (Hash::check($request -> input("old_password"), $user -> password)){
            $user -> password = $request -> input("password");
            $user -> save();
            return response()->json(["message" => trans("api.password_changed_successfully")], 200);
        }
        return response() -> json(["error" => trans("api.invalid_old_password")], 401);
    }

    public function updateProfile(ProfileRequest $request) {
        $user = auth() -> user();

        $user -> update($request -> only("email", "name"));

        return response() -> json(["message" => trans("api.updated_successfully")]);
    }

    public function requestPhoneIdentityConfirm(RequestPhoneIdentityConfirmRequest $request) {
        if (filter_var($request -> input("login"), FILTER_VALIDATE_EMAIL)) {
            $user  = User::whereEmail($request -> input("login")) -> firstOrFail();
            $phone = $user -> phones() -> first();
        } else {
            $phone = UserPhone::wherePhone($request -> input("login")) -> firstOrFail();
            $user  = $phone -> user;
        }

        if (
            Carbon::parse($user -> phone_code_created_at)
                -> gt(Carbon::now() -> subMinutes(config("app.sms-rate-limit-minutes")))
        ) {
            return response() -> json([
                "seconds_left" => Carbon::parse($user -> phone_code_created_at)
                    -> addMinutes(config("app.sms-rate-limit-minutes"))
                    -> diffInSeconds(Carbon::now())
            ], 429);
        }

        event(new PhoneActivationRequest($user, $phone));
        
        return response()
            -> json(["message" => trans("api.activation_code_sent")], 200);
    }

    public function forgetPassword(ForgetPasswordRequest $request) {
        if (filter_var($request -> input("login"), FILTER_VALIDATE_EMAIL)) {
            $user  = User::whereEmail($request -> input("login")) -> firstOrFail();
            $phone = $user -> phones() -> first();
        } else {
            $phone = UserPhone::wherePhone($request -> input("login")) -> firstOrFail();
        }
        if (!$phone || $phone -> confirmation_code !== $request -> input("code"))
            return response() -> json(["error" => trans("api.invalid_code")], 403);

        $token = event(new ForgetPassword($phone -> user, $phone))[0];

        return response() -> json(compact("token"));
    }

    public function resetPassword($token, ResetPasswordRequest $request) {
        $isEmail = filter_var($request -> input("login"), FILTER_VALIDATE_EMAIL);
        if ($isEmail) {
            $user  = User::whereEmail($request -> input("login")) -> firstOrFail();
            $phone = $user -> phones() -> first();
            $passwordReset = PasswordReset::wherePhone($phone -> phone) -> first();
        } else {
            $passwordReset = PasswordReset::wherePhone($request -> input("login")) -> first();
        }


        if ($passwordReset && Hash::check($token, $passwordReset -> token)) {        
            if (!$isEmail) {
                $user = UserPhone::wherePhone($request -> input("login")) -> first() -> user;
            }
            $user -> password = $request -> input("password");
            $user -> save();
            $passwordReset -> delete();
            return response() -> json(["message" => trans("api.reset_successfully")], 200);
        }
        return response() -> json(["error" => trans("api.invalid_token")], 403);
    }

    public function activatePhone(Request $request) {
        $request -> validate(["code" => "required", "phone" => "required|regex:/^[+\d]+$/"]);
        $user = Auth::user();
        $phone = $user -> phones()
            -> where("users_phones.phone", $request -> input("phone"))
            -> where("users_phones.confirmation_code", $request -> input("code"))
            -> first();
        if (!$phone) {
            return response()
            -> json([
                "message" => trans("api.invalid_phone_activation_code")
            ], 403);
        }
        $phone -> confirmed         = true;
        $phone -> confirmation_code = null;
        $phone -> save();
        if (!$user -> activated) {
            $user -> activated = true;
            $user -> save();
        }
        return response()
            -> json([
                "message" => trans("api.activated_successfully")
            ], 200);
    }
}
