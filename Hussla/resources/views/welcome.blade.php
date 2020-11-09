<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hussla - the best artisan marketplace you'll find on the web</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/font-awesome.min.css">

        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>

    </head>
    <body>
     <div class="starter">
     <nav class="navbar navbar-expand-md landing-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Hussla
                </a>
                <button id="toggler" type="button" onclick="toggle();">
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
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                        <a class="nav-link" href="/customer/login">Sign In(Customer)</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="/customer/register">Sign Up(Customer)</a>
                                    </li>

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

            <div class="col-md-8 first-view pt-5 pl-5" id="first-view">
                <h2>Welcome to the home of quality service.</h2>
                <h4>Get access to the best service providers in the state<h4>


                <div class="links d-inline">
                    <a href="/servicefinder" class="btn mr-3 ml-3"><span>Get Started </span></a>
                </div>
                <div class="know-more pt-4 pl-3">Want to know more ? <b>Scroll down</b></div>
            </div>
        </div>


        <div align="center" class="find-service mt-5">Find the best : </div>

        <div align="center" class="slide-show container">


        <div class="col-md-3 item">
            <i class="fas fa-faucet"></i>
            <h5> Plumbers</h5>
            </div>

            <div class="col-md-3 item">
            <i class="fas fa-hammer"></i>
            <h5>Carpenters</h5>
            </div>

            <div class="col-md-3 item">
            <i class="fas fa-lightbulb"></i>
            <h5>Electricians</h5>
            </div>

            <div class="col-md-3 item">
            <i class="fas fa-tools"></i>
            <h5>Auto mechanics</h5>
            </div>
        </div>

        <div class="pt-3 and-more" align="center">And more...<a href="/servicefinder">Explore all categories</a></div>
        <div class="how-it-works" align="center">How It Works</div>

        <div class="container content-list">
            <div class="row">
                <div class="search col-md-3">
                <i class="fas fa-search"></i>
                <h3>SEARCH<h3>
                <p>Search for a service provider around you.</p>
                </div>

                <div class="search col-md-3">
                <i class="fas fa-phone-alt"></i>
                <h3>CONTACT<h3>
                <p>Contact the service provider through a call or text.</p>
                </div>
                <div class="search col-md-3">
                <i class="fas fa-handshake"></i>
                <h3>CONNECT<h3>
                <p>Connect with the service provider.</p>
                </div>

                <div class="search-last col-md-3">
                <i class="fas fa-star"></i>
                <h3>FEEDBACK<h3>
                <p>Rate and review the service provider.</p>
                </div>
            </div>
        </div>
        <div align="center" class="pt-5 pb-5"><a href="/servicefinder" class="btn"><span>Get Started </span></a></div>
        <div class="how-it-works-two" align="center" style="color: #000d1a;">Want to become a service provider ?</div>
        <div class="container content-list">
            <div class="row">
                <div class="search col-md-3">
                <i class="fas fa-user-plus"></i>
                <h3>SIGN UP<h3>
                <p>Sign up as a service provider and get a free 90 day account.</p>
                </div>

                <div class="search handshake col-md-3">
                <i class="fas fa-handshake"></i>
                <h3>CONNECT<h3>
                <p>Connect with customers and provide your services.</p>
                </div>
                <div class="search col-md-3">
                <i class="fas fa-eye"></i>
                <h3>MONITOR<h3>
                <p>Keep track of your profile views and ratings and edit your profile anytime.</p>
                </div>

                <div class="search-last col-md-3">
                <i class="fas fa-sync-alt"></i>
                <h3>RENEW<h3>
                <p>Renew your subscription annually.</p>
                </div>
            </div>
        </div>

       <div class="container">
           <div class="row pt-5">
                   <div class="col-md-3 keypad">
                       <img src="/storage/landing/keypad2.jpeg">
                   </div>
                   <div class="col-md-9 advert">
                        <h2>Become a service provider</h2>
                        <p>Recieve lots of calls from people that require your services and become the top
                        rated service provider on Hussla</p>

                    <div align="center" class="mt-5"><a href="/register" class="button"><span>Sign Up</span></a></div>
                </div>
           </div>
       </div>

        <div class="container why-hussla mt-5">
                    <h4>Why Hussla.ng?</h4>
                    <div class="row">
                        <div class="connector d-flex">
                            <div class="col-md-2 d-block pb-5 pt-5 ml-2">
                                <div class="circle"></div>
                                <div class="connector-line"></div>
                                <div class="circle"></div>
                                <div class="connector-line"></div>
                                <div class="circle"></div>
                                <div class="connector-line"></div>
                                <div class="circle"></div>
                            </div>

                            <div class="why-hussla-content col-md-10 pt-5">
                            <div class="points col-md-12 pb-4">Hussla.ng is user-friendly and easy to use.</div>
                            <div class="points col-md-12 pb-2">Hussla.ng provides an easy platform for connecting
                                clients with service providers.
                            </div>
                            <div class="points col-md-12 pb-4">Hussla members are seasoned individuals with
                                wealth of experience.</div>
                                <div class="points col-md-12 pb-4">Hussla service providers are trust-worthy and
                                 reliable.</div>
                            </div>
                        </div>
                    </div>
                </div>


                    <div id="loaded-content">
                        <div id="loader"></div>

                        <div class="further-content" id="further-views">
                            <div class="container questions">
                                <div class="row">
                            <button type="button" class="collapsible">Are Hussla.ng services free ? <span class="caret float-md-right">
                            <i class="fas fa-caret-down" id="toggleArrow"></i>
                            </span></button>
                            <div class="content">
                                <p>Using Hussla.ng to find and connect with service providers is free. However the services of the
                                    professionals are not for free.
                                </p>
                            </div>
                            <button type="button" class="collapsible">Are Hussla.ng service providers reliable ? <span class="caret float-md-right">
                            <i class="fas fa-caret-down" id="toggleArrow"></i>
                            </span></button>
                            <div class="content">
                                <p>All service providers are seasoned and competent professionals who you can rely on to give you the best
                                    possible service.
                                </p>
                            </div>
                            <button type="button" class="collapsible">How long does it take to find a service provider ? <span class="caret float-md-right">
                            <i class="fas fa-caret-down" id="toggleArrow"></i>
                            </span></button>
                            <div class="content">
                                <p>We connect you with the service providers closest to your location so having a service provider meet up to assist with your need
                                    should only take a couple of minutes.
                                </p>
                            </div>
                                </div>
                            </div>

                            <div class="how-it-works" align="center">Testimonials</div>

                            <div class="container pb-5 pt-5">
                                <div class="row">
                                    <div class="col-md-10 testimonial">
                                    <em>"Hussla.ng is a great open platform that connects people
                                        with professional and reliable experts that can solve your most immediate problems."</em>
                                        <div class="anchor pt-3">Jethro Osifuwa, CEO Innovate</div>
                                        </div>
                                    <div class="picture col-md-2">
                                        <img src="/storage/landing/african-american-3279360_640.jpg">
                                    </div>

                                </div>
                            </div>


                            <div class="container pb-5 pt-5">
                                <div class="row">
                                <div class="second-picture col-md-2">
                                        <img src="/storage/landing/IMG-20200621-WA0019.jpg">
                                    </div>

                                    <div class="col-md-10 second-testimonial">
                                    <em>"Hussla.ng is an innovative idea which benefits both service
                                            providers and customers alike.I'm proud to be a part of this project."</em>
                                        <div class="anchor pt-3">Okurounmu Peter, Co-Founder Internnect</div>
                                        </div>
                                </div>
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

            <div align="center" style="color: #fff; font-size: 20px;"><i class="far fa-copyright"></i> Hussla {{date("Y")}}</div>
            </div>



    </body>
    <script>
        	var slideIndex = 0;
	showSlides();


