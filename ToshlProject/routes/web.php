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
    return view('welcome');
});


Route::get('/category', 'ActivityController@category');
Route::get('/account', 'ActivityController@account');
Route::get('/create/entry', 'ActivityController@create')->middleware('auth');
Route::get('/tag', 'ActivityController@tag');
Route::post('/entry', 'ActivityController@entry');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('cors');
