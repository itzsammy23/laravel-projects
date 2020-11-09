<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function register() {
        return view('customer.register');
    }

    public function login() {
        return view('customer.login');
    }


    protected function redirect() {
        $email = request('email');
        $customer_firstname = Customer::whereIn('email', [$email])->value('firstname');
        $customer_lastname = Customer::whereIn('email', [$email])->value('lastname');
        $customer_email = Customer::where('email', request('email'))->value('password');
        $customer_id = Customer::where('email', $email)->value('id');

        request()->validate([
            'email' => ['required', 'email', 'exists:mysql.customers,email'],
            'password' => ['required', function ($attribute, $value, $fail) use ($customer_email) {
                if(!\Hash::check($value, $customer_email)) {
                    return $fail(__('Your password entry is incorrect.'));
                }
            }]
        ]);

        $customer_name = "$customer_firstname {$customer_lastname}";
        session(['user_agent' =>  $customer_name, 'logged_in' => true, 'customer_id' => $customer_id]);
        return redirect("/servicefinder");
}

}

