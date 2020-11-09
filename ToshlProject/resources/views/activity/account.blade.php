@extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-5" align="center">
                <div class="category col-md-8">
                    <h2>Account Names List</h2>
                    @for($i = 0; $i < count($accounts); $i++)
                        <p>{{ $accounts[$i]['name'] }}</p>
                    @endfor
                </div>
            </div>
        </div>

        @endsection
