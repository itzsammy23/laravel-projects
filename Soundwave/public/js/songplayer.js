Amplitude.init({
        songs: [
            {
                "name": "The Banjo Beat",
                "artist": "Ricky Desktop",
                "album": "Single",
                "url":  "/song/find/1",
                "cover_art_url": "/storage/cover_art/banjo_beat.jpg",

        }
        ]
    ,
    "default_album_art":  "/storage/cover_art/record-33583_640.png",
    "default_playlist_art": "/storage/cover_art/music-154176_640.png",
    "autoplay": true
});
var playlists = [], songs = [], run_count = 0, song_file, fill_color, playlist_deleted_name, playlist_delete_index, playlist_deleted_song_name, playlist_deleted_song_index;
var letters = /^[A-Za-z]+$/;
var playlist_color, playlist_palette, user_song_index, color, palette, add_count = 0, current_playlist_name, playlist_added = false;
var view_mode_url = ["/",  "/playlist/create", "/join", "/my/playlists", ` `, ``, "/song/upload", "/login", "/register"]


$(document).ready(function () {

    $('.song').remove();

    var view_mode = parseInt($(".view__mode .mode").text());
    if (view_mode === 5) {
        loadSongs(function () {
         setTimeout(function () {
             var song_title = $("#view__mode__song").text();
             var song_original = song_title.replace(/-/g, " ").toLowerCase();

             console.log(songs);
             var song_position = songs.indexOf(song_original);
             user_song_index = song_position + 1;
             $(".banner").addClass("hidden-display");
             $(".sections").eq(5).removeClass("hidden-display")
             $(".song-player").removeClass("hidden-display")
             const img = new Image();
             img.crossOrigin = "Anonymous";
             img.src = $(".full-music-player .image img").attr("src");

             var active_song = song_title.toLowerCase().replace(/\s/g, "-");
             var active_artist = $(".song-artist-details .artist-name span").text().toLowerCase().replace(/\s/g, "-");

             view_mode_url[5] = `/listen/to/${active_song}/by/${active_artist}`;
             console.log(view_mode_url[5])

             loadSongEnvironment(img)
             $(".play-pause .controller").addClass("one__time__play");

         }, 3000)
        })
    } else{
        loadSongs(function () {
            $(".banner").addClass("hidden-display");
            $(".sections").eq(view_mode).removeClass("hidden-display");
        })

        if (view_mode === 6){
            $(".nav-list-item .icon i").eq(0).addClass("active-tab")
            $(".nav-list-item .tag").eq(0).addClass("active-tab")
        }

        if (view_mode === 1 || view_mode === 3 || view_mode === 4) {
            $(".nav-list-item .icon i").eq(1).addClass("active-tab")
            $(".nav-list-item .tag").eq(1).addClass("active-tab")
        }

        if (view_mode === 7 || view_mode === 8) {
            $(".nav-list-item .icon i").eq(2).addClass("active-tab")
            $(".nav-list-item .tag").eq(2).addClass("active-tab")
        }

        if (view_mode === 3) {
            viewPlaylist();
        }

        if (view_mode === 4) {
            var playlist_name = $("#playlist__name").text();
            var playlist_object = playlist_name.toLowerCase().replace(/\s/g, "_");
            var playlist_image_source = $("#playlist__image").attr("src");



            addPlaylistItems(playlist_name, playlist_image_source, playlist_object, function () {
                setTimeout(function () {
                    playlist_added = true;
                    current_playlist_name = playlist_name.toLowerCase();
                    console.log("Yeah, this callback was executed")
                }, 3500)
            });

        }

    }

    if (localStorage.getItem("mode") == null) {
        localStorage.setItem("mode", "dark" +
            "" +
            "");
    }

    if (localStorage.getItem("mode") == "light")  {
        loadLightMode();
    }

    if (localStorage.getItem("mode") == "dark") {
        loadDarkMode();
        $("#dark-moon").show();
        $("#mode-toggler").prop("checked", true);
    }

    console.log(localStorage.getItem("mode"))


    $("#mode-toggler").click(function () {
        setTimeout(function () {
            $("#dark-moon").toggle();
        }, 100)

        if ($(".track-mod").hasClass("mode")) {
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
        console.log("Clicked");
       /* console.log(localStorage.getItem("mode"))*/
    })

    $(window).on("popstate", function () {
                var location = window.location.href
                var url = location.substr(21);
                var url_index;
                if (url === "/" || url === "/home") {
                    url_index = 0;
                } else{
                    url_index = view_mode_url.indexOf(url);
                }


                hideSections();
                console.log(url_index)

                $(".sections").eq(url_index).removeClass("hidden-display");
                console.log(location.substr(21))
    })

    $(".brand h3").click(function () {
        hideSections();

        $(".landing").removeClass("hidden-display")
        window.history.pushState({index: "home"}, `Your number one African music streaming and download app`, `/home`)
    })

    $(document).on("click", ".one__time__play", function () {
            Amplitude.playSongAtIndex(user_song_index);
            $(".time-tracker .seconds").text("00:00");
            setTimeout(function () {
                loadAudio();

                var duration = Math.floor(parseInt(Amplitude.getSongDuration()));
                $(".time-tracker .duration").text(splitTime(duration))

                    refreshSongDetails();

                setTimeout(loadVisualizer, 3000);
            }, 900)


        $(".play-pause .controller").removeClass("one__time__play")
    })

    $(document).on("click", ".result__placer .song-results .search-title", function () {
        $(".result__placer").hide();
    })


    $(document).on("click", ".song-title, .result__placer .song-results .search-title", function () {
        var song_title = $(this).text().toLowerCase().replace(/\s/g, "-");
        var song_title_original = $(this).text().toLowerCase();
        var song_position = songs.indexOf(song_title_original);
        var song_index = song_position + 1;
        $('#content-holder').text('');
        $(".landing").addClass("hidden-display");
        console.log(song_index);


        playSong(song_title, song_index)
    });


    $(document).on("click", ".result__placer .song-results", function () {
        var song_title = $(this).find(".search-title").text().toLowerCase().replace(/\s/g, "-");
        var song_title_original = $(this).find(".search-title").text().toLowerCase();
        var song_position = songs.indexOf(song_title_original);
        var song_index = song_position + 1;
        $('#content-holder').text('');
        $(".landing").addClass("hidden-display");
        console.log(song_index);


        playSong(song_title, song_index)
    });


    $(".nav-list-item").click(function () {
            for(var i = 0; i < $(".nav-list-item").length; i++) {
                if ($(".nav-list-item .icon i").eq(i).hasClass("active-tab")) {
                   $(".nav-list-item .icon i").eq(i).removeClass("active-tab")
                    $(".nav-list-item .tag").eq(i).removeClass("active-tab")
                }
            }
            var index = $(".nav-list-item").index(this)
            $(".nav-list-item .icon i").eq(index).addClass("active-tab")
            $(".nav-list-item .tag").eq(index).addClass("active-tab")
    })

    $("#cover__art__file").on("change", function () {
            var img = $("#cover__art__file")[0].files[0]
            var url = URL.createObjectURL(img);
            $(".profile__photo").html("");
            $(".profile__photo").append(`<img src="${url}" class="playlist__art" alt="playlist cover art">`)
    })


    $(document).on("click", ".pause-song", function () {
        Amplitude.pause();
    })

    $(".create-playlist").on("click", function () {
        hideSections();
        window.history.pushState({index: "playlists"}, `Your playlists`, `/my/playlists`)
        if (localStorage.getItem("user_id") === null) {
            $(".not__authenticated").removeClass("hidden-display")
        } else{
            viewPlaylist();


            $(".list__container").remove();
            $(".playlist__list").removeClass("hidden-display")
        }
    })

    $(".create__playlist__link").click(function () {
       hideSections();
       window.history.pushState({index: "Create playlist"}, "Create a new playlist", "/playlist/create");

        $(".playlist__create__new").removeClass("hidden-display")
    })

    $(document).on("keyup", ".add-new-song", function () {
       var selector = $(this);
       var result_placer = $(".show-songs");
      searchForSong(selector, result_placer)

    })

    $(".search-txt").keyup(function () {
        var selector = $(this);
        var result_placer = $(".result__placer");
        result_placer.show();

        if (selector.val().length === 0) {
            result_placer.hide();
        }
        searchForSong(selector, result_placer);
    })


    $(document).on("click", ".song-results", function () {
        var index = $(this).find("span").text();


        $('.add-new-song').val(index);
        $('.song-results').remove();
    });

    $(document).on("click", ".add-song", function (e) {
        e.preventDefault();

        if($('.add-new-song').val() == "" || $('.add-new-song').val().length < 3 || $('.show-songs').text() == "Song not found"){
            return false;
        }else{
            $('.songs-added').append(`
            <div class="appended-song mr-2 d-flex"><span class="appended-song-name">${$('.add-new-song').val()}</span>
             <span class="delete-selection">X</span></div>
            `)


            $('.add-new-song').val("");
        }
    })

    $(document).on("click", ".delete-selection", function () {
        var delete_selection = $('.delete-selection').index(this);
        $('.appended-song').eq(delete_selection).remove();
    })

    $(document).on("click", "#playlist-submit-button", function (e) {
        e.preventDefault();
        var playlist_art = $("#cover__art__file")[0].files[0];
        console.log(playlist_art)

        if (playlist_art != undefined) {
            var playlist_art_name = playlist_art.name;
            var art_extension = playlist_art_name.substr((playlist_art_name.lastIndexOf(".") +1)).toString().replace(/\s/g, "");
            console.log(art_extension)

            if (art_extension != "jpg" && art_extension != "jpeg" && art_extension != "png"){
                $('.show-songs').append(`<div class="alert alert-danger" id="error-message">Invalid cover art format</div>`)
                console.log(art_extension)
                return false;
            }

        }
        if ($('#playlist-name').val() == "" || $('#playlist-name').val().length < 3
            || $('.songs-added').text() == "" ||  $('.show-songs').text() == "Song not found") {
            return false;
        }else{
            var playlist_name = $('#playlist-name').val();

            var data = new FormData();
            data.append("playlist_name", playlist_name);

            if (playlist_art != undefined) {
                data.append("playlist_art", playlist_art);
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/playlist/create",
                cache: false,
                processData: false,
                contentType: false,
                enctype: "multipart/form-data",
                data: data
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
                        song_name: $('#create-playlist .appended-song-name').eq(i).text(),
                    }
                })
            }

        $('.songs-added').text("");
        $('.songs-added').append(`
                <div class="success__class">Playlist Created</div>
        `);

            setTimeout(function () {
                    $(".playlist__create__new").addClass("hidden-display")
                    $(".landing").removeClass("hidden-display")
                $(".nav-list-item .icon i").eq(1).removeClass("active-tab")
                $(".nav-list-item .tag").eq(1).removeClass("active-tab")
                $(".success__class").remove();
                    $(".songs-added").html("")
                    }, 1500)
        }
    })

    $(document).on("click", ".view-playlist", function () {
        $('#content-holder').text("");

        viewPlaylist();
    })

    $(document).on("click", ".playlist__list__title", function () {
            var index = $(".playlist__list__title").index(this);
            var playlist_image_source = $(".playlist__list .list__container img").eq(index).attr("src");
            var playlist_name = $(this).text();
            var playlist_object = playlist_name.toLowerCase().replace(/\s/g, "_");
            var playlist_url_object = playlist_name.toLowerCase().replace(/\s/g, "-");
            console.log(playlist_image_source)
            var user_id = localStorage.getItem("user_id")



        addPlaylistItems(playlist_name, playlist_image_source, playlist_object, function () {
            setTimeout(function () {
                playlist_added = true;
                current_playlist_name = playlist_name.toLowerCase();
                console.log("Yeah, this callback was executed")
            }, 3500)
        });
    })

    $(document).on("click", ".additional-options-dots", function () {
        var index =$(".additional-options-dots").index(this);

        for (var i = 0; i < $(".additional-options-content").length; i++) {
            if (i != index) {
                $(".additional-options-content").eq(i).addClass("hidden-display");
            }
        }
        $(".additional-options-content").eq(index).toggleClass("hidden-display");
    })

    $(document).click(function (e) {
        var additional_content = $(".add__song__modal");
        var picture_modal = $(".picture__modal");
        var change_modal = $(".change__modal");

        if ($(e.target).is(".add__song__modal")) {
            additional_content.addClass("hidden-display")
        }

        if ($(e.target).is(".change__modal")) {
            change_modal.addClass("hidden-display")
        }
    })

    $(document).on("click", ".additional-options-content .delete", function (e) {
        e.preventDefault();
        playlist_delete_index = $(".additional-options-content .delete").index(this);
        playlist_deleted_name = $(".full__view__playlist__title").text();
        playlist_deleted_song_name = $(".song-title-playlist").eq(playlist_delete_index).text();

        $("#delete__song__modal").removeClass("hidden-display");
    });

    $("#delete__song").click(function () {
        $.ajax({
            method: "DELETE",
            url: "/playlist/delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                playlist_name: playlist_deleted_name,
                song_name: playlist_deleted_song_name,
                user_id: localStorage.getItem("user_id")
            },
            success: function (response) {
                console.log(response)
                $(".full__view__song__list").eq(playlist_delete_index).remove();
                var name = $(".full__view__playlist__title").text();
                var obj = name.toLowerCase().replace(/\s/g, "_");
                var img = $(".header__container img").attr("src").substr(21);
                var pos = parseInt(playlist_delete_index);
                Amplitude.getSongsInPlaylist(obj).splice(pos, pos);
                $(".delete__modal").addClass("hidden-display")
                clearPlaylist(obj);
                addPlaylistItems(name, img, obj);
            }
        })

    })

    $(".cancel__button").click(function () {
       $(".additional-options-content").eq(playlist_delete_index).addClass("hidden-display");
        $(".delete__modal").addClass("hidden-display");
    })

    $(document).on("click", ".song-title-playlist", function () {
        var song_title = $(this).text().toLowerCase().replace(/\s/g, "-");
        var song_index =  $(".song-title-playlist").index(this);
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
                $(".playlist__full__view").addClass("hidden-display")
                $(".song-player").removeClass("hidden-display");

                $(".play-pause i").removeClass("bx-play");
                $(".play-pause i").addClass("bx-pause");

                setSongAttributes();
                refreshSongDetails();
                setInterval(checkPosition, 100);
            }
        })

    });

    $("#playlist__shuffle").click(function () {
        const length = $(".full__view__song__list").length;
        const random = Math.floor(Math.random() * length);
        console.log(random, length)
        var playlist_key = $(".full__view__playlist__title").text().toLowerCase().replace(/\s/g, "_");
        console.log(playlist_key)

        Amplitude.setShufflePlaylist(playlist_key, true);
        Amplitude.playPlaylistSongAtIndex(random, playlist_key);

        hideSections();
        $(".song-player").removeClass("hidden-display");

        $(".play-pause i").removeClass("bx-play");
        $(".play-pause i").addClass("bx-pause");
        setSongAttributes();
        refreshSongDetails();

        setInterval(checkPosition, 100);
    })

    $("#playlist__play__all").click(function () {
        var playlist_key = $(".full__view__playlist__title").text().toLowerCase().replace(/\s/g, "_");


        Amplitude.playPlaylistSongAtIndex(0, playlist_key);

        hideSections();
        $(".song-player").removeClass("hidden-display");

        $(".play-pause i").removeClass("bx-play");
        $(".play-pause i").addClass("bx-pause");
        setSongAttributes();
        refreshSongDetails();

        setInterval(checkPosition, 100);
    })

    $("#add__button").click(function() {
        $(".add__song__modal").removeClass("hidden-display");
    })

    $("#close__add__modal").click(function () {
        $(".add__song__modal").addClass("hidden-display");
    })

    $("#add-to-playlist-submit").click(function (e) {
        e.preventDefault();

        if ($(".appended-song").length === 0) {
            return false;
        } else{
            var song_array = [];
            for (var i = 0; i < $(".playlist__new__songs .appended-song .appended-song-name").length; i++) {
                song_array[i] = $(".playlist__new__songs .appended-song .appended-song-name").eq(i).text();
            }
            var form = $("#add-songs-to-playlist");
            var route = form.data("route")
            var playlist_name = $(".full__view__playlist__title").text();
            var playlist_object = playlist_name.toLowerCase().replace(/\s/g, "_");
            var playlist_image_source = $(".header__container img").attr("src").substr(21);

            console.log(song_array)

            $.ajax({
                method: "POST",
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    songs: song_array,
                    playlist_name: playlist_name,
                },
                success: function (response) {
                console.log(response)
                    $(".songs-added").html("");
                    $(".add__song__modal").addClass("hidden-display");
                    $(".full__view__list").html("");
                    clearPlaylist(playlist_object)
                    addPlaylistItems(playlist_name, playlist_image_source, playlist_object);
                }
            })
        }
    })

    $(".change__art").click(function () {
            $(".picture__modal").removeClass("hidden-display");
    })

    $("#close__picture__modal").click(function() {
        $(".picture__modal").addClass("hidden-display")
    })

    $("#cover__art__demo__image").change(function () {
            var file = $(this)[0].files[0];
            var file_url = URL.createObjectURL(file);
            $(".cover__art__demo").html("");
            $(".cover__art__demo").append(`<img src="${file_url}"><i class="bx bxs-trash-alt" id="remove__cover__art"></i>`);

    })

    $(document).on("click", "#remove__cover__art", function() {
        $("#cover__art__demo__image").val("");
        $(".cover__art__demo").html("");
        $(".cover__art__demo").append(`<i class="bx bxs-camera"></i>`)
    })



    $("#change__cover__art").click(function(e) {
        e.preventDefault();
        /*$(".header__container img").removeAttr("src");*/
        var image_file = $("#cover__art__demo__image")[0].files[0];
        var playlist_name =$(".full__view__playlist__title").text();
        var playlist_object = playlist_name.toLowerCase().replace(/\s/g, "_");
        var user_id = localStorage.getItem("user_id");

        if ($("#cover__art__demo__image").val() === "" || $("#cover__art__demo__image").val() === null) {
            return false;
        } else {
            var data = new FormData();
            data.append("image", image_file);
            data.append("playlist_name", playlist_name);
            data.append("user_id", user_id)


            $.ajax({
                type: "POST",
                url: "/update/playlist/art",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    clearPlaylist(playlist_object)
                    var playlist_image_source = response.playlist_art;
                    $(".header__container img").removeAttr("src");
                    $(".full__view__list").html("");
                    $(".picture__modal").addClass("hidden-display");
                    $(".additional-options-content").addClass("hidden-display");
                    $(".header__container img").attr("src", playlist_image_source);

                    addPlaylistItems(playlist_name, playlist_image_source, playlist_object);
                }
            })

        }
    })

    $(".change__name").click(function() {
        $(".change__modal").removeClass("hidden-display");
        $("#change__name").val($(".full__view__playlist__title").text());
    })

    $("#close__change__modal").click(function () {
        $(".change__modal").addClass("hidden-display");
    })

    $("#change__name__button").click(function () {
        var name_value = $("#change__name").val();
        var user_id = localStorage.getItem("user_id");
        var old_playlist_name = $(".full__view__playlist__title").text();
        var name_value_url = name_value.toLowerCase().replace(/\s/g, "-");

        if (name_value === "" || name_value === null) {
            return false;
        } else {
            $.ajax({
                url: "/update/playlist/name",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data:{
                    user_id: user_id,
                    new_playlist_name: name_value,
                    old_playlist_name: old_playlist_name
                }
            });

            $(".change__modal").addClass("hidden-display");
            $(".full__view__playlist__title").text(name_value);
            $(".additional-options-content").addClass("hidden-display");
            window.history.pushState({index: "playlist"}, `Your ${name_value} playlist`, `/my/${name_value_url}/playlist/${user_id}`)
        }
    })

    $("#show__delete__modal").click(function () {
        $("#delete__playlist__modal").removeClass("hidden-display");
    })

    $("#delete__playlist").click(function() {
        var playlist_name = $(".full__view__playlist__title").text();
        var user_id = localStorage.getItem("user_id");
        $.ajax({
            method: "DELETE",
            url: "/playlist/update/delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                playlist_name: playlist_name,
                user_id: user_id
            },
            complete: function () {
                console.log("Sent")
            }
        })

        $("#delete__playlist__modal").addClass("hidden-display")
        hideSections();
        $(".playlist__list").removeClass("hidden-display");
        viewPlaylist();
        window.history.pushState({index: "playlist"}, `Your playlists`, `/my/playlists`)
    })


    $(".current__selection").click(function () {
        $(".genre-full-list").toggleClass("hidden-display");

        toggleArrow()
    })

    $(".genre-full-list li").click(function () {
        var index = $(".genre-full-list li").index(this);
        var month = $(".genre-full-list li").eq(index).find("span").text();

        $(".current__selection")[0].firstChild.data = month;

        toggleArrow()

        $(".genre-full-list").addClass("hidden-display");
    })


    $(document).on("click", ".upload-song", function () {
      hideSections();
      if (localStorage.getItem("user_id") === null) {
          $(".not__authenticated").removeClass("hidden-display");
      } else {
          $(".song__upload").removeClass("hidden-display");
      }

        window.history.pushState({index: "upload"}, `Upload a song`, `/song/upload`)
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

    $("#song-cover-art").change(function() {
        var file = $(this)[0].files[0];
        var file_url = URL.createObjectURL(file);
        $(".cover__art__selector .preview").html("");
        $(".cover__art__selector .preview").append(`<img src="${file_url}">`)
    })

    $("#song-file").change(function() {
        var file_name = $(this)[0].files[0].name;

        $(".preview__name__text").html(`<span>${file_name}</span>`)
    })

    $(document).on("click", "#song-upload-button", function (e) {
        e.preventDefault();
        $('.response-message').remove();

        var file = $('#song-file')[0].files[0];
        var cover_art = $('#song-cover-art')[0].files[0];
        var fileName = file.name;
        var extension = fileName.substr((fileName.lastIndexOf('.') +1));

        var  song_name = $('#song-name').val(), song_artist = $('#song-artist').val(), song_genre = $('.current__selection').text(),
            song_release_year = $('#song-release-year').val(), song_album =  $('#song-album').val();

        $('#error-message').remove();

        if (file == null){
            $('#error-messages').append(`<div class="alert alert-danger" id="error-message">No song file selected</div>`)
            return false;
        }

        if (cover_art != null){
            var cover_art_name = cover_art.name;
            var art_extension = cover_art_name.substr((cover_art_name.lastIndexOf(".") +1));
            console.log(art_extension)

            if (art_extension !=  "jpg" && art_extension != "jpeg" && art_extension != "png"){
                $('#error-messages').append(`<div class="alert alert-danger" id="error-message">Invalid cover art format</div>`)
                return false;
            }
        }

        if (song_name == "" || song_artist == ""  || song_genre == "" ||  song_album == "" || song_release_year == "" ||  file ==  null || extension != "mp3"){
            return false;
        }else{
            $(".loader").show();
             var data = new FormData();
             var user_id = localStorage.getItem("user_id");
             data.append('song_name', song_name)
             data.append('artist',  song_artist)
             data.append('genre', song_genre)
             data.append('album', song_album)
             data.append('release_year', song_release_year)
             data.append('file', file)
            data.append('user_id', user_id);

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
                        $(".loader").hide();

                        if (response.success == true){
                            $('#error-messages').append('' +
                                '<div class="success__message response-message my-2">Your song has been successfully uploaded</div>')
                            setTimeout(function () {
                            hideSections();
                            $(".landing").removeClass("hidden-display")
                                $(".nav-list-item .icon i").eq(0).removeClass("active-tab")
                                $(".nav-list-item .tag").eq(0).removeClass("active-tab")
                                $(".trending-list").html("");
                                clearSongList();
                                loadSongs();
                                window.history.pushState({index: "home"}, `Your number one African music streaming and download app`, `/home`)
                            }, 1200)
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
            hideSections();
        window.history.pushState({index: "register"}, "Join the gbedu community", "/register")

            $(".register").removeClass("hidden-display")
    })

    $(document).on("click", ".register-submit", function (e) {
        e.preventDefault();
        $('.warning').remove();

        var form_request = $('#register-form');
        $(".loader").show();
        validateForm(form_request);
    })

    $('.join').click(function () {
        hideSections();
        window.history.pushState({index: "login"}, "Log into your account", "/login")

        $(".login").removeClass("hidden-display");

    })

    $(document).on("click", ".login-submit", function (e) {
        e.preventDefault();
        $('.warning').remove();

        var form_request = $('#login-form');
        $(".loader").show();
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

        $(document).on("click", ".play-song-individual", function () {
            var index = $(".play-song-individual").index(this);

           removeActiveClasses(function () {
               if (Amplitude.getPlayerState() === "playing") {
                   $(".play-song-individual").eq(index).html(`<i class="bx bx-pause"></i> PAUSE`)
               }


               if (Amplitude.getPlayerState() === "paused") {
                   $(".play-song-individual").eq(index).html(`<i class="bx bx-play"></i> PLAY`)
               }
           })

        })

    $(document).on("click", ".download-icon", function () {
        var index = $(".download-icon").index(this);
        var song_name_original = songs[index];
        var song_name_request = song_name_original.replace(/\s/g, "-");


        getFile(song_name_request);
    })

    $(".full-music-player .download").click(function () {
        var current_song_title = $(".full-music-player .song-artist-details .title").text().replace(/\s/g, "-");
        getFile(current_song_title);
    })

    $(".join__now").click(function (e) {
        e.preventDefault();
        hideSections();

        $(".register").removeClass("hidden-display");
    })
})

function loadSongs(callback) {
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

                songs[i] = song_name.toLowerCase();


                if (i <= 15) {
                    $('.trending-list').append(`
                              <div class="track">
                            <a href="#" class="image__link">
                                <img src="${art}" alt="" class="thumbnail">
                            </a>

                            <ul class="track-details">
                                <li class="track-mod song-title">${song_name}</li>
                                <li>Artiste: <a class="track-mod">${response.songs[i].artist}</a></li>
                                <li><a class="track-mod download-icon"><i class="bx bxs-download" aria-hidden="true"></i></a></li>

                                 <div style="display: flex;">
                            <span class="amplitude-play-pause play-song-individual" style="cursor: pointer" data-amplitude-song-index="${i+1}"><i class="bx bx-play"></i> PLAY</span>
                            <span class="amplitude-stop stop-song-individual" style="margin-left: 12px; cursor: pointer;"><i class='bx bx-stop'></i> STOP</span
                            </div>
                            </ul>

                        </div>
                    `)
                    Amplitude.bindNewElements();
                }



            }
        }
    })

    if (callback && typeof callback === 'function') {
        callback();
    }
}

