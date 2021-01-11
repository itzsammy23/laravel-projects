Amplitude.init({
        songs: [
            {
                "name": "Jailer",
                "artist": "Asa",
                "album": "Single",
                "url":  "/song/find/1",
                "cover_art_url": "/storage/cover_art/",

        }
        ]
    ,
    visualizations: [
        {
            object: MichaelBromleyVisualization,
            params: {

            }
        }
    ],
    waveforms: {
            sample_rate: 3000
    },
    visualization: "michaelbromley_visualization",
    "default_album_art":  "/storage/cover_art/record-33583_640.png",
    "default_playlist_art": "/storage/cover_art/music-154176_640.png"
});
var playlists = [], run_count = 0;
var letters = /^[A-Za-z]+$/;
var visualizer
/*$("#mode-toggler").prop("checked", true);*/

$(document).ready(function () {

    $('.song').remove();
    loadSongs();

    if (localStorage.getItem("mode") == null) {
        localStorage.setItem("mode", "light");
    }

    if (localStorage.getItem("mode") == "light")  {
        loadLightMode();
    }

    if (localStorage.getItem("mode") == "dark") {
        loadDarkMode();
        $("#mode-toggler").prop("checked", true);
    }

    console.log(localStorage.getItem("mode"))

    $("#mode-toggler").click(function () {
        if ($(".track-mod").hasClass("mode")) {
            console.log("True")
            $(".track-mod").removeClass("mode");
            $(".artiste").removeClass("mode-alt");
            loadDarkMode();
            localStorage.setItem("mode", "dark");
        }else{
            $(".track-mod").removeClass("dark-theme");
            $(".artiste").removeClass("dark-theme");
            loadLightMode();
            localStorage.setItem("mode", "light");
        }
       /* console.log(localStorage.getItem("mode"))*/
    })


    $(document).on("click", ".song-title", function () {
        var song_title = $(this).text().toLowerCase().replace(/\s/g, "-");
        var song_index =  $(".song-title").index(this) + 1;
        $('#content-holder').text('');
        $(".landing").hide();

        $.ajax({
            type: "GET",
            url: "/song/" +song_title,
            data: {
                song_index: song_index,
            },
            success: function (response) {
                console.log(response)
                Amplitude.playSongAtIndex(response.index);
                $(".song-player").show()

                $(".play-pause i").removeClass("bx-play");
                $(".play-pause i").addClass("bx-pause");

                setSongAttributes();
                refreshSongDetails();
                setInterval(checkPosition, 100)

            }
        })


    });

        $(document).on("click", ".switch", function () {
            setSongAttributes();
            refreshSongDetails();
        })


    $(document).on("click", ".pause-song", function () {
        Amplitude.pause();
    })

    $(document).on("click", ".create-playlist", function () {
        $('#content-holder').text('');

        $('#content-holder').append(`
        <form method="post" id="create-playlist" data-route="/create/playlist">
            <div class="form-group">
            <label for="playlist-name" class="col-md-3 col-form-label">Playlist name</label>
                <div class="col-md-9">
                       <input type="text" id="playlist-name" name="playlist-name" class="form-control">
                </div>
            </div>

                <div class="form-group">
            <label for="add-new-song" class="col-md-3 col-form-label">Add Song</label>
                <div class="col-md-9 d-flex">
                       <input type="text" id="add-new-song" name="add_new_song" class="form-control w-85">
                       <button id="add-song" class="btn btn-secondary ml-1">Add</button>
                </div>
                <div class="show-songs"></div>
            </div>
            <div class="songs-added ml-2 mb-3 col-md-12 d-flex"></div>

            <button type="submit" id="playlist-submit-button" class="btn btn-primary ml-3">Create Playlist</button>
        </form>
        `)
    })

    $(document).on("keyup", "#add-new-song", function () {
        if ($(this).val().length >= 3){
            $('.song-results').remove();
            $('.danger-class').remove();
            $.ajax({
                type: "GET",
                url: "/find/song",
                data: {
                    add_new_song: $(this).val(),
                },
                success: function (response) {
                    console.log(response.songs.length);
                    if (response.songs.length == 0){
                        $('.show-songs').append(`
                             <div class="alert alert-danger danger-class">
                                <p>Song not found</p>
                            </div>
                             `);
                    }else{
                        for (var i = 0; i < response.songs.length; i++){
                                $('.show-songs').append(`
                                <div class="song-results">
                                   <p><span class="search-title"><b>${response.songs[i].name}</b></span> by <b>${response.songs[i].artist}</b></p>
                                </div>
                                `);
                             }
                    }
                        // //
                }
            })


        }
    })

    $(document).on("click", ".song-results", function () {
        var index = $(this).find("span").text();


        $('#add-new-song').val(index);
        $('.song-results').remove();
    });

    $(document).on("click", "#add-song", function (e) {
        e.preventDefault();

        if($('#add-new-song').val() == "" || $('#add-new-song').val().length < 3 || $('.show-songs').text() == "Song not found"){
            return false;
        }else{
            $('.songs-added').append(`
            <div class="appended-song mr-2 d-flex"><span class="appended-song-name">${$('#add-new-song').val()}</span>
             <span class="delete-selection">X</span></div>
            `)


            $('#add-new-song').val("");
        }
    })

    $(document).on("click", ".delete-selection", function () {
        var delete_selection = $('.delete-selection').index(this);
        $('.appended-song').eq(delete_selection).remove();
    })

    $(document).on("click", "#playlist-submit-button", function (e) {
        e.preventDefault();

        if ($('#playlist-name').val() == "" || $('#playlist-name').val().length < 3
            || $('.songs-added').text() == "" ||  $('.show-songs').text() == "Song not found") {
            return false;
        }else{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/playlist/create",
                data: {
                    playlist_name: $('#playlist-name').val(),
                },
            })

            for (var i  = 0; i < $('.appended-song-name').length; i++) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/playlist/add",
                    data: {
                        playlist_name: $('#playlist-name').val(),
                        song_name: $('.appended-song-name').eq(i).text(),
                    }
                })
            }

        $('.songs-added').text("");
        $('.songs-added').append(`
                <div class="alert alert-success">Playlist Created</div>
        `);

            setTimeout(function () {
                    $('#content-holder').text('');
                    loadSongs()
                    }, 1500)
        }
    })

    $(document).on("click", ".view-playlist", function () {
        $('#content-holder').text("");

        viewPlaylist();
    })

    $(document).on("click", ".playlist-name", function () {
       var playlist = $(this).text();
       var playlist_object = playlist.toLowerCase().replace(/\s/g, "_");
       $('#content-holder').text("");


       $.ajax({
           url: "/playlist/" + playlist,
           method:  "GET",
           success:  function (response) {
               Amplitude.addPlaylist(playlist_object, { "playlist_key" : playlist}, [{
                   "name": response[0].name,
                   "artist": response[0].artist,
                   "album": response[0].album,
                   "url":  "/song/find/" + response[0].id,
                   "cover_art_url": "/storage/cover_art/" + response[0].cover_art
               }]);

               $('#content-holder').append(`
                                <div class="mb-3 col-md-12" id="playlist-title"><h2 class="playlist-title" style="text-align: center">${playlist}</h2></div>
                            <div class="mb-3 d-flex" align="center"><button id="go-back" class="go-back btn btn-dark mb-3 float-left">Back</button>
                             <div class="control-buttons ml-1">
                                <button class="btn btn-primary mr-2 amplitude-play" data-amplitude-playlist="${playlist_object}">Play All</button>
                                <button class="btn btn-secondary mr-2 amplitude-pause" data-amplitude-playlist="${playlist_object}">Pause</button>
                                <button class="btn btn-dark mr-2 amplitude-shuffle" data-amplitude-playlist="${playlist_object}">Shuffle</button>
                        </div>
                        </div>

                        `);

               Amplitude.bindNewElements();

               for (var i = 0;  i < response.length; i++)  {
                   var  index = i+1;
                   if (index != response.length){
                       Amplitude.addSongToPlaylist({
                           "name": response[index].name,
                           "artist": response[index].artist,
                           "album": response[index].album,
                           "url":  "/song/find/" + response[index].id,
                           "cover_art_url": "/storage/cover_art/" + response[index].cover_art
                       }, playlist_object)
                   }

                   $('#content-holder').append(`
                        <div class="col-md-12 p-4 song mt-3">
                            <h3 class="song-title-playlist" data-playlist="${playlist_object}">${response[i].name}</h3>
                            <h5>${response[i].artist}</h5>
                        </div>
                    `);
               }
           }
       })
    })

    $(document).on("click", ".song-title-playlist", function () {
        var song_title = $(this).text().toLowerCase().replace(/\s/g, "-");
        var song_index =  $(".song-title-playlist").index(this);
        $('#content-holder').text('');
        var playlist_title = $(this).data('playlist');


        $.ajax({
            type: "GET",
            url: "/playlist/song/" +song_title,
            data: {
                song_index: song_index,
                playlist_title: playlist_title
            },
            success: function (response) {
                $('.song-attributes').show();
                Amplitude.playPlaylistSongAtIndex(response.index, response.playlist)

                $('#content-holder').append(`
            <button class="btn btn-dark mr-2 amplitude-shuffle" data-amplitude-playlist="${response.playlist}">Shuffle</button>
            <button class="amplitude-play-pause btn btn-primary" data-amplitude-playlist="${response.playlist}">Play Song</button>
            <input type="range" class="amplitude-song-slider" data-amplitude-playlist="${response.playlist}"/>
            <button class="btn btn-secondary mr-2 amplitude-repeat-song">Repeat</button>
        `)

            Amplitude.bindNewElements();
                setSongAttributes();
                refreshSongDetails();

            }
        })

    });


    $(document).on("click", "#go-back", function () {
        $('#content-holder').text("");
        viewPlaylist();
    });

    $(document).on("click", ".upload-song", function () {
        $('#content-holder').text("");


        $('#content-holder').append(`
        <form method="post" id="upload-song" data-route="/upload">
            <div class="form-group">
            <label for="song-name" class="col-md-3 col-form-label">Song Name</label>
                <div class="col-md-9">
                       <input type="text" id="song-name" name="song-name" class="form-control">
                </div>
            </div>

             <div class="form-group">
            <label for="song-artist" class="col-md-3 col-form-label">Artist(s)</label>
                <div class="col-md-9">
                       <input type="text" id="song-artist" name="song-artist" class="form-control">
                </div>
            </div>

             <div class="form-group">
            <label for="song-genre" class="col-md-3 col-form-label">Genre</label>
                <div class="col-md-9">
                       <select class="form-control" id="song-genre">
                        <option value="Afro pop">Afro pop</option>
                        <option value="Hip hop">Hip pop</option>
                        <option value="Reggae">Reggae</option>
                        <option value="Traditional">Traditional</option>
                        <option value="RnB">RnB</option>
                        </select>
                </div>
            </div>

             <div class="form-group">
            <label for="song-release-year" class="col-md-3 col-form-label">Release year</label>
                <div class="col-md-9">
                       <input type="number" id="song-release-year" name="song-release-year" class="form-control">
                </div>
            </div>

            <div class="form-group">
            <label for="song-album" class="col-md-3 col-form-label">Album</label>
                <div class="col-md-9">
                       <input type="text" id="song-album" name="song-album" class="form-control">
                </div>
            </div>

            <div class="form-group">
            <label for="song-name" class="col-md-3 col-form-label">Song file</label>
                <div class="col-md-9">
                       <input type="file" id="song-file" name="song-file">
                </div>
            </div>

             <div class="form-group">
            <label for="song-cover-art" class="col-md-3 col-form-label">Cover art</label>
                <div class="col-md-9">
                       <input type="file" id="song-cover-art" name="song-cover-art">
                </div>
            </div>

             <div id="error-messages" class="error-messages"></div>
            <button type="submit" id="song-upload-button" class="btn btn-primary ml-3">Upload Song</button>
        </form>
        `)
    });

    $(document).on("keyup", "#song-name", function () {
        var value = $(this).val();
        var selector = $(this);

        validateField(selector, value);
    });

    $(document).on("keyup", "#song-artist", function () {
        var value = $(this).val();
        var selector = $(this);

        validateField(selector, value);
    });

    $(document).on("keyup", "#song-album", function () {
        var value = $(this).val();
        var selector = $(this);

        validateField(selector, value);
    });

    $(document).on("keyup", "#song-release-year", function () {
        var value = $(this).val();
        var selector = $(this);

        validateField(selector, value);

        var lengthValidator = setInterval(function () {
            if (value.toString().length == 4){
                clearInterval(lengthValidator);
                selector.css('border', '1px solid green');
            }else{
                clearInterval(lengthValidator);
                selector.css('border', '1px solid red');
            }
        },  2000);

    });

    $(document).on("click", "#song-upload-button", function (e) {
        e.preventDefault();
        $('.response-message').remove();

        var file = $('#song-file')[0].files[0];
        var cover_art = $('#song-cover-art')[0].files[0];
        var fileName = file.name;
        var extension = fileName.substr((fileName.lastIndexOf('.') +1));

        var  song_name = $('#song-name').val(), song_artist = $('#song-artist').val(), song_genre = $('#song-genre').val(),
            song_release_year = $('#song-release-year').val(), song_album =  $('#song-album').val();

        $('#error-message').remove();

        if (file == null){
            $('#error-messages').append(`<div class="alert alert-danger" id="error-message">No song file selected</div>`)
            return false;
        }

        if (cover_art != null){
            var cover_art_name = cover_art.name;
            var art_extension = cover_art_name.substr((cover_art_name.lastIndexOf(".") +1));

            if (art_extension !=  "jpg" || art_extension != "jpeg" || art_extension != "png"){
                $('#error-messages').append(`<div class="alert alert-danger" id="error-message">Invalid cover art format</div>`)
                return false;
            }
        }

        if (song_name == "" || song_artist == ""  || song_genre == "" ||  song_album == "" || song_release_year == "" ||  file ==  null){
            return false;
        }else{
             var data = new FormData();
             data.append('song_name', song_name)
             data.append('artist',  song_artist)
             data.append('genre', song_genre)
             data.append('album', song_album)
             data.append('release_year', song_release_year)
             data.append('file', file)

            console.log(file);

            if (cover_art != null){
                data.append('cover_art',  cover_art);
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                method: "POST",
                url: $('#upload-song').data('route'),
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function (response) {
                        console.log(response);

                        if (response.success == true){
                            $('#error-messages').append('' +
                                '<div class="alert alert-success response-message">Your song has been successfully uploaded</div>')
                        }else{
                            $('#error-messages').append('' +
                                '<div class="alert alert-danger response-message">Your song could not be uploaded</div>')
                        }
                }
            })

        }

    });

    $('.register-new-user').click(function (e) {
            e.preventDefault();
            $('#content-holder').text('')

            $('#content-holder').append(`
                       <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form method="POST" id="register-form" data-route="/register/user">
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-form-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control " name="name" autofocus>
                                    <span class="invalid-name-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 col-form-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email">
                                    <span class="invalid-email-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                                    <span class="invalid-password-feedback" role="alert"></span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 col-form-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group" id="feedback"></div>

                        <div class="form-group row mb-0 ml-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary register-submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            `)

    })

    $(document).on("click", ".register-submit", function (e) {
        e.preventDefault();
        $('.warning').remove();

        var form_request = $('#register-form');
        validateForm(form_request);
    })

    $('.user-login').click(function (e) {
        e.preventDefault();
        $('#content-holder').text('')

        $('#content-holder').append(`
                       <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <form method="POST" id="login-form" data-route="/user/login">
                        <div class="form-group">
                            <label for="email" class="col-md-4 col-form-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email">
                                    <span class="invalid-email-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                                    <span class="invalid-password-feedback" role="alert"></span>

                            </div>
                        </div>

                        <div class="form-group" id="feedback"></div>

                        <div class="form-group row mb-0 ml-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary login-submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            `)

    })

    $(document).on("click", ".login-submit", function (e) {
        e.preventDefault();
        $('.warning').remove();

        var form_request = $('#login-form');
        validateForm(form_request)
    });
        /*

        $(document).on("click", ".solo-play", function () {
            $(this).toggleClass("is-playing");

            if ($(".solo-play").hasClass("is-playing")){
                Amplitude.pause();

            }else{
                if(Amplitude.getSongPlayedPercentage() == 100)   {
                    Amplitude.playSongAtIndex(0);
                }else {
                    Amplitude.play();
                }

            }
        })*/


})

