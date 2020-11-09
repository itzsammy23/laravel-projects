<body style="background-color: #f2f2f2;">
@extends('layouts.app')
<head>
    <script src="{{ asset('js/ajaxsearch.js') }}" defer></script>
    <script src="{{ asset('js/geolocator.js') }}" defer></script>
</head>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group row  offset-2 search-field">
            <form id="search-data" data-route="{{ route('search-data') }}" method="GET" action="/find/user" style="width: 80%">
            <div class="col-md-10 d-flex">
            <input id="parameter" type="parameter" class="form-control col-md-8 @error('parameter') is-invalid @enderror"
             name="parameter" value="{{ old('parameter') }}" required autocomplete="parameter"
             placeholder="Search for a business or service provider" autofocus>
             <button type="submit" name="search" class="search-btn ml-2"><i class="fas fa-search icon"></i></button>

            </div>
            </form>
                <div id="search-data-result">
                     <div id="search-data-business"> </div>
                    <div id="submit-data-button"></div>
                </div>
            </div>

        </div>

        @if(count($users) >= 1)
        <div class=" col-md-6 mb-5">
            <div id="rangeslider" class="rangeslider">
                <span class="slider-caption">Apply Search Radius : </span>
                <input type="range" min="0" max="5" value="0" class="slider" id="slider">
            </div>
            <div id="range-value" align="center"><span id="ranger"></span> km</div>
            <div class="float-md-right"><button class="btn btn-primary" id="radius">Apply</button></div>
        </div>


        <form method="GET" id="setradius" action="/search/result">
            <input type="hidden" name="state" value="{{ $state }}">
            <input type="hidden" name="service" value="{{ $specialize }}">
            <input type="hidden" name="radius" value="" id="radius-param">
            <input type="hidden" name="area" id="radiuslocation" value="">
        </form>
        <div class="col-md-8">

            @foreach($users as $user)
            <div class="card mb-4" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="row">
                        <img src="/storage/{{$user->profile->image}}" class="col-md-4 rounded-circle float-md-left">
                        <div class="search-result col-md-6">
                            <div class="name pt-2">{{ $user->businessname }}</div>
                            <div class="info pt-2"><em>{{ $user->businessinfo }}</em></div>
                            <div class="address pt-2"><i class="fas fa-map-marker-alt"></i> : {{ $user->businessaddress }}</div>
                            <div class="rating-star pt-2"><b>Rating</b> :
                            @if($user->profile->rating == 0)
                                    <i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i> Not Rated
                                @elseif($user->profile->rating == 0.5)
                                    <i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating > 0.5 && $user->profile->rating <= 1.4)
                                    <i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating == 1.5)
                                    <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating > 1.5 && $user->profile->rating <= 2.4)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating == 2.5)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating > 2.5 && $user->profile->rating <= 3.4)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating == 3.5)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating > 3.5 && $user->profile->rating <= 4.4)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                @elseif($user->profile->rating == 4.5)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                @elseif($user->profile->rating > 4.5 && $user->profile->rating <= 5)
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></i><i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>Not Rated @endif</div>

                            <div class="pt-3"><a href="/view/profile/{{$user->id}}" class="btn">Contact</a></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div align="center">Sorry, we couldn't find any results.</div>
            @endif



            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
</body>
