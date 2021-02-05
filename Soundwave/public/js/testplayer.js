var color, palette, clickCount = 0, shuffling = false, repeat="off", color_dominant, mute_count = 0, repeat_process = false, skip_step = false;

$(document).ready(function () {
/*    const colorThief = new ColorThief();
    const img = new Image();
    var location = "http://127.0.0.1:8000/storage/cover_art/nobody.jpg"
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

        if (lightOrDark(color_dominant) === "light") {
            $(".song-artist-details .title, .song-artist-details .artist-name").addClass("dark-color")
            $(".bx-shuffle, .bx-repost").addClass("dark-color")
        } else{
            $(".song-artist-details .title, .song-artist-details .artist-name").addClass("light-color")
            $(".bx-shuffle, .bx-repost").addClass("light-theme")
        }

        $(":root")[0].style.setProperty("--slider-color", `rgb(${palette[1][0]}, ${palette[1][1]}, ${palette[1][2]})`)
        $(".skippers i").css("color", `rgb(${palette[0][0]}, ${palette[0][1]}, ${palette[0][2]})`)

        /!*var song_duration = Math.floor(parseInt(Amplitude.getSongDuration()))
        $(".duration").text(Math.floor(splitTime(song_duration)))*!/
    })*/


    $(".play-pause i").click(function () {

        if (clickCount == 0) {
            setInterval(checkPosition, 100);
            clickCount++;
        }
        if ($(this).hasClass("bx-play")) {
            $(this).removeClass("bx-play");
            $(this).addClass("bx-pause");

        } else{
            $(this).removeClass("bx-pause");
            $(this).addClass("bx-play");
        }
    })

    $(".bx-shuffle").click(function () {
       toggleColor(".bx-shuffle")


        if (shuffling == false) {
            $(".full-music-player .alert").html("");
            $(".full-music-player .alert").append("<p>Shuffling all songs..</p>")
            shuffling = true;
        } else {
            $(".full-music-player .alert").html("");
            $(".full-music-player .alert").append("<p>Shuffle off</p>");
            shuffling = false;
        }

        setTimeout(function () {
            $(".full-music-player .alert").html("");
        }, 500)
    })

    $(".no-repeat").click(function () {
        toggleColor(".bx-repost")
        if (repeat === "off") {
            $(".full-music-player .alert").html("");
            $(".full-music-player .alert").append("<p>Repeating all songs</p>");
            $(".amplitude-repeat").trigger("click");
            repeat = "all";
        } else if (repeat === "all") {
            $(".full-music-player .alert").html("");
            $(".full-music-player .alert").append("<p>Repeating current song</p>");
            $(".amplitude-repeat").trigger("click");
            $(".amplitude-repeat-song").trigger("click");
            $(".repeat-indicator").show()
            repeat = "current";
        } else{
            $(".full-music-player .alert").html("");
            $(".full-music-player .alert").append("<p>Repeat off</p>");
            $(".amplitude-repeat-song").trigger("click");
            $(".repeat-indicator").hide()
            repeat = "off";
        }

        setTimeout(function () {
            $(".full-music-player .alert").html("");
        }, 1500)
    })



    /*$(".full-music-player .image img").attr("src", location)*/


    $(".bx-skip-next, .bx-skip-previous").click(function () {
        setTimeout(function () {
                setSongAttributes()
                refreshSongDetails();
        }, 2000)
    })



    $(".song-slider input").on("input", function () {
        var val = $(this).val();
        $(".bar .fill").css("width", `${val}%`)
    })

    $(".volume-container input").on("input", function () {
        var val = $(this).val();
        $(".slider-bar .fill-bar").css("width", `${val}%`)

        if (val > 65) {
            $(".volume-container i").removeClass("bxs-volume-low")
            $(".volume-container i").addClass("bxs-volume-full")
        } else {
            $(".volume-container i").addClass("bxs-volume-low")
            $(".volume-container i").removeClass("bxs-volume-full")
        }
    })

    $(".volume-container .unmute").click(function () {
        repeat_process = false
        skip_step = false
        if (mute_count === 0) {
            console.log(mute_count)
            if ($(".volume-container input").hasClass("faded")){
                $(".volume-container input").removeClass("faded");
                $(".slider-bar").removeClass("faded");
            }else {
                mute()
                skip_step = true
                mute_count = 1
            }
        }


      if (skip_step === false) {
          if (mute_count === 1) {
             mute()
              console.log(mute_count)
          }
      }


        if (mute_count === 2) {
            $(".unmute").removeClass("bxs-volume-mute");
            $(".unmute").addClass("bxs-volume-low");
            $(".amplitude-mute").trigger("click")
            $(".volume-container input").val(15)
            $(".slider-bar .fill-bar").css("width", `15%`)
            mute_count = 0;
            repeat_process = true
            console.log(mute_count)
        }
       if (repeat_process != true) {
           mute_count++;
       }

    })



})