function loadSongs() {
    $.ajax({
        type: "GET",
        url: "http://127.0.0.1:8000/songs",
        success: function (response) {
            console.log(response)
            for (var i = 0; i < response.songs.length; i++){
                var song_name = response.songs[i].name;
                var song_index = response.songs[i].id + 1;
                var cover_art = response.songs[i].cover_art;

                if (cover_art == "") {
                    var art = Amplitude.getDefaultAlbumArt();
                } else {
                    var art = "/storage/cover_art/" + response.songs[i].cover_art;
                }

                Amplitude.addSong({
                    "name": song_name,
                    "artist": response.songs[i].artist,
                    "album": response.songs[i].album,
                    "url":  "/song/find/" + response.songs[i].id,
                    "cover_art_url": "/storage/cover_art/" + response.songs[i].cover_art,
                })


                $('.trending-list').append(`
                              <div class="track">
                            <a href="#">
                                <img src="${art}" alt="" class="thumbnail">
                            </a>

                            <ul class="track-details">
                                <li class="track-mod song-title">${song_name}</li>
                                <li>Artist: <a class="track-mod">${response.songs[i].artist}</a></li>
                                <li>Downloads: 183216 <a href="audio/01. FEM.mp3" class="track-mod download-icon" download="FEM"><i class="bx bxs-download" aria-hidden="true"></i></a></li>

                                 <div style="display: flex;">
                            <span class="amplitude-play-pause play-song-individual" style="cursor: pointer"><i class="bx bx-play"></i> PLAY</span>
                            <span class="amplitude-stop stop-song-individual" style="margin-left: 12px; cursor: pointer;"><i class='bx bx-stop'></i> STOP</span
                            </div>
                            </ul>

                        </div>
                    `)

               /* $(".owl-carousel").append(`
                        <div class="item">
                             <img src="${art}" alt="">
                                   <a class="hero-carousel__slideOverlay">
                                          <h3 class="song-title">${song_name}</h3>
                                          <p class="artiste">${response.songs[i].artist}</p>
                                    </a>
                         </div>
                `)

*/
               /*console.log($(".play-song-individual").text())*/
                Amplitude.bindNewElements();
            }

            $('#content-holder').append(`
                    <div class="col-md-8 mt-5 ml-3">
                                <button class="btn btn-dark create-playlist">Create Playlist</button>
                                 <button class="btn btn-secondary view-playlist ml-2">View Playlists</button>
                                 <button class="btn btn-primary upload-song ml-2">Upload Song</button>
                         </div>
                `)
        }
    })
}