function showSlides() {
  var i;
  var slides = document.getElementsByClassName("item");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 2000);
}


    var coll = document.getElementsByClassName("collapsible");
    var caret = document.getElementById("toggleArrow");
    var i;

    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }

    caret.classList.toggle("fa-caret-up");
  });
}

function getDocHeight() {
    return Math.max(
        document.body.scrollHeight, document.documentElement.scrollHeight,
        document.body.offsetHeight, document.documentElement.offsetHeight,
        document.body.clientHeight, document.documentElement.clientHeight
    )
}

function amountscrolled(){
    var winheight= window.innerHeight || (document.documentElement || document.body).clientHeight
    var docheight = getDocHeight()
    var scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop
    var trackLength = docheight - winheight
    var pctScrolled = Math.floor(scrollTop/trackLength * 100)
    var loadedContent = document.getElementById("loaded-content");
    console.log(pctScrolled + '% scrolled')

    function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("further-views").style.display = "block";
}

    if(pctScrolled >= 80) {
        loadedContent.style.display = "block";
        var time;
        time = setTimeout(showPage, 1500);
    }
}

window.addEventListener("scroll", function(){
    amountscrolled()
}, false)

function toggle() {
   var toggler = document.getElementById("toggle-change");
   var togglerContent = document.getElementById("navbarSupportedContent");
   var firstView = document.getElementById("first-view");

   if(togglerContent.style.display == "none") {
       togglerContent.style.display = "block";
       firstView.style.display = "none";
   } else {
       togglerContent.style.display = "none";
       firstView.style.display = "block";
   }
  // toggler.classList.toggle("fa-times");
}
</script>
</html>
