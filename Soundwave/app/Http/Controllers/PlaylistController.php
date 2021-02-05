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
        $user_id = session("user_id");
        $rows = DB::table('playlist_user')->where('user_id', $user_id)->count();

        if ($user_id === null) {
            return response()->json(["session_expired" => "Your session has expired", "user_id" => $user_id], 200);
        } else{
            if ($rows == 0){
                return response()->json(["no_results" => "No playlists created", "user_id" => $user_id], 200);
            } else{

                $playlists = DB::table('playlist_user')->where('user_id', $user_id)->get();
                $playlist_array = [];
                $i = 0;

                foreach ($playlists as $playlist) {
                    $song_count = Playlist::where("name", $playlist->playlist_name)->count();
                    $playlist_array[$i] = [
                        "name" => $playlist->playlist_name,
                        "song_count" => $song_count,
                        "playlist_art" => $playlist->playlist_art
                    ];
                    $i++;
                }

                return response()->json($playlist_array, 200);
            }
        }


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
        $playlist_art = $request->playlist_art;
        $user_id = session("user_id");
        $data = [
            "user_id" => $user_id,
            "playlist_name" => $playlist_name,
            "playlist_art" => ""
        ];

        if ($playlist_art != null) {
            $art = $request->file("playlist_art")->getClientOriginalName();
            $playlist_art->storeAs("cover_art", "$art", "public");

            $art_array = ["playlist_art" => $art];
        }
        DB::table('playlist_user')->insert(array_merge($data,
        isset($art_array) ? $art_array : []
        ));
    }

    public function add(Request $request)
    {
        $song_name = $request->song_name;
        $playlist_name = $request->playlist_name;
        $user_id = session("user_id");
        $user = User::find($user_id);

        $song_id = Song::where("name", $song_name)->value("id");

        $user->playlist()->create([
            "song_id" => $song_id,
            "name" => $playlist_name
        ]);
    }

    public function add_song(Request $request)
    {
        $songs = $request->songs;
        $playlist_name = $request->playlist_name;
        $user_id =
            n("user_id");
        $user = User::find($user_id);

        for ($i = 0; $i < count($songs); $i++) {
            $song_id = Song::where("name", $songs[$i])->value("id");

            $user->playlist()->create([
                "song_id" => $song_id,
                "name" => $playlist_name
            ]);
        }

        return response()->json(["success" => "Action successful"], 200);
    }

    public function update_art(Request $request)
    {
        $image = $request->file("image")->getClientOriginalName();
        $playlist_name = $request->playlist_name;
        $user_id = $request->user_id;
        $request->image->storeAs("cover_art", "{$image}", "public");

        DB::table("playlist_user")->where([
            ["user_id", $user_id],
            ["playlist_name", $playlist_name]
        ])->update(["playlist_art" => $image]);

        return response()->json(["playlist_art" => "/storage/cover_art/".$image], 200);
    }

    public function update_name(Request $request)
    {
        $old_playlist_name = $request->old_playlist_name;
        $new_playlist_name = $request->new_playlist_name;
        $user_id = $request->user_id;
        $user = User::find($user_id);

        DB::table("playlist_user")->where([
            ["user_id", $user_id],
            ["playlist_name", $old_playlist_name]
        ])->update(["playlist_name" => $new_playlist_name]);

        $user->playlist()->where("name", $old_playlist_name)->update([
            "name" => $new_playlist_name
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

    public function test()
    {
        return view("songs.tester");
    }

    public function playlist_delete(Request $request)
    {
        $playlist_name = $request->playlist_name;
        $user_id = $request->user_id;
        $user = User::find($user_id);

        $user->playlist()->where("name", $playlist_name)->delete();

        DB::table("playlist_user")->where([
            ["user_id", $user_id],
            ["playlist_name", $playlist_name]
        ])->delete();
    }

    public function delete(Request $request)
    {
        $song_name = $request->song_name;
        $playlist_name = $request->playlist_name;
        $user_id = $request->user_id;
        $song_id = Song::where('name', $song_name)->value("id");

        Playlist::where([
            ["song_id", $song_id],
            ["user_id", $user_id],
            ["name", $playlist_name]
        ])->delete();

        return response()->json([
            "deleted" => "Successfully deleted",
        ], 200);
    }


}