function viewPlaylist() {
    $.ajax({
        url: "/view/playlist",
        type: "GET",
        success: function (response) {
            console.log(response);
            $('#content-holder').append(`
                    <h2>Playlists</h2>
                    `)

            for (var i = 0; i  < response.length; i++){
                if (run_count  == 0)  {
                    playlists[i] = response[i].playlist_name;
                }
                $('#content-holder').append(`
                    <div class="playlist-name col-md-10 mb-4 mt-1"><h4>${response[i].playlist_name}</h4></div>
                    `)
            }
            run_count = 1;
        }
    })

}

function setSongAttributes() {
    var src

    if (Amplitude.getActiveSongMetadata().cover_art_url == "/storage/cover_art/")  {
        src = Amplitude.getDefaultAlbumArt()
    }else{
        src = Amplitude.getActiveSongMetadata().cover_art_url
    }
    const colorThief = new ColorThief();
    const img = new Image();

    var location = "http://127.0.0.1:8000" + src;
    img.addEventListener("load", function () {
        palette = colorThief.getPalette(img);
        console.log()
        color = colorThief.getColor(img)
        console.log(palette)
        color_dominant = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        console.log(lightOrDark(color_dominant))
        $(".song-player").css({
            "background": `radial-gradient(circle at top left,rgb(${palette[0][0]}, ${palette[0][1]}, ${palette[0][2]}), rgba(${color[0]}, ${color[1]}, ${color[2]}, 0.85) 45%)`,
        })

        $(".song-artist-details .title, .song-artist-details .artist-name, .unmute, .bxs-download").removeClass("dark-color")
        $(".song-artist-details .title, .song-artist-details .artist-name, .unmute, .bxs-download").removeClass("light-color")
        $(".bx-shuffle, .bx-repost, .seconds, .duration").removeClass("dark-color")
        $(".bx-shuffle, .bx-repost, .seconds, .duration").removeClass("light-theme")

        if (lightOrDark(color_dominant) === "light") {
            $(".song-artist-details .title, .song-artist-details .artist-name, .unmute, .bxs-download").addClass("dark-color")
            $(".bx-shuffle, .bx-repost, .seconds, .duration").addClass("dark-color")
        } else{
            $(".song-artist-details .title, .song-artist-details .artist-name, .unmute, .bxs-download").addClass("light-color")
            $(".bx-shuffle, .bx-repost, .seconds, .duration").addClass("light-theme")
        }

        $(":root")[0].style.setProperty("--slider-color", `rgb(${palette[1][0]}, ${palette[1][1]}, ${palette[1][2]})`)

      if ($(".visualization").find("audio").length == 0){
          $(".visualization").append(Amplitude.getAudio())
      }else {
          $(".visualization").find("audio").remove();
          $(".visualization").append(Amplitude.getAudio())
      }

        setTimeout(function () {
            $(".visualization audio").attr("id", "audio")
        }, 800)

        /*var song_duration = Math.floor(parseInt(Amplitude.getSongDuration()))
        $(".duration").text(Math.floor(splitTime(song_duration)))*/
    })

    img.crossOrigin = "Anonymous";
    img.src = location;

    $(".full-music-player .image img").attr("src", location)
    $('.song-artist-details .title').text(`${Amplitude.getActiveSongMetadata().name}`);
    $('.song-artist-details .artist-name').text(`${Amplitude.getActiveSongMetadata().artist}`);

   setTimeout(function () {
    console.log(Amplitude.getSongDuration())
       var duration = Math.floor(parseInt(Amplitude.getSongDuration()));
    $(".time-tracker .duration").text(splitTime(duration))
   }, 2000)

    setTimeout(loadVisualizer, 4000)
}

