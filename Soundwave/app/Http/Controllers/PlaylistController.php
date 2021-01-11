<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlaylistController extends Controller
{
    public function view()
    {
        $playlists = DB::table('playlist_user')->where('user_id', 1)->get();

        return response()->json($playlists, 200);
    }

    public function show(Request $request)
    {
        $playlist_song = Str::of($request->route('song_name'))->replace('-', ' ');
        $song = Song::where('name', $playlist_song)->get();


        return response()->json(['song' =>  $song, 'index'  => $request->song_index, 'playlist' => $request->playlist_title], 200)->withHeaders([
            "Access-Control-Allow-Origin" => "*",
        ]);
    }


    public function playlist(Request $request)
    {
        $playlist = $request->route('playlist');
        $values = Playlist::where('name', $playlist)->get();
        $songarray = [];
        $i = 0;

        foreach ($values as $value) {
            $id = $value->song_id;
            $songs = Song::where('id', $id)->get();

            foreach ($songs as $song){
                $songarray[$i] = $song;
                $i++;
            }
        }

        return response()->json($songarray, 200);
    }

    public function create(Request $request)
    {
        $playlist_name = $request->playlist_name;
        DB::table('playlist_user')->insert([
            "user_id" => 1,
            "playlist_name" => $playlist_name
        ]);
    }

    public function add(Request $request)
    {
        $song_name = $request->song_name;
        $playlist_name = $request->playlist_name;
        $user = User::find(1);

        $song_id = Song::where("name", $song_name)->value("id");

        $user->playlist()->create([
            "song_id" => $song_id,
            "name" => $playlist_name
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

}