function viewPlaylist() {
    $(".no__playlists").remove();

        $.ajax({
            url: "/view/playlist",
            type: "GET",
            success: function (response) {
                console.log(response);
                if (response.session_expired) {
                    hideSections();

                    $(".not__authenticated").removeClass("hidden-display");
                } else {
                    if (response.no_results) {
                        $(".playlist__list").append(`<div class="no__playlists">You haven't created any playlists.</div>`)
                    } else{

                        $(".playlist__list").append("<div class='list__container'></div>")

                        for (var i = 0; i  < response.length; i++){
                            if (run_count  == 0)  {
                                playlists[i] = response[i].name;
                            }

                            var containers = $(".list__container").length;
                            var img_src;

                            if (response[i].playlist_art === null || response[i].playlist_art === "") {
                                img_src =  Amplitude.getDefaultPlaylistArt();
                            } else {
                                img_src = "/storage/cover_art/" + response[i].playlist_art;
                            }

                            if ($(".list__container").eq(containers-1).find(".list__item").length >= 2) {
                                $(".playlist__list").append("<div class='list__container'></div>")
                                containers =  $(".list__container").length;
                                $(".list__container").eq(containers-1).append(appendPlaylistItems(response[i], img_src))
                            } else {
                                $(".list__container").eq(containers-1).append(appendPlaylistItems(response[i], img_src))
                            }

                        }

                        run_count = 1;
                    }
                }


            }
        })
}

