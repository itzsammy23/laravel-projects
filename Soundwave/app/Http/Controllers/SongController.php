<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SongController extends Controller
{
    public function relate()
    {
       dd(session('user_id'));
    }

    public function get()
    {
        $songs = Song::all();

        return response()->json(['songs' =>  $songs], 200)->withHeaders([
            "Content-Type" => "application/json",
            "Access-Control-Allow-Origin" => "*",
        ]);
    }

    public function show(Request $request)
    {
        $song_name = Str::of($request->route('name'))->replace('-', ' ');
        $song = Song::where('name', $song_name)->get();
        $type = "application/json";
        $range = "bytes 100-1000/*";

        return response()->json(['song' =>  $song, 'index'  => $request->song_index], 200)->withHeaders([
            "Content-Type" => $type,
            "Content-Range" => $range,
            "Access-Control-Allow-Origin" => "*",
        ]);
    }

    public function index()
    {
        $songs = Song::all();
        return view('songs.index', compact('songs'));
    }

    public function find(Request $request)
    {
        $song_id = $request->route('song_id');
        $song_name = \App\Models\Song::where('id', $song_id)->value('song_file');
        $path = "storage/songs/".$song_name;
        $headers = [
            "Content-Range"=> "bytes 100-10000/*",
        ];
        return response()->file($path, $headers);
    }

    public function findSong(Request $request)
    {
        $song_id = $request->route("song_id");
        $song_name = Song::where('id', $song_id)->value("song_file");

        return response()->json(["name" => $song_name], 200);
    }

    public function check(Request $request)
    {
        $search_value = $request->add_new_song;
        $songs = Song::where("name", "like", "{$search_value}%")->get();

        return response()->json(['songs' => $songs], 200);
    }

    public function upload(Request $request)
    {
        $user = User::find(1);
       $data = [
           "name" =>  $request->song_name,
           "artist" => $request->artist,
           "genre" => $request->genre,
           "album" => $request->album,
           "release_year" => $request->release_year,
           "song_file" => $request->file->getClientOriginalName(),
           "cover_art" => ""
       ];

       $original_name = $request->file('file')->getClientOriginalName();
       $request->file->storeAs("songs", "{$original_name}", "public");

       if ($request->cover_art){
           $original_cover =  $request->file('cover_art')->getClientOriginalName();
          $request->cover_art->storeAs("cover_art", "{$original_cover}", "public");

        $cover_art = ["cover_art" => $original_cover];
       }

       $user->upload()->create(array_merge(
           $data,
           isset($cover_art) ? $cover_art : []
       ));

       return  response()->json(["success" =>  $request->file('file')->isValid()],  200);
    }

    public function player()
    {
        return view("songs.player");
    }

}
