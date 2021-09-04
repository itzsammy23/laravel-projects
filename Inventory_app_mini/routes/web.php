<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get("/get", [App\Http\Controllers\ProductController::class, 'get']);
Route::post("/add", [App\Http\Controllers\ProductController::class, 'add']);
Route::patch("/edit", [App\Http\Controllers\ProductController::class, 'edit']);

