<?php

use Illuminate\Support\Facades\Route;
use App\User;

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

Route::get('/', 'UserController@home');

Auth::routes(['verify' => true]);

Route::get('/mail', function () {
    $user = User::where('hussla_id', '4ccizsk2UxMqGrojcfeB')->get()->first();
        return new App\Mail\NotifyFreeSub($user);
});

Route::get('/search-data', 'AjaxController@searchDatabase')->name('search-data');
Route::get('/tester', 'UserController@tester');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user}', 'UserController@view')->name('profile.show');
Route::get('/request/referral-link/{user}', 'HomeController@random');
Route::get('/refer/token/{token}', 'HomeController@redirect');
Route::get('/account/created-success', 'UserController@show')->middleware('verified');
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit')->middleware('auth');
Route::get('/servicefinder', 'UserController@index');
Route::get('/view/profile/{user}', 'ProfileController@view');
Route::get('/search/result', 'UserController@search');
Route::get('/find/user', 'UserController@find');
Route::get('/customer/register', 'CustomerController@register');
Route::get('/customer/login', 'CustomerController@login');
Route::get('/customer/login/comment/{user}', 'CommentsController@login');
Route::get('/rate/service/{user}', 'ProfileController@save');
Route::get('/view/comments/{user}', 'UserController@comments');
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
Route::get('/view/favorites/{customer}', 'FavoritesController@view');
Route::post('/add/favorite/{customer}', 'FavoritesController@add');
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::post('/profile/{user}/edit', 'ProfileController@store');
Route::post('/customer/registered', 'CustomerRegisterController@register');
Route::post('/login/success', 'CustomerController@redirect');
Route::post('/login/success/{user}', 'CommentsController@redirect');
Route::post('/post-data', 'AjaxController@ajax')->name('ajax');
Route::post('/view/profile/{user}', 'UserController@post')->middleware('loggedin');
Route::patch('/profile/{user}', 'ProfileController@update')->name('profile.update');
Route::delete('/delete/favorite', 'FavoritesController@delete')->name('delete');
