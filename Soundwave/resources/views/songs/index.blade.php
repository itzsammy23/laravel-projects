@extends('layouts.app')

@section('content')


        <div class="landing">
            <main>
                <section>
                    <div class="home">
                        <div class="home-text" >
                            <h1 class="track-mod">Enjoy African Music and Podcasts on your Number one streaming app.</h1>
                            <a href="#" class="button">Join now</a>
                        </div>
                        <div class="home-image">
                            <img src="/storage/img/music.png" alt="black headphones on yellow background">
                        </div>
                    </div>
                </section>
                <section class="trends section">
                    <div class="trending">
                        <h3 class="section-title">Trending Music</h3>
                        <div class="trending-list">

                        </div>
                    </div>
                </section>
                <section class="new section">
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">
                            <div>
                                <h3 class="section-title">Latest Music</h3>
                                <div class="grid-margin stretch-card">
                                    <div>
                                        <div class="owl-carousel">
                                            @foreach($songs as $song)
                                            <div class="item">
                                                @if($song->cover_art == "")
                                                <img src="{{ '/storage/cover_art/record-33583_640.png' }}" alt="">
                                                @else
                                                <img src="/storage/cover_art/{{ $song->cover_art }}" alt="">
                                                @endif

                                                <img src="{{ $song->co }}" alt="">
                                                <a class="hero-carousel__slideOverlay">
                                                    <h3 class="song-title">{{$song->name}}</h3>
                                                    <p class="artiste">{{ $song->artist }}</p>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <div class="song-player">
            <div class="full-music-player">
                <div class="download">
                    <i class="bx bxs-download"></i>
                </div>
                <div class="image">
                    <img src="" alt="Song player cover art">
                </div>
                <div class="song-artist-details">
                    <h4 class="title"></h4>
                    <div class="artist-name"></div>
                </div>

                <div class="volume-slider">
                    <div class="volume-container">
                        <div class="slider-bar faded"><div class="fill-bar"></div></div>
                        <input type="range" class="amplitude-volume-slider faded">
                        <i class='bx bxs-volume-low unmute'></i>
                        <i class='bx amplitude-mute hidden-display'></i>
                    </div>
                </div>

                <div class="visualization">
                    <canvas id="canvas"></canvas>
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

                        <div class="duration">

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
