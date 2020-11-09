@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center align-items-center">
    <div class="content col-md-12">
            <div class="profile-image col-md-12 pt-4">
                <img class="d-block mx-auto rounded-circle" src="/storage/{{ $user->profile->image }}">
        </div>
        <div class="content-text">
        <div class="pt-5"><h2>{{ $user->firstname }} {{ $user->lastname }}</h2></div>
			<div class="name pt-3"><h3><i class="fas fa-building"></i> : {{ $user->businessname }}</h3></div>
			<div class="motto pt-1"><p><i class="fab fa-pied-piper"></i> <em>{{ $user->businessmotto }}</em></p></div>
			<div class="address pt-1"> <p><i class="fas fa-map-marker-alt"></i> : <b>{{ $user->businessaddress }}</b></p></div>
            <div class="phone pt-3"><p><b>Profile views: </b><span>{{ $user->profile->views }}</span></p></div>
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
</div>

@can('update', $user->profile)
            @if(session('days_left') == 0)
            <div align="center" class="alert alert-danger" role="alert">
                        Your subscription has expired.Please switch to a paid subscription. Your services won't be shown when customers search for service
                        providers until your subscription is renewed.

                        <div align="center" style="width: 25%; margin-left: auto; margin-right: auto;">
                    <form method="POST" action="/pay" accept-charset="UTF-8">
                    @csrf
                    <input type="hidden" name="email" value="{{$user->email}}">
            <input type="hidden" name="userID" value="{{$user->id}}">
            <input type="hidden" name="amount" value="360000">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="currency" value="NGN">
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">

            <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>

                    </form>
              </div>
                        </div>

           @elseif(session('days_left') <= 7 && session('days_left') != 0)
           <div align="center" class="alert alert-danger" role="alert">
                        You have {{session('days_left')}} days left on your subscription.
                        </div>

              <div align="center" style="width: 25%; margin-left: auto; margin-right: auto;">
                    <form method="POST" action="/pay" accept-charset="UTF-8">
                    @csrf
                    <input type="hidden" name="email" value="{{$user->email}}">
            <input type="hidden" name="userID" value="{{$user->id}}">
            <input type="hidden" name="amount" value="360000">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="currency" value="NGN">
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">

            <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>

                    </form>
              </div>


            @else
            <div align="center" class="alert alert-success" role="alert">
                        You have {{session('days_left')}} days left on your subscription.
                        </div>

                <div align="center" style="width: 25%; margin-left: auto; margin-right: auto;">
                    <form method="POST" action="/pay" accept-charset="UTF-8">
                        @csrf
                        <input type="hidden" name="email" value="{{$user->email}}">
                        <input type="hidden" name="userID" value="{{$user->id}}">
                        <input type="hidden" name="amount" value="360000">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="currency" value="NGN">
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">

                        <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
                            <i class="fa fa-plus-circle fa-lg"></i> Renew Subscription
                        </button>

                    </form>
                </div>



            @endif

            <div align="center" class="referral">
              <p>Refer 12 people and get a free 6 month subscription!</p>
              <a href="/request/referral-link/{{ $user->hussla_id }}">Request Referral Link</a>
            </div>
            @if(session('requested_referral') == true)
            <div align="center" class="alert alert-success" role="alert">
                     Your referral link is <span id="referlink">http://127.0.0.1:8000/refer/token/{{$user->referral->referral_id}}
                     </span>

                    <div class="tip pt-3">
                      <button id="clickr" onclick="CopyToClipboard('referlink')">
                        <span class="tiptext" id="tiptext">Copy link to clipboard</span>
                        Copy Link
                      </button>
                    </div>
            </div>
            @endif

            <div class="pt-5 view-all-comments"><a href="/view/comments/{{$user->id}}">Check out your reviews</a></div>
            <div class="pt-5 pb-5 edit"><a href="/profile/{{$user->id}}/edit">Edit Your Profile</a></div>
@endcan
    </div>
</div>
</div>

@endsection
<script>

function CopyToClipboard(containerid) {
  if (document.selection) {
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy");
    var tooltip = document.getElementById("tiptext");
    tooltip.innerHTML = "Copied!";

  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(containerid));
    window.getSelection().addRange(range);
    document.execCommand("copy");
    var tooltip = document.getElementById("tiptext");
    tooltip.innerHTML = "Copied!";
  }
}
function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}


</script>

