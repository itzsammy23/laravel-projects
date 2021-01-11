@extends('layouts.app')

@section('content')
<div class="song-player">
        <div class="full-music-player">
            <div class="image">
                <img src="" alt="Song player cover art">
            </div>
            <div class="song-artist-details">
                <h4 class="title">Strings And Blings</h4>
                <div class="artist-name">Nasty C</div>
            </div>

            <div class="volume-slider">
                <div class="volume-container">
                    <div class="slider-bar faded"><div class="fill-bar"></div></div>
                    <input type="range" class="amplitude-volume-slider faded">
                    <i class='bx bxs-volume-low unmute'></i>
                    <i class='bx amplitude-mute hidden-display'></i>
                </div>
            </div>

            <div class="py-2">
                <div class="amplitude-visualization"></div>
            </div>

            <div class="song-controls">
                <div class="song-slider">
                    <div class="bar"><div class="fill"></div></div>
                    <input type="range" class="amplitude-song-slider" step=".1"/>
                </div>

            <div class="time-tracker">
                <div class="seconds">
                    00:00
                </div>

                <div class="song-duration">

                </div>
            </div>


                <div class="full-controls">
                    <div class="song-shuffle">
                        <i class='bx bx-shuffle amplitude-shuffle'></i>
                    </div>

                    <div class="song-controller">
                        <div class="previous skippers">
                            <i class="bx bx-skip-previous controller amplitude-prev"></i>
                        </div>

                        <div class="play-pause">
                            <i class="bx bx-play controller amplitude-play-pause"></i>
                        </div>

                        <div class="next skippers">
                            <i class="bx bx-skip-next controller amplitude-next"></i>
                        </div>
                    </div>

                    <div class="song-repeat">
                        <i class='bx bx-repost no-repeat'></i>
                        <i class='bx bx-repost amplitude-repeat repeat-all hidden-display'></i>
                        <i class='bx bx-repost amplitude-repeat-song repeat-current hidden-display'></i>
                        <span class="repeat-indicator">1</span>
                    </div>
                </div>
            </div>

            <div class="alert"></div>
        </div>


</div>




@endsection
