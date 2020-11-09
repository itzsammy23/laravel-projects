<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tester.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/font-awesome.min.css">
</head>
<body>
<div id="cover">
<div id="app">
    <nav class="navbar navbar-expand-md ">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="color: #cc3399;" >
                LAW INSIDER
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <i class="fas fa-bars" id="toggle-change"  style="color: #fff; font-size: 28px;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}" style="color: #ff99cc;">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}" style="color: #ff99cc;">{{ __('Register') }}</a>
                            </li>
                        @endif

                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="/profile/{{ Auth::user()->hussla_id }}" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->firstname }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                        <li class="nav-item">
                            <a class="nav-link" href="/customer/login">Sign In(Customer)</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/customer/register">Sign Up(Customer)</a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

            </li>
            @endguest
            </ul>
            </div>
        </div>
</nav>
</div>
       <div class="container">
           <div class="row justify-content-center align-items-center" style="height: 400px">
               <div class="banner col-4">
                   <img src="/storage/landing/scales-2579312_640.jpg">
               </div>

               <div class="banner-text col-md-6 mb-3 ml-5">
                   <div class="font-weight-bold law">LAW INSIDER</div>
                   <div class="purple">
                       The law student's academic paradise</div>
                   <div class="desc">Find e-books, audio books and tutors to help boost your
                    academic performance. </div>
                   <div class="link pt-5"><a href="#">Get Started</a></div>
               </div>
           </div>
       </div>
</div>

<div class="slideshow" id="slideshow">
    <h2 style="color: #cc3399">Activities</h2>

    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="box">
                <div class="transit">
                <img src="/storage/landing/guy-2557251_640.jpg" class="w-100">
                <div class="caption text-md-left pl-5">See the top rated tutors</div>
                </div>
              <div class="ease">
                  <div class="text pl-4 pb-4">Check out the highest rated tutors on our platform as reviewed by our users.</div>
                  <div class="anchor pl-4"><a href="#">Explore</a></div>
              </div>

            </div>

            <div class="box">
                <div class="transit">
                    <img src="/storage/landing/study-1968077_640.jpg" class="w-100">
                    <div class="caption text-md-left pl-5">Newly uploaded e-books</div>
                </div>
                    <div class="ease">
                        <div class="text pl-4 pb-4">See the latest e-books we've uploaded recently.</div>
                        <div class="anchor pl-4"><a href="#">Explore</a></div>
                    </div>
            </div>

            <div class="box">
                <div class="transit">
                    <img src="/storage/landing/headphones-791078_640.jpg" class="w-100">
                    <div class="caption text-md-left pl-5">Audio books</div>
                </div>
                  <div class="ease">
                      <div class="text pl-4 pb-4">Listen to or download our newest audio books.</div>
                      <div class="anchor pl-4"><a href="#">Explore</a></div>
                  </div>

            </div>
        </div>
    </div>

    <div style="text-align: center">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</div>

<h2 style="color: #000000">Services We Offer</h2>

<div class="container">
   <div class="row justify-content-center align-items-center">
       <div class="encode col-md-4">
            <div align="center" class="mt-4"><i class="fas fa-pen-alt"></i></div>
           <h4>Tutelage</h4>
           <p>We connect you with tutors from the faculty of law to guide you
           on whatever course you may need help with .</p>
           <div align="center"><a href="#">Learn more <i class="fas fa-angle-double-right"></i></a></div>
       </div>

       <div class="encode col-md-4">
           <div align="center" class="mt-4"><i class="fas fa-book"></i></div>
           <h4>E-books</h4>
           <p>We provide you with quality books to help you study and get better grades.</p>
           <div align="center"><a href="#">Learn more <i class="fas fa-angle-double-right"></i></a></div>
       </div>
   </div>
</div>

<div class="container">
    <div class="row justify-content-center align-items-center">
            <div class="encode col-md-4 mt-5 mb-4">
                <div align="center" class="mt-4"><i class="fas fa-headphones"></i></div>
                <h4>Audio books</h4>
                <p>We also provide top quality audio books you can listen to on our platform or
                    download to listen later.</p>
                <div align="center"><a href="#">Learn more <i class="fas fa-angle-double-right"></i></a></div>
            </div>
    </div>
</div>

<h2 style="color: #003366">Reviews from our users</h2>

<div class="customer container">
    <div class="row justify-content-center align-items-center">
        <div class="review col-md-5 d-flex">
            <div class="picture col-md-4">
                <img src="/storage/landing/smiling-4654734_12802.jpg">
            </div>
            <div class="testimonial col-md-8">
                <p><span>" </span><em>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat.</em><span>"</span> </p>

                <div class="pt-3">
                    <h4 style="font-weight: bold; color: #000066">Juliet Kingsley</h4>
                    <h5>Final year law student, UNILAG</h5>
                </div>
            </div>
        </div>

        <div class="review col-md-5 d-flex">
            <div class="picture col-md-4">
                <img src="/storage/landing/IMG-20200621-WA0019.jpg">
            </div>
            <div class="testimonial col-md-8">
                <p><span>" </span><em>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</em><span>"</span> </p>

                <div class="pt-3">
                    <h4 style="font-weight: bold; color: #000066">John Adegbenga</h4>
                    <h5>300L law student, UNILAG</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="help col-md-10">
            <h2 style="color: #cc3399">Need further educational help ?</h2>
            <p>If you're in the faculty of law and need further educational assistance in areas like assignments,
            projects and so on, you can send us your email and we'll get back to you shortly</p>

            <form method="POST" action="#">
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label font-weight-bold text-md-right">
                        {{ __('E-Mail Address') }} : </label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address..">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="footer">
    <div class="col-md-12 footer-container pb-5">
        <div class="col-md-3 d-block">
            <div class="column">WHAT WE DO</div>
            <div class="alignment">About Us</div>
            <div class="alignment">Projects</div>
            <div class="alignment">Recommendations</div>
            <div class="alignment">Portfolio</div>
        </div>

        <div class="col-md-3 cover d-block">
            <div class="column">CONTACT</div>
            <div class="alignment">Contact Us</div>
            <div class="alignment">FAQ</div>
            <div class="alignment">Advertise</div>
            <div class="alignment">Broadcast</div>
        </div>

        <div class="col-md-3 cover d-block">
            <div class="column">LEGALS</div>
            <div class="alignment">Terms Of Use</div>
            <div class="alignment">Privacy Policy</div>
        </div>

        <div class="col-md-3 cover d-block">
            <div class="column">SOCIALS</div>
            <div class="alignment"><i class="fab fa-facebook"></i></div>
            <div class="alignment"><i class="fab fa-instagram"></i></div>
            <div class="alignment"><i class="fab fa-twitter"></i></div>
        </div>
    </div>

    <div align="center" style="color: #fff; font-size: 20px;"><i class="far fa-copyright"></i> Law Insider  {{date("Y")}}</div>
</div>


</body>
<script>
    var slideIndex = 0;
    showSlides();

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides() {
        var slides = document.getElementsByClassName('box');
        var dots = document.getElementsByClassName('dot');
        for (var i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (var i = 0; i < dots.length; i++) {
           dots[i].className = dots[i].className.replace(" active", "");
        }
        slideIndex++;
        if( slideIndex > slides.length) {slideIndex = 1}
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        setTimeout(showSlides, 10000);
    }
</script>
</html>

