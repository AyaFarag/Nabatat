<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Validator;

use App\Models\User;

class AccountController extends Controller
{
    public function activate(Request $request) {
        $validator = Validator::make(
            $request->all(),
            ['token' => 'required|exists:users,confirmation_code']
         );

        if ($validator -> fails()) {
            abort(500);
        }

        $token = $request -> input("token");

        $user = User::where('confirmation_code', $token) -> first();

        $user -> activated = 1;
        $user -> confirmation_code = null;
        $user -> save();

        return view('activated');
    }
}
