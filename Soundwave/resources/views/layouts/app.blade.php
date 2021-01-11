<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/music.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>
<body>
    <div id="app">
        <header>
            <nav>
                <div>


                    <div class="brand">
                        <h3>Gbedu</h3>
                    </div>

                    <div class="notifs">
                        <label class="switch">
                            <input type="checkbox" id="mode-toggler">
                            <span class="slider round"></span>
                        </label>
                        <ul>
                            <li>
                                <div class="search-box">
                                    <input type="text" name="" class="search-txt" placeholder="Search..."/>
                                    <a class="search-btn">
                                        <i class="bx bx-search-alt" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a href="#" id="modal"><i class='bx bxs-user' aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="loginModal" class="modal">

                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <form action="get">
                            <input type="text" name="Username" id="user" placeholder="Username..." aria-placeholder="Username" required>
                            <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            <input type="submit" value="Log in">
                            <p>Don't have account? <a href="#">Sign up</a> </p>
                        </form>
                    </div>

                </div>

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
    <script type="text/javascript" src="{{ asset('amplitudejs/dist/visualizations/michaelbromley.js') }}"></script>
    <script src="{{ asset('js/songplayer.js') }}"></script>
    <script src="{{ asset('js/testplayer.js') }}"></script>
   {{-- <script src="{{ asset('js/app.js') }}" defer></script>--}}
</body>
</html>
