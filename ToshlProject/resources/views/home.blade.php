@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/apicall.js') }}"></script>


@section('content')
<div class="container compose">
    <div class="row">
        @if(session("id"))
                <div class="alert alert-success col-md-12 mt-5 text-center">
                    <p style="font-size: 18px;">Your expense entry with ID {{ session("id") }} has been created</p>
                </div>
            @endif
        <div class="col-md-12 mt-3" align="center">
            <div class="cover">
                <h2>Check Toshl Categories</h2>
                <a href="/category" class="btn btn-primary w-25">Check</a>
            </div>

            <div class="cover">
                <h2>Check tags</h2>
                <a href="/tag" class="btn btn-primary w-25">Check tags</a>
            </div>

            <div class="cover">
                <h2>Check account names</h2>
                <a href="/account" class="btn btn-primary w-25">Check</a>
            </div>

            <div class="covered">
                <h2>Create expense entry</h2>
                <a href="/create/entry" class="btn btn-primary w-25">Create</a>
            </div>


        </div>
    </div>
</div>
@endsection
