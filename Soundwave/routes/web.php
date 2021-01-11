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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/relation', [App\Http\Controllers\SongController::class, 'relate']);
Route::get('/index', [App\Http\Controllers\SongController::class, 'index'])->name('index');
Route::get('/player', [App\Http\Controllers\SongController::class, 'player'])->name('player');
Route::get('/find/song', [App\Http\Controllers\SongController::class, 'check']);
Route::get('/songs', [App\Http\Controllers\SongController::class, 'get']);
Route::get('/song/{name}', [App\Http\Controllers\SongController::class, 'show'])->name('song');
Route::get('/song/find/{song_id}', [App\Http\Controllers\SongController::class, 'find']);
Route::get('/song/find/name/{song_id}', [App\Http\Controllers\SongController::class, 'findSong']);
Route::get('/view/playlist', [App\Http\Controllers\PlaylistController::class, 'view']);
Route::get('/playlist/song/find/{song_id}', [App\Http\Controllers\PlaylistController::class, 'find']);
Route::get('/playlist/song/{song_name}', [App\Http\Controllers\PlaylistController::class, 'show']);
Route::get('/playlist/{playlist}', [App\Http\Controllers\PlaylistController::class, 'playlist']);
Route::post('/playlist/create', [App\Http\Controllers\PlaylistController::class, 'create']);
Route::post('/playlist/add', [App\Http\Controllers\PlaylistController::class, 'add']);
Route::post('/upload', [App\Http\Controllers\SongController::class, 'upload']);
Route::post('/register/user', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/user/login', [App\Http\Controllers\UserController::class, 'login']);
