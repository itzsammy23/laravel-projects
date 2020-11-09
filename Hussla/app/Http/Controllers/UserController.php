<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comments;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function show() {
        return view('user.success');
    }

    public function home() {
        session(["user_agent" => null, "logged_in" => false, 'customer_id' => null]);
        return view('welcome');
    }

    public function view(Request $request) {
        $user_name = $request->route('user');
        $stripped = Str::of($user_name)->replace('-', ' ');
        $user = User::where('fullname', $stripped)->get()->first();

        checkSubscription($user);
        return view('user.profile', compact('user'));
    }
    public function index() {
        return view('user.search');
    }

    public function search() {
            $specialize = ucfirst(request('service'));
            $state = ucfirst(request('state'));
            $area = ucfirst(request('area'));

            $users = User::where([
                ['specialize', $specialize],
                ['state', $state],
                ['area', $area],
                ['isEligible', 'true'],
            ])->paginate(10);

           return view('user.result', compact('users', 'state', 'specialize'));
    }

    public function find() {
        $search_param = request('parameter');
        $users = User::where('firstname', 'like', "{$search_param}%")
        ->orWhere('businessname', 'like', "{$search_param}%")->paginate(10);

        return view('user.find', compact('users'));
    }

    public function post(User $user) {
            request()->validate([
                'comment' => 'required',
            ]);
            $details = request('customerdetails');
            $comment = request('comment');

            Comments::create([
                'user_id' => $user->id,
                'customer' => $details,
                'comment' => $comment,
            ]);
                session(['posted' => 'true']);
            return redirect("/view/profile/{$user->id}");

    }

    public function comments(User $user) {

        $comments = Comments::whereIn('user_id', [$user->id])->paginate(15);
        $user_name = "$user->firstname {$user->lastname}";
        session(['user' => $user_name]);
        return view('user.comment', compact('comments'));

    }

    public function searchRadius(Request $request)
    {
        $specialize = ucfirst($request->specialize);
        $state = ucfirst($request->state);
        $area = ucfirst($request->radiuslocation);

        $users = User::where([
            ['specialize', $specialize],
            ['state', $state],
            ['area', $area],
            ['isEligible', 'true'],
        ])->paginate(10);

        return view('user.result', compact('users', 'state', 'area', 'specialize'));
    }

    public function tester()
    {
        return  view('layouts.tester');
    }


}

