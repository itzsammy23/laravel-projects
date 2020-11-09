@component('mail::message')
    <b>Free 6 month subscription!</b><br><br>
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot
Hello there {{$user->firstname}},

You have referred 12 people and have therefore
recieved a free six month subscription.

@component('mail::button', ['url' => 'http:127.0.0.1:8000/login', 'color' => 'success'])
Check Out Your Profile
@endcomponent

Cheers,<br>
{{ config('app.name') }}
@endcomponent
