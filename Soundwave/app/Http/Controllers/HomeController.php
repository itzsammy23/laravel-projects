<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function index()
    {
        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $data = ["view_mode" => 0, "has_song" => false, "has_item" => false];
        return view('songs.index', compact("data", "songs"));
    }

    public function upload()
    {
        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $data = ["view_mode" => 6, "has_song" => false, "has_item" => false];
        return view('songs.index', compact("data", "songs"));
    }

    public function view_playlist()
    {
        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $data = ["view_mode" => 3, "has_song" => false, "has_item" => false];
        return view('songs.index', compact("data", "songs"));
    }

    public function create_playlist()
    {
        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $data = ["view_mode" => 1, "has_song" => false, "has_item" => false];
        return view('songs.index', compact("data", "songs"));
    }

    public function get_playlist(Request $request)
    {
        $user_id = $request->route("user_id");
        $playlist_name = Str::of($request->route("playlist_name"))->replace("-", " ");
        $playlist_db_image = DB::table("playlist_user")->where([
            ["user_id", $user_id],
            ["playlist_name", $playlist_name]
        ])->value("playlist_art");

        if ($playlist_db_image === "" || $playlist_db_image === null) {
            $cover_art = "/storage/cover_art/record-33583_640.png";
        }else {
            $cover_art = "/storage/cover_art/" .$playlist_db_image;
        }

        $data = [
            "view_mode" => 4,
            "has_song" => false,
            "has_item" => true,
            "playlist_name" => $playlist_name,
            "playlist_art" => $cover_art
        ];

        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        return view('songs.index', compact("data", "songs"));
    }

    public function login()
    {
        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $data = ["view_mode" => 7, "has_song" => false, "has_item" => false];
        return view('songs.index', compact("data", "songs"));
    }

    public function register()
    {
        $songs = Song::orderBy("id", "desc")->limit(5)->get();
        $data = ["view_mode" => 8, "has_song" => false, "has_item" => false];
        return view('songs.index', compact("data", "songs"));
    }
}