function refreshSongDetails() {
    setInterval(function () {
        if (Amplitude.getSongPlayedPercentage() >= 99) {
            Amplitude.next()
            setTimeout(setSongAttributes, 3000);
        }
    }, 1000)
}

function validateField(selector, field) {
            var validator = setInterval(function () {
                if (field != ""){
                    clearInterval(validator);
                    selector.css('border', '1px solid green');
                }else{
                    clearInterval(validator);
                    selector.css('border', '1px solid red');
                }
            },  2000);

}

function validateForm(request){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: request.data('route'),
        data: request.serialize(),
        success: function (response) {
            console.log(response)

            if (response.name){
                $('.invalid-name-feedback').append(`<span class="warning"><strong>${response.name}</strong></span>`);
                $('#name').css('border', '3px solid red');
            }else{
                $('#name').css('border', '3px solid green');
            }

            if (response.email){
                $('.invalid-email-feedback').append(`<span class="warning"><strong>${response.email}</strong></span>`);
                $('#email').css('border', '3px solid red');
            }else{
                $('#email').css('border', '3px solid green');
            }

            if (response.password){
                $('.invalid-password-feedback').append(`<span class="warning"><strong>${response.password}</strong></span>`);
                $('#password').css('border', '3px solid red');
            }else{
                $('#password').css('border', '3px solid green');
                $('#password-confirm').css('border', '3px solid green');
            }

            if (response.success){
                $('#feedback').append(`<span><strong>Successful!</strong></span>`)
                setTimeout(function () {
                    $('#content-holder').text('');
                    loadSongs();
                }, 1500);
            }
        }
    })
}

