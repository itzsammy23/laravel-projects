<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="We are the best nigerian and general african FREE music streaming and download platform, easy to use, NO ADS,
     with smooth user interface and experience. Join the gbedu community and enjoy free streaming and download of the latest african music">
    <meta name="og:image" property="og:image" content="{{ asset('storage/img/gbedu-main.png') }}" />
    <meta name="og:description" property="og:description" content="We are the best nigerian and general african FREE music streaming and download platform, easy to use, NO ADS,
     with smooth user interface and experience. Join the gbedu community and enjoy free streaming and download of the latest african music" />
    <meta name="og:title" property="og:title"  content="Personal Business Blog" />
    <meta name="twitter:card" property="twitter:card"  content="summary" />
    <meta name="twitter:title" property="twitter:title"  content="Gbedu" />
    <meta name="twitter:description" property="twitter:description"  content="We are the best nigerian and general african FREE music streaming and download platform, easy to use, NO ADS,
     with smooth user interface and experience. Join the gbedu community and enjoy free streaming and download of the latest african music" />
    <meta name="twitter:image" property="twitter:image" content="{{ asset('storage/img/gbedu-main.png') }}" />
    <meta property="og:image:width" content="200"/>
    <meta property="og:image:height" content="200"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gbedu - FREE Nigerian and general African music streaming and download platform </title>

    <!-- Styles -->
    <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/music.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon">

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>
<body>
    <div id="app">
        <header class="navbar__header">
            <nav>
                <div class="nav-container">


                    <div class="brand">
                        <h3>Gbedu</h3>
                    </div>

                    <div class="notifs">
                        <label class="switch">
                            <input type="checkbox" id="mode-toggler">
                            <span class="slider round"></span>
                            <i class='bx bxs-moon' id="dark-moon"></i>
                        </label>
                        <ul>
                            <li>
                              <div class="nav-list-item upload-song">
                                      <div class="icon"><i class="bx bxs-cloud-upload nav-icon"></i></div>
                                      <div class="tag">Upload</div>
                              </div>
                            </li>

                            <li>
                                <div class="nav-list-item create-playlist">
                                    <div class="icon"><i class="bx bxs-disc nav-icon"></i></div>
                                    <div class="tag">Playlists</div>
                                </div>
                            </li>

                            <li>
                                <div class="nav-list-item join">
                                    <div class="icon"><i class="bx bxs-user nav-icon"></i></div>
                                    <div class="tag">Join</div>
                                </div>
                            </li>

                            <li class="search-bar" id="search-bar">
                                <div class="search-box">
                                    <input type="text" name="" class="search-txt" placeholder="Search..."/>
                                    <a class="search-btn">
                                        <i class="bx bx-search-alt" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="result__placer"></div>
                            </li>
                        </ul>
                    </div>
                </div>
               {{-- <div id="loginModal" class="modal">

                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <form action="get">
                            <input type="text" name="Username" id="user" placeholder="Username..." aria-placeholder="Username" required>
                            <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            <input type="submit" value="Log in">
                            <p>Don't have account? <a href="#">Sign up</a> </p>
                        </form>
                    </div>

                    <i class='bx bxs-cloud-upload'></i>
                    <i class='bx bxs-disc'></i>
                    <i class='bx bx-list-plus'></i>

                </div>--}}

            </nav>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="{{ asset('js/slick.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@5.2.0/dist/amplitude.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script src="{{ asset('js/songplayer.js') }}"></script>
    <script src="{{ asset('js/testplayer.js') }}"></script>
   {{-- <script src="{{ asset('js/app.js') }}" defer></script>--}}
</body>
</html>
