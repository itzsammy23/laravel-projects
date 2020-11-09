<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActivityController extends Controller
{
    public function category()
    {
        $response = Http::withBasicAuth('', '')
            ->get('https://api.toshl.com/categories');

        $category = $response->json();
       return view('activity.category', compact('category'));
    }

    public function tag()
    {
        $response = Http::withBasicAuth('', '')
            ->get('https://api.toshl.com/tags');

        $tags = $response->json();
        return view('activity.tag', compact('tags'));
    }

    public function account()
    {
        $response = Http::withBasicAuth('', '')
            ->get('https://api.toshl.com/accounts');

        $accounts = $response->json();
        return view('activity.account', compact('accounts'));
    }

    public function create()
    {
        return view('activity.create');
    }


    public function entry(Request $request)
    {
        $request->validate([
            "amount" => ['required', 'integer'],
            "code" => ['required', 'string'],
            "account" => ['required', 'integer'],
            "category" => ['required', 'integer'],
        ]);

       $response = Http::withBasicAuth('', '')
           ->post('https://api.toshl.com/entries',[
               "amount" => $request->amount,
               "currency" => [
                   "code" => $request->code,
               ],
               "date" => date('Y-m-d'),
               "account" => $request->account,
               "category" => $request->category,
           ]);


        $location = $response->header("location");
        $entry_id = substr($location, 9);

        auth()->user()->entry()->create([
            "entry_id" => $entry_id,
        ]);

        session(["id" => $entry_id]);
        return redirect("/home");
    }

}