function setSongAttributes() {
    var src;
    setTimeout(function () {
        console.log(Amplitude.getSongPlayedPercentage())
        if (Amplitude.getSongPlayedPercentage() === 0) {
            if ($(".controller").hasClass("bx-pause") ===  true) {
                $(".controller").removeClass("bx-pause")
                $(".controller").addClass("bx-play")
            }
        }
    }, 3500)


    if (Amplitude.getActiveSongMetadata().cover_art_url == "/storage/cover_art/")  {
        src = Amplitude.getDefaultAlbumArt()
    }else{
        src = Amplitude.getActiveSongMetadata().cover_art_url
    }
    var location = "http://127.0.0.1:8000" + src;
    const img = new Image();
    img.crossOrigin = "Anonymous";
    img.src = location;

    loadSongEnvironment(img)
    loadAudio();


    $(".full-music-player .image img").attr("src", location)
    $('.song-artist-details .title').text(`${Amplitude.getActiveSongMetadata().name}`);
    $('.song-artist-details .artist-name').text(`${Amplitude.getActiveSongMetadata().artist}`);

    var active_song = Amplitude.getActiveSongMetadata().name;
    var active_song_url = active_song.toLowerCase().replace(/\s/g, "-");
    var active_artist = Amplitude.getActiveSongMetadata().artist;
    var active_artist_url = active_artist.toLowerCase().replace(/\s/g, "-");
    view_mode_url[5] = `/listen/to/${active_song_url}/by/${active_artist_url}`;
    console.log(view_mode_url[5])

    window.history.pushState({index: "listen"}, `Listen to ${active_artist}'s ${active_song} on Gbedu`, `/listen/to/${active_song_url}/by/${active_artist_url}`)

   setTimeout(function () {
    console.log(Amplitude.getSongDuration())
       var duration = Math.floor(parseInt(Amplitude.getSongDuration()));
    $(".time-tracker .duration").text(splitTime(duration))
   }, 2800)

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
        method: "POST",
        url: request.data('route'),
        data: request.serialize(),
        success: function (response) {
            $(".loader").hide();
            console.log(response)

            if (response.username){
                $('.invalid-name-feedback').append(`<span class="warning">${response.name}</span>`);
                $('#name').css('border-bottom', '1px solid red');
            }else{
                $('#name').css('border-bottom', '1px solid green');
            }

            if (response.email){
                $('.invalid-email-feedback').append(`<span class="warning">${response.email}</span>`);
                $('.email').css('border-bottom', '1px solid red');
            }else{
                $('.email').css('border-bottom', '1px solid green');
            }

            if (response.password){
                $('.invalid-password-feedback').append(`<span class="warning">${response.password}</span>`);
                $('.password').css('border-bottom', '1px solid red');
            }else{
                $('.password').css('border-bottom', '1px solid green');
                $('.password-confirm').css('border-bottom', '1px solid green');
            }

            if (response.success){
                $('.feedback').append(`<span class="success__message">Successful!</span>`)
                var user_id = response.user_id;
                localStorage.setItem("user_id", user_id.toString());
                setTimeout(function () {
                    hideSections();
                    $(".feedback").html("");
                    $(".form-control").css('border-bottom', '1px solid #c3c3c3')
                    $(".landing").removeClass("hidden-display")
                    $(".nav-list-item .icon i").removeClass("active-tab")
                    $(".nav-list-item .tag").removeClass("active-tab")
                }, 1500);
            }
        }
    })
}

