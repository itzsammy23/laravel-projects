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
       dd(base_path('public_html'));
    }

    public function get()
    {
        $songs = Song::orderBy("id", "desc")->get();

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
        $search_value = $request->value;
        $songs = Song::where("name", "like", "{$search_value}%")->get();

        return response()->json(['songs' => $songs], 200);
    }

    public function upload(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $request_song_name = Str::of($request->song_name)->lower();
        $song_name = Str::of($request_song_name)->replace(" ", "-");
        $song_file = $song_name."_".time().".mp3";
       $data = [
           "name" =>  $request->song_name,
           "artist" => $request->artist,
           "genre" => $request->genre,
           "album" => $request->album,
           "release_year" => $request->release_year,
           "song_file" => $song_file,
           "cover_art" => ""
       ];



       $request->file->storeAs("songs", "{$song_file}", "public");

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

    public function download(Request $request)
    {
        $song_name = Str::of($request->route("song"))->replace("-", " ");
        $song_file = Song::where("name", $song_name)->value("song_file");

        $path = "storage/songs/".$song_file;
        $song = $request->route("song").".mp3";
        return response()->download($path, $song);
    }

    public function get_file(Request $request)
    {
        $song_name = Str::of($request->route("song"))->replace("-", " ");
        $song_file = Song::where("name", $song_name)->value("song_file");

        return response()->json(["file" => $song_file], 200);
    }

    public function listen(Request $request)
    {

        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $song_stripped = Str::of($request->route("song"))->replace("-", " ");
        $artist_stripped = Str::of($request->route("artist"))->replace("-", " ");
        $artiste = splitName($artist_stripped);
        $song = splitName($song_stripped);
        $db_cover_art = Song::where([
            ["name", "$song"],
            ["artist", "$artiste"]
        ])->value("cover_art");


        if ($db_cover_art === "" || $db_cover_art === null) {
            $cover_art = "/storage/cover_art/record-33583_640.png";
        }else {
            $cover_art = "/storage/cover_art/" .$db_cover_art;
        }

        $data = [
            "has_song" => true,
            "song" => $song,
            "view_mode" => 5,
            "cover_art" => $cover_art,
            "artist" => $artiste,
            "has_item" => false
            ];

        return view("songs.index", compact("songs", "data"));
    }

}