/*
// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x) or anyehere, close the modal
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//Darkmode toggle
function myFunction() {
    var element = document.body;
    element.classList.toggle("dark-mode");
    var x = document.querySelectorAll("#song");
    for (let i = 0; i < x.length; i++) {
        x[i].style.color = "white";
    }

}
*/


/*
document.getElementById('play').addEventListener('click', function (e) {
    e.preventDefault();
    let audio  = document.getElementById('audio');
    if (audio.paused) {
        audio.play();
        $('#play').classList.remove('bx-pause')
    } else {
            audio.pause();
            $('#play').classList.add('bx-pause')
        }
  });
*/

function loadDarkMode() {
    $("body").addClass("dark");
    $(".track-mod").addClass("dark-theme");
    $(".artiste").addClass("dark-theme");
}

function loadLightMode() {
    $("body").removeClass("dark");
    $(".track-mod").addClass("mode");
    $(".artiste").addClass("mode-alt");

}
function loadVisualizer() {
    var media_nodes = new WeakMap();
    var audio = document.getElementById("audio");

    var canvas = document.getElementById("canvas");
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    var ctx = canvas.getContext("2d");

    var context = new AudioContext();
    var src;

    if (media_nodes.has(audio)) {
        src = media_nodes.get(audio)
    }else {
        src = context.createMediaElementSource(audio);
        media_nodes.set(audio, src)
    }

    var analyser = context.createAnalyser();

    src.connect(analyser);
    analyser.connect(context.destination);

    analyser.fftSize = 256;

    var bufferLength = analyser.frequencyBinCount;

    var dataArray = new Uint8Array(bufferLength);

    var WIDTH = canvas.width;
    var HEIGHT = canvas.height;

    var barWidth = (WIDTH / bufferLength) * 2.5;
    var barHeight;
    var x = 0;

    function renderFrame() {
        requestAnimationFrame(renderFrame);


        x = 0;

        analyser.getByteFrequencyData(dataArray);

        ctx.fillStyle = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        ctx.fillRect(0, 0, WIDTH, HEIGHT);

        for (var i = 0; i < bufferLength; i++) {
            barHeight = dataArray[i];

            var r = barHeight + (25 * (i / bufferLength));
            var g = 250 * (i / bufferLength);
            var b = 50;

            ctx.fillStyle = "rgb(" + r + "," + g + "," + b + ")";
            ctx.fillRect(x, HEIGHT - barHeight, barWidth, barHeight);

            x += barWidth + 1;
        }
    }

    renderFrame();

};




