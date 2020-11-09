<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function add(Customer $customer, Request $request)
    {
        $favorite = $customer->favorite()->create([
            'user' => $request->username,
            'specialization' => $request->specialize,
            'area' => $request->area,
            'number' => $request->number,
        ]);

        return response()->json($favorite, 200);
    }

    public function view(Customer $customer)
    {
        return view('favorites.view', compact('customer'));
    }

    public function delete(Request $request)
    {
        Favorite::where([
            ['id', $request->id],
            ['customer_id', $request->customer_id]
        ])->delete();

        return redirect("/view/favorites/{$request->customer_id}");
    }
}
