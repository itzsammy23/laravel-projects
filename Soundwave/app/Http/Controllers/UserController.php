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
            "unique" => "This email address is already registered",
            "min" => "Your password must be at least 8 characters",
            "confirmed" => "Passwords don't match"
        ];

        $validator = Validator::make(
            $request->all(),

            [
                "name" => ["required", "string", "max:255"],
                "email" => ["required", "string", "email", "max:255", "unique:users"],
                "password" => ["required", "string", "min:8", "confirmed"]
            ],

            $messages
        );

        if ($validator->fails()) {
            $response = $validator->messages();
        } else {
            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            $response = ["success" => "Account successfully created"];
        }

        $user_id = User::where('email', $request->email)->value('id');
        session(["user_id" => $user_id]);

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $user_email = User::where('email', $request->email)->value('password');
        $user_id = User::where('email', $request->email)->value('id');

        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The email address entered is not valid.',
            'exists' => 'These credentials do not match our records.',
        ];

        $validator = Validator::make(
            $request->all(),

            [
                'email' => ['required', 'email', 'exists:mysql.users,email'],
                'password' => ['required', function ($attribute, $value, $fail) use ($user_email) {
                    if(!\Hash::check($value, $user_email)) {
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
            $Response = ["success" => "Action successful"];
        }

        return response()->json($Response, 200);
    }
}
