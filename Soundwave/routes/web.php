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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/song/upload', [App\Http\Controllers\HomeController::class, 'upload']);
Route::get('/my/playlists', [App\Http\Controllers\HomeController::class, 'view_playlist']);
Route::get('/playlist/create', [App\Http\Controllers\HomeController::class, 'create_playlist']);
Route::get('/login', [App\Http\Controllers\HomeController::class, 'login']);
Route::get('/register', [App\Http\Controllers\HomeController::class, 'register']);
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
Route::get("/download/{song}", [App\Http\Controllers\SongController::class, 'download']);
Route::get("/get/file/{song}", [App\Http\Controllers\SongController::class, 'get_file']);
Route::get("/my/{playlist_name}/playlist/{user_id}", [App\Http\Controllers\HomeController::class, 'get_playlist']);
Route::get("/listen/to/{song}/by/{artist}", [App\Http\Controllers\SongController::class, 'listen']);
Route::post('/playlist/create', [App\Http\Controllers\PlaylistController::class, 'create']);
Route::post('/playlist/add', [App\Http\Controllers\PlaylistController::class, 'add']);
Route::post('/add/to/playlist', [App\Http\Controllers\PlaylistController::class, 'add_song']);
Route::post('/update/playlist/art', [App\Http\Controllers\PlaylistController::class, 'update_art']);
Route::post('/update/playlist/name', [App\Http\Controllers\PlaylistController::class, 'update_name']);
Route::post('/upload', [App\Http\Controllers\SongController::class, 'upload']);
Route::post('/register/user', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/user/login', [App\Http\Controllers\UserController::class, 'login']);
Route::delete('/playlist/delete', [App\Http\Controllers\PlaylistController::class, 'delete']);
Route::delete('/playlist/update/delete', [App\Http\Controllers\PlaylistController::class, 'playlist_delete']);

