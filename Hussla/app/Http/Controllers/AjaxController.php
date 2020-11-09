<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AjaxController extends Controller
{

    public function ajax(Request $request)
    {
        $customer_email = Customer::where('email', $request->email)->value('password');

        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The email address entered is not valid.',
            'exists' => 'These credentials do not match our records.',
        ];

        $validator = Validator::make(
            $request->all(),

            [
                'email' => ['required', 'email', 'exists:mysql.customers,email'],
                'password' => ['required', function ($attribute, $value, $fail) use ($customer_email) {
                    if(!\Hash::check($value, $customer_email)) {
                        return $fail(__('Your password entry is incorrect.'));
                    }
            }],
            ],

            $messages

        );

        if ($validator->fails()) {
            $Response = $validator->messages();
        } else {
            $Response = ["success" => "Action successful"];
        }

        return response()->json($Response, 200);
    }

    public function searchDatabase(Request $request)
    {
            $query= $request->parameter;

            $users = User::where("businessname", "like", "{$query}%")
                ->orWhere("businessaddress", "like", "{$query}%")->paginate(3);

            $Response = ["users" => $users];

            return response()->json($Response, 200);
    }
}