function checkPosition() {
    var progress_value = $(".song-slider input").val();
    /*   console.log(progress_value)*/
    $(".bar .fill").css("width", `${progress_value}%`)
    var interval = Math.floor(parseInt(Amplitude.getSongPlayedSeconds()));
    /* console.log(time.toString().length)*/


    $(".seconds").text(splitTime(interval))
}

function lightOrDark(color) {

    // Variables for red, green, blue values
    var r, g, b, hsp;

    // Check the format of the color, HEX or RGB?
    if (color.match(/^rgb/)) {

        // If RGB --> store the red, green, blue values in separate variables
        color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);

        r = color[1];
        g = color[2];
        b = color[3];
    } else {

        // If hex --> Convert it to RGB: http://gist.github.com/983661
        color = +("0x" + color.slice(1).replace(
            color.length < 5 && /./g, '$&$&'));

        r = color >> 16;
        g = color >> 8 & 255;
        b = color & 255;
    }

    // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
    hsp = Math.sqrt(
        0.299 * (r * r) +
        0.587 * (g * g) +
        0.114 * (b * b)
    );
    console.log(hsp)
    // Using the HSP value, determine whether the color is light or dark
    if (hsp > 127.5) {

        return 'light';
    } else {

        return 'dark';
    }
}

function toggleColor(className) {
    if (lightOrDark(color_dominant) === "light") {
        $(className).toggleClass("light-color")
    }else {
        $(className).toggleClass("dark-color")
    }
}

function mute() {
    if( $(".unmute").hasClass("bxs-volume-low")){
        $(this).removeClass("bxs-volume-low")
    } else {
        $(this).removeClass("bxs-volume-full")
    }

    $(".unmute").addClass("bxs-volume-mute");
    $(".volume-container input").val(0)
    $(".slider-bar .fill-bar").css("width", `0%`);
    $(".amplitude-mute").trigger("click")
}

function checkTimeLength(time) {
    var appended_time
    if (time.toString().length == 1) {
        var append ="0"
        appended_time  = append.concat(time.toString());
    } else {
        appended_time =  time.toString();
    }

    return appended_time;
}

function splitTime(time) {
    var sliced, new_duration, stringify;
    if (time < 10) {
        sliced = "00:0"
        stringify = time.toString();
        new_duration = sliced.concat(stringify)
    }else {
        if (time <= 59) {
            sliced = "00:"
            stringify = time.toString();
            new_duration = sliced.concat(stringify)
        }else{
            if (time < 3599) {
                var minutes = Math.floor(time / 60);
                var seconds = time % 60;
                var appended_minutes = checkTimeLength(minutes)
                var appended_seconds = checkTimeLength(seconds)

                new_duration = appended_minutes +":"+ appended_seconds
            } else {
                var hours = time / 60;
                var minutes = (hours % 1) * 60;
                var seconds = (minutes % 1) * 60;
                var appended_hours = checkTimeLength(Math.floor(hours))
                var appended_minutes = checkTimeLength(Math.floor(minutes))
                var appended_seconds = checkTimeLength(Math.floor(seconds))

                new_duration = appended_hours +":"+ appended_minutes + ":" + appended_seconds
            }
        }
    }

    return new_duration
}