function loadDarkMode() {
    $("body").addClass("dark");
    $(".track-mod").addClass("dark-theme");
    $(".artiste").addClass("dark-theme");
    $(":root")[0].style.setProperty("--mode-toggle", "#000000")
    $(":root")[0].style.setProperty("--toggle-color", "#c3c3c3")

}

function loadLightMode() {
    $("body").removeClass("dark");
    $(".track-mod").addClass("mode");
    $(".artiste").addClass("mode-alt");
    $(":root")[0].style.setProperty("--mode-toggle", "#ffffff")
    $(":root")[0].style.setProperty("--toggle-color", "#000010")

}

function hideSections() {
    for(var i = 0; i < $(".sections").length; i++) {
        if ($(".sections").eq(i).hasClass("hidden-display") === false){
            $(".sections").eq(i).addClass("hidden-display");
        }
    }
}

function appendPlaylistItems(item, src) {
        return ` <div class="list__item">
                                <img src="${src}" alt="playlist art">
                                <div class="info">
                                    <h4 class="playlist__list__title">${item.name}</h4>
                                    <div class="song__count">Songs: ${item.song_count}</div>
                                </div>
                            </div>`
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

        ctx.fillStyle = `rgba(${color[0]}, ${color[1]}, ${color[2]}, 0.65)`;
        ctx.fillRect(0, 0, WIDTH, HEIGHT);

        for (var i = 0; i < bufferLength; i++) {
            barHeight = dataArray[i];

            var r = barHeight + (25 * (i / bufferLength));
            var g = 250 * (i / bufferLength);
            var b = 50;

            ctx.fillStyle = fill_color;
            ctx.fillRect(x, HEIGHT - barHeight, barWidth, barHeight);

            x += barWidth + 1;
        }
    }

    renderFrame();

};

