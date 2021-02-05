<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $messages = [
            "required" => "The :attribute field is required",
            "string" => "This field supports only strings",
            "max" => "Entry too long",
            "email" => "The email address entered is not valid",
            "unique" => "This credential is is already registered",
            "min" => "Your password must be at least 8 characters",
            "confirmed" => "Passwords don't match"
        ];

        $validator = Validator::make(
            $request->all(),

            [
                "username" => ["required", "string", "max:255", "unique:users"],
                "email" => ["required", "string", "email", "max:255", "unique:users"],
                "password" => ["required", "string", "min:8", "confirmed"]
            ],

            $messages
        );

        if ($validator->fails()) {
            $response = $validator->messages();
        } else {
           /* $response = ["username" => $request->username, "email" => $request->email, "password" => $request->password];*/
            User::create([
                "username" => $request->username,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            $user_id = User::where('email', $request->email)->value('id');
            session(["user_id" => $user_id]);
            $response = ["success" => "Account successfully created", "user_id" => session("user_id")];
        }



        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $user_password = User::where('email', $request->email)->value('password');
        $user_id = User::where('email', $request->email)->value('id');

        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'These credentials do not match our records.',
        ];

        $validator = Validator::make(
            $request->all(),

            [
                'email' => ['required', 'email', 'exists:mysql.users,email'],
                'password' => ['required', function ($attribute, $value, $fail) use ($user_password) {
                    if(!\Hash::check($value, $user_password)) {
                        return $fail(__('Your password entry is incorrect.'));
                    }
                }],
            ],

            $messages

        );

        if ($validator->fails()) {
            $Response = $validator->messages();
        } else {
            session(["user_id" => $user_id]);
            $Response = ["success" => "Action successful", "user_id" => $user_id];
        }

        return response()->json($Response, 200);
    }
}
