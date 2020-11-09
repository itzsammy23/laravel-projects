<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Referral;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $full_name = Str::lower(auth()->user()->fullname);
        $replace = Str::of($full_name)->replace(' ', '-');
        return redirect("/profile/{$replace}");
    }


    public function random() {
        $id =request()->route('user');

        session(["requested_referral" => true]);
        return redirect("/profile/{$id}");
    }

    public function redirect() {
        $token = request()->route('token');
        $id = Referral::where('referral_id', $token)->pluck('user_id')->first();
        session(["id" => $id]);

        return redirect('/register');
    }

    /*public function download()
    {
        $file = request()->route('file');
        $filepath = public_path()."/files/{$file}";
        return Response::download("{$filepath}", "{$file}");
    }*/
}