function toggleArrow() {
    if ($(".genre__list i").hasClass("bxs-down-arrow")) {
        $(".genre__list i").removeClass("bxs-down-arrow")
        $(".genre__list i").addClass("bxs-up-arrow")
    } else {
        $(".genre__list i").addClass("bxs-down-arrow")
        $(".genre__list i").removeClass("bxs-up-arrow")
    }
}

function getFile(request_file) {
    var url = "/download/"+ request_file;
    var download_name = request_file.replace(/-/g, " ")
            var download_link = document.createElement("a");
            download_link.href = url;
            download_link.download = `${download_name}.mp3`;
            download_link.click();
}

function playSong(song_title, song_index) {
    $.ajax({
        type: "GET",
        url: "/song/" +song_title,
        data: {
            song_index: song_index,
        },
        success: function (response) {
            console.log(response)
            Amplitude.playSongAtIndex(response.index);
            hideSections();


            $(".song-player").removeClass("hidden-display")

            $(".play-pause i").removeClass("bx-play");
            $(".play-pause i").addClass("bx-pause");

            setSongAttributes();
            refreshSongDetails();

            setInterval(checkPosition, 100)

        }
    })
}

function loadSongEnvironment(image) {
    const colorThief = new ColorThief();

    image.addEventListener("load", function () {
        palette = colorThief.getPalette(image);
        console.log()
        color = colorThief.getColor(image)
        console.log(palette)
        color_dominant = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        console.log(lightOrDark(color_dominant))
        $(".song-player").css({
            "background": `radial-gradient(circle at top left,rgb(${palette[0][0]}, ${palette[0][1]}, ${palette[0][2]}), rgb(${color[0]}, ${color[1]}, ${color[2]}) 45%)`,
        })

        $(".song-artist-details .title, .song-artist-details .artist-name, .unmute,.full-music-player .download .bxs-download").removeClass("dark-color")
        $(".song-artist-details .title, .song-artist-details .artist-name, .unmute,.full-music-player .download .bxs-download").removeClass("light-color")
        $(".bx-shuffle, .bx-repost, .seconds, .duration").removeClass("dark-color")
        $(".bx-shuffle, .bx-repost, .seconds, .duration").removeClass("light-theme")

        if (lightOrDark(color_dominant) === "light") {
            $(".song-artist-details .title, .song-artist-details .artist-name, .unmute,.full-music-player .download .bxs-download").addClass("dark-color")
            $(".bx-shuffle, .bx-repost, .seconds, .duration").addClass("dark-color")
            fill_color = "rgba(0, 0, 0, 0.65)";
        } else{
            $(".song-artist-details .title, .song-artist-details .artist-name, .unmute,.full-music-player .download .bxs-download").addClass("light-color")
            $(".bx-shuffle, .bx-repost, .seconds, .duration").addClass("light-theme")
            fill_color = "rgba(255, 255, 255, 0.65)";
        }

        $(":root")[0].style.setProperty("--slider-color", `rgb(${palette[1][0]}, ${palette[1][1]}, ${palette[1][2]})`)

        /*var song_duration = Math.floor(parseInt(Amplitude.getSongDuration()))
        $(".duration").text(Math.floor(splitTime(song_duration)))*/
    })
}

