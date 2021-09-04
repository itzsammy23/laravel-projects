<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function get() {
        $json_file = Storage::disk("public")->get("products.json");
        $decoded = json_decode($json_file, true);

        return response()->json(["data" => $decoded], 200);
    }

    public function add(Request $request) {
            $fields = [
                "name" => $request->product_name,
                "quantity_in_stock" => $request->quantity,
                "price" => $request->price,
                "date_submitted" => date("Y-m-d h:ia")
            ];


            //Storage::disk('public')->put("products.json", json_encode($fields));

            $json_file = Storage::disk("public")->get("products.json");
            $decoded = json_decode($json_file, true);

            if ($decoded == null) {
                $decoded = [$fields];
            } else{
                $new_entry = count($decoded);
                $decoded[$new_entry] = $fields;
            }

            Storage::disk('public')->put("products.json", json_encode($decoded));

            return response()->json(['data' => $decoded], 200);
    }

    public function edit (Request $request) {
        $fields =  $fields = [
                "name" => $request->product_name,
                "quantity_in_stock" => $request->quantity,
                "price" => $request->price,
                "date_submitted" => date("Y-m-d h:ia")
            ];

        $index = intval($request->array_index);

        $json_file = Storage::disk("public")->get("products.json");
        $decoded_file = json_decode($json_file, true);

        $decoded_file[$index] = $fields;

        Storage::disk('public')->put("products.json", json_encode($decoded_file));

        return response()->json(['data' => $decoded_file], 200);
    }
}
