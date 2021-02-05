@extends('layouts.app')

@section('content')
        <div class="banner">
            <div class="banner__container">
                <div class="banner__content">
                    <img src="/storage/img/gbedu-main.png">
                    <h2>GBEDU</h2>
                </div>
            </div>
        </div>

        <div class="view__mode">
            <div class="mode">{{ $data["view_mode"] }}</div>
            @if($data["has_song"] != false)
                <span id="view__mode__song">{{ $data["song"] }}</span>
            @endif

            @if($data["has_item"] != false)
                <span id="playlist__name">{{$data["playlist_name"]}}</span>
                <img src="{{$data["playlist_art"]}}" id="playlist__image">
            @endif
        </div>

        <div class="delete__modal hidden-display" id="delete__song__modal">
            <div class="box">
                <p>Are you sure you want to remove this song from the playlist?</p>

                <div class="buttons">
                    <button class="delete__button" id="delete__song"><i class='bx bxs-trash-alt'></i> &nbsp;Remove</button>
                    <button class="cancel__button"><i class='bx bxs-x-circle'></i> &nbsp;Cancel</button>
                </div>
            </div>
        </div>

        <div class="delete__modal hidden-display" id="delete__playlist__modal">
            <div class="box">
                <p>Are you sure you want to delete this playlist?</p>

                <div class="buttons">
                    <button class="delete__button" id="delete__playlist"><i class='bx bxs-trash-alt'></i> &nbsp;Delete</button>
                    <button class="cancel__button"><i class='bx bxs-x-circle'></i> &nbsp;Cancel</button>
                </div>
            </div>
        </div>

        <div class="add__song__modal hidden-display">
            <div class="box">
                <span class="close" id="close__add__modal">&times;</span>
              <form method="post" id="add-songs-to-playlist" data-route="/add/to/playlist">
                  <div class="form-group mb-1">
                      <div class="w-100 d-flex">
                          <input type="text"  name="add_new_song" class="form-control w-85 add-new-song" placeholder="Add new songs...">
                          <button class="sound__buttons btn__light ml-1 add-song">Add</button>
                      </div>
                      <div class="show-songs"></div>
                  </div>
                  <div class="songs-added mb-3 pl-0 col-md-12 d-flex playlist__new__songs"></div>

                  <div class="button__container">
                      <button type="submit" id="add-to-playlist-submit" class="sound__buttons btn__dark">Add songs to playlist</button>
                  </div>
              </form>
            </div>
        </div>

        <div class="change__modal hidden-display">
            <div class="box">
                <span class="close" id="close__change__modal">&times;</span>
                <div class="form-group mb-1 mt-4">
                    <div class="w-100 d-flex">
                        <input type="text"  id="change__name" name="change__name" class="form-control w-100" placeholder="Enter new playlist name">
                    </div>
                    <button class="sound__buttons btn__dark mt-2" id="change__name__button">Change</button>
                </div>
            </div>
        </div>

        <div class="picture__modal hidden-display">
            <div class="box">
                <span class="close" id="close__picture__modal">&times;</span>
                <div class="cover__art__demo"><i class="bx bxs-camera"></i></div>
                <div class="file-icon">
                    <input type="file" name="file" id="cover__art__demo__image" class="inputfile">
                    <label for="cover__art__demo__image">Select Cover Art</label>
                    <button class="sound__buttons btn__light" id="change__cover__art">Change cover art</button>
                </div>
            </div>
        </div>

        <div class="landing sections hidden-display">
            <main>
                <section>
                    <div class="home">
                        <div class="home-text" >
                            <h3 class="track-mod">Enjoy African Music and Podcasts on your Number one streaming app.</h3>
                            <a href="#" class="button join__now">Join now</a>
                        </div>
                        <div class="home-image">
                            <img src="/storage/img/music.png" alt="Gbedu - FREE music streaming and download platform banner">
                        </div>
                    </div>
                </section>

                <section class="mobile__search__bar">
                        <div class="search__box">
                            <input type="text" name="" class="search-txt" placeholder="Search..."/>
                            <i class="bx bx-search-alt" aria-hidden="true"></i>
                            <div class="result__placer"></div>
                        </div>
                </section>
                <section class="trends">
                    <div class="trending">
                        <h3 class="section-title">Trending Music</h3>
                        <div class="trending-list">

                        </div>
                    </div>
                </section>
                <section class="new">
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
                                                <img src="{{ '/storage/cover_art/record-33583_640.png' }}" alt="GBEDU - latest music cover image">
                                                @else
                                                <img src="/storage/cover_art/{{ $song->cover_art }}" alt="GBEDU - latest music cover image">
                                                @endif

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

      <section class="playlist__create__new hidden-display sections">
          <div class="heading">
              <div class="profile__photo"><i class="bx bxs-camera"></i></div>
          </div>

          <div class="art__uploader">
              <div class="file-icon">
                  <input type="file" name="file" id="cover__art__file" class="inputfile">
                  <label for="cover__art__file">Select Playlist Art</label>
              </div>
          </div>
          <div class="playlist-create">
              <form method="post" id="create-playlist" data-route="/create/playlist">
                  <div class="form-group mb-4">
                      <div class="w-100">
                          <input type="text" id="playlist-name" name="playlist-name" class="form-control" placeholder="Name of your playlist...">
                      </div>
                  </div>


                  <div class="form-group mb-1">
                      <div class="w-100 d-flex">
                          <input type="text"  name="add_new_song" class="form-control w-85 add-new-song" placeholder="Add new songs...">
                          <button class="sound__buttons btn__light ml-1 add-song">Add</button>
                      </div>
                      <div class="show-songs"></div>
                  </div>
                  <div class="songs-added mb-3 pl-0 col-md-12 d-flex"></div>

                  <button type="submit" id="playlist-submit-button" class="sound__buttons btn__dark">Create Playlist</button>
              </form>
          </div>
      </section>

        <div class="not__authenticated sections hidden-display"><a class="join">Login</a> to access this section</div>

        <section class="playlist__list hidden-display sections">
            <a class="create__playlist__link"><i class="bx bx-plus"></i> New Playlist</a>
            <header>Your playlists</header>
            <div class="loader mx-auto my-4"></div>

        </section>

        <section class="playlist__full__view hidden-display sections">
            <header class="full__view__header">
                <div class="header__container">
                    <img src="" alt="playlist cover art">
                    <div class="control__buttons">
                        <div class="shuffle control" id="playlist__shuffle">
                           <i class="bx bx-shuffle"></i> Shuffle
                        </div>

                        <div class="play control" id="playlist__play__all">
                            <i class="bx bx-play"></i> Play All
                        </div>
                    </div>
                </div>

                <div class="floated-dot">
                    <div class="floated-vertical-dots">
                        <ul>
                            <li>
                                <a class="additional-options-dots" id="extra-options"><i class='bx bx-dots-vertical-rounded'></i></a>
                                <ul class="additional-options-content hidden-display" id="extra-options-content">
                                    <li class="delete__playlist" id="show__delete__modal"><i class='bx bxs-trash-alt'></i> <a>Delete playlist</a></li>
                                    <li class="add" id="add__button"><i class="bx bx-plus"></i> <a>Add songs to playlist</a></li>
                                    <li class="change__art"><i class="bx bxs-camera"></i> &nbsp;<a>Change cover art</a></li>
                                    <li class="change__name"><i class="bx bxs-pencil"></i> &nbsp;<a>Change playlist name</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="full__view__list">
                <h3 class="full__view__playlist__title"></h3>

            </div>
        </section>



        <section class="song-player hidden-display sections">
            <div class="full-music-player">
                <div class="download">
                    <i class="bx bxs-download"></i>
                </div>
                <div class="image">
                    <img src="@if($data["has_song"] === true) {{$data["cover_art"]}} @endif" alt="Song player cover art">
                </div>
                <div class="song-artist-details">
                    <h4 class="title">
                        @if($data["has_song"] === true)
                            {{ $data["song"] }}
                            @endif
                    </h4>
                    <div class="artist-name">
                        @if($data["has_song"] === true)
                            <span>{{ $data["artist"] }}</span>
                        @endif
                    </div>
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
                            @if($data["has_song"] === true)
                            {{" "}}
                                @else
                                {{ "00:00" }}
                            @endif
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
                <div class=" hidden-display hidden-controller">
                    <audio src="/song/find/10" id="hidden-audio" autoplay="true" muted="true"></audio>
                </div>
            </div>


        </section>

        <section class="song__upload hidden-display sections">
            <form method="post" id="upload-song" data-route="/upload">
                <div class="form-group">
                    <label for="song-name" class="col-md-3 col-form-label">Song Name</label>
                    <div class="col-md-12">
                        <input type="text" id="song-name" name="song-name" class="form-control" placeholder="Name of the song">
                    </div>
                </div>

                <div class="form-group">
                    <label for="song-artist" class="col-md-3 col-form-label">Artiste(s)</label>
                    <div class="col-md-12">
                        <input type="text" id="song-artist" name="song-artist" class="form-control" placeholder="Name of the artiste(s)">
                    </div>
                </div>

                <div class="genre__selector">
                    <label for="genre-select" class="col-md-3 col-form-label pl-0">Genre</label>
                    <ul id="genre-select">
                        <li class="genre__list"><span class="current__selection">Hip hop</span> <i class="bx bxs-down-arrow"></i>
                            <ul class="genre-full-list hidden-display">
                                <li><span>Afro pop</span></li>
                                <li><span>Reggae</span></li>
                                <li><span>Traditional</span></li>
                                <li><span>RnB</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="form-group">
                    <label for="song-release-year" class="col-md-3 col-form-label">Release year</label>
                    <div class="col-md-12">
                        <input type="text" id="song-release-year" name="song-release-year" class="form-control" placeholder="Song release year">
                    </div>
                </div>

                <div class="form-group">
                    <label for="song-album" class="col-md-3 col-form-label">Album</label>
                    <div class="col-md-12">
                        <input type="text" id="song-album" name="song-album" class="form-control" placeholder="Album the song belongs to">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 ">
                        <div class="file-icon">
                            <input type="file" name="song-file" id="song-file" class="inputfile">
                            <label for="song-file"><button class="sound__buttons btn__dark">Select song</button></label>
                        </div>
                        <div class="preview__name__text col-md-8"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 d-flex cover__art__selector">
                        <div class="preview">
                            <i class="bx bxs-camera"></i>
                        </div>
                        <div class="file-icon">
                            <input type="file" name="song-cover-art" id="song-cover-art" class="inputfile">
                            <label for="song-cover-art"><button class="sound__buttons btn__dark">Choose song cover art</button></label>
                        </div>
                    </div>
                </div>

                <div id="error-messages" class="error-messages"></div>
                <div class="col-md-12 pl-0 d-flex align-items-center">
                    <button type="submit" id="song-upload-button" class="sound__buttons btn__light ml-3">Upload Song</button>
                    <div class="loader ml-3"></div>
                </div>

            </form>
        </section>

        <section class="login sections hidden-display">
            <div class="form__container col-md-12">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" id="login-form" data-route="/user/login">
                            <div class="form-group">
                                <label for="email" class="col-md-4 col-form-label">Email address</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control email" id="email" name="email" placeholder="Enter your email address">
                                    <span class="invalid-email-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 col-form-label">Password</label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control password"  name="password" placeholder="Type in your password">
                                    <span class="invalid-password-feedback" role="alert"></span>

                                </div>
                            </div>

                            <div class="form-group" class="feedback"></div>
                            <div class="col-md-12 d-flex justify-content-center align-items-center"><div class="loader text-center my-3"></div></div>

                            <div class="form-group row mb-0 mx-1">
                                <div class="col-12">
                                    <button type="submit" class="sound__buttons btn__light login-submit w-100">
                                        Log in
                                    </button>
                                </div>

                            </div>

                            <div class="sign__up">Don't have an account? <a class="register-new-user">Sign Up</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="register sections hidden-display">
            <div class="col-12 form__container">
                <div class="card">
                    <div class="card-header">Create your account</div>

                    <div class="card-body">
                        <form method="POST" id="register-form" data-route="/register/user">
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">Username</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control username" name="username" placeholder="Enter a username" autofocus>
                                    <span class="invalid-name-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 col-form-label">E-Mail Address</label>
                                <div class="col-md-12">
                                    <input type="email" class="form-control email" name="email" placeholder="Enter your email address">
                                    <span class="invalid-email-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 col-form-label">Password</label>
                                <div class="col-md-12">
                                    <input type="password" class="form-control password" name="password" placeholder="Type in a password">
                                    <span class="invalid-password-feedback" role="alert"></span>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 col-form-label">Confirm Password</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Repeat typed password">
                                </div>
                            </div>

                            <div class="form-group" class="feedback"></div>

                            <div class="col-md-12 d-flex justify-content-center align-items-center"><div class="loader text-center my-3"></div></div>

                            <div class="form-group row mb-0 ml-2">
                                <div class="col-md-12">
                                    <button type="submit" class="sound__buttons btn__dark w-100 register-submit">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

@endsection