function loadAudio(){
    if ($(".visualization").find("audio").length == 0){
        $(".visualization").append(Amplitude.getAudio())
    }else {
        $(".visualization").find("audio").remove();
        $(".visualization").append(Amplitude.getAudio())
    }

    setTimeout(function () {
        $(".visualization audio").attr("id", "audio")
    }, 800)
}

function addPlaylistItems(playlist_name, playlist_image_source, playlist_object, callback) {
    $(".full__view__list").html("");
    var playlist_url_object = playlist_name.toLowerCase().replace(/\s/g, "-");
    var user_id = localStorage.getItem("user_id")
    view_mode_url[4] = `/my/${playlist_url_object}/playlist/${user_id}`;
    window.history.pushState({index: "playlist_list"}, `${playlist_name}'s playlist`, `/my/${playlist_url_object}/playlist/${user_id}`);
    var location = "http://127.0.0.1:8000" + playlist_image_source;
    const colorThief = new ColorThief();
    const playlist_img = new Image();

    $(".playlist__list").addClass("hidden-display");
    $(".playlist__full__view").removeClass("hidden-display");


    playlist_img.addEventListener("load", function () {
        playlist_palette = colorThief.getPalette(playlist_img);
        playlist_color = colorThief.getColor(playlist_img)
        color_dominant = `rgb(${playlist_color[0]}, ${playlist_color[1]}, ${playlist_color[2]})`;
        console.log(lightOrDark(color_dominant))
        $(".full__view__header").css({
            "background": `radial-gradient(circle at top left,rgb(${playlist_palette[0][0]}, ${playlist_palette[0][1]}, ${playlist_palette[0][2]}), rgba(${playlist_color[0]}, ${playlist_color[1]}, ${playlist_color[2]}, 0.85) 45%)`,
        })

        if(lightOrDark(color_dominant) === "dark") {
            $(":root")[0].style.setProperty("--playlist-color", `rgb(${playlist_palette[0][0]}, ${playlist_palette[0][1]}, ${playlist_palette[0][2]})`)
            fill_color = 'rgba(255, 255, 255, 0.65)';
            $(":root")[0].style.setProperty("--playlist-dots-color", `#ffffff`)
        }else {
            $(":root")[0].style.setProperty("--playlist-color", `rgba(${playlist_color[0]}, ${playlist_color[1]}, ${playlist_color[2]}, 0.85)`)
            fill_color = 'rgba(0, 0, 0, 0.65)';
            $(":root")[0].style.setProperty("--playlist-dots-color", `#000000`)
        }


    })

    $(".full__view__header img").attr("src", location);
    $(".full__view__playlist__title").text(capitalizeFirstLetter(playlist_name));

    playlist_img.crossOrigin = "Anonymous";
    playlist_img.src = location;


    $.ajax({
        url: "/playlist/" + playlist_name,
        method:  "GET",
        success:  function (response) {
            Amplitude.addPlaylist(playlist_object, { "playlist_key" : playlist_name}, [{
                "name": response[0].name,
                "artist": response[0].artist,
                "album": response[0].album,
                "url":  "/song/find/" + response[0].id,
                "cover_art_url": "/storage/cover_art/" + response[0].cover_art
            }]);

            $(".full__view__list").append(`
            <h3 class="full__view__playlist__title">${capitalizeFirstLetter(playlist_name)}</h3>
            `)

            if (playlist_added === true && current_playlist_name === playlist_name.toLowerCase()) {
                Amplitude.addSongToPlaylist({
                    "name": response[0].name,
                    "artist": response[0].artist,
                    "album": response[0].album,
                    "url":  "/song/find/" + response[0].id,
                    "cover_art_url": "/storage/cover_art/" + response[0].cover_art
                }, playlist_object);
                console.log("I was added")
            }

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

                var art;
                if (response[i].cover_art === "" || response[i].cover_art === null) {
                    art = "record-33583_640.png";
                } else{
                    art = response[i].cover_art;
                }

                $('.full__view__list').append(`
                        <div class="full__view__song__list">

                <div class="numbers">${index}</div>
                <div class="full__view__info">
                    <div class="image">
                        <img src="/storage/cover_art/${art}">
                    </div>
                    <div class="full__info">
                        <h4 class="song-title-playlist" data-playlist="${playlist_object}">${response[i].name}</h4>
                        <div class="artist">${response[i].artist}</div>
                    </div>

                       <div class="floated-dot">
                         <div class="floated-vertical-dots">
                             <ul>
                                 <li>
                                     <a class="additional-options-dots"><i class='bx bx-dots-vertical-rounded'></i></a>
                                     <ul class="hidden-display additional-options-content">
                                         <li class="delete"><i class='bx bxs-trash-alt' ></i> <a>Remove from playlist</a></li>
                                     </ul>
                                 </li>
                             </ul>
                         </div>
                     </div>
                </div>
                </div>
                    `);
            }
        }
    })

    if (callback && typeof callback === 'function') {
        callback();
    }
}

function capitalizeFirstLetter(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
}

function searchForSong(selector, result_placer) {
    if (selector.val().length == 0) {
        result_placer.html("")
    }

    if (selector.val().length == 3){
        result_placer.html("")
        $.ajax({
            type: "GET",
            url: "/find/song",
            data: {
                value: selector.val(),
            },
            complete: function () {
                console.log("Sent")
            },
            success: function (response) {
                console.log(response.songs.length);
                if (response.songs.length == 0){
                    result_placer.append(`
                             <div class="danger__class">
                                <p>Song not found</p>
                            </div>
                             `);
                }else{
                    for (var i = 0; i < response.songs.length; i++){
                        result_placer.append(`
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
}

function clearSongList() {
    var length = Amplitude.getSongs().length;
    var stop_position = length + 1;

  Amplitude.getSongs().splice(1, stop_position);
   console.log("Cleared")
}


function clearPlaylist(key) {
    var length = Amplitude.getSongsInPlaylist(key).length;
    var stop_position = length + 1;

    Amplitude.getSongsInPlaylist(key).splice(0, stop_position);
    console.log("Cleared")
}

function removeActiveClasses(callback) {
    for (var i = 0; i < $(".play-song-individual").length; i++) {
        if ($(".play-song-individual").eq(i).find("i").hasClass("bx-pause")) {
            $(".play-song-individual").eq(i).html(`<i class="bx bx-play"></i> PLAY`)
        }
    }


    if (callback && typeof callback === 'function') {
        callback();
    }
}






