@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="favorites col-md-12 mt-5">
                <h3>Your favorite service providers</h3>
                <table class="w-100">
                    <caption>Click on their phone numbers to contact them.</caption>

                    <tr>
                        <th>Provider</th>
                        <th>Specialization</th>
                        <th>Area located</th>
                        <th>Phone</th>
                    </tr>

                        @foreach($customer->favorite as $favorite)
                        <tr>
                            <td>{{ $favorite->user }}
                            <form method="POST" action="{{ route('delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" value="{{ $favorite->id }}" name="id">
                                <input type="hidden" value="{{ $favorite->customer_id }}" name="customer_id">
                                <button type="submit" class="delete-button">Remove</button>
                            </form>
                            </td>
                            <td>{{ $favorite->specialization }}</td>
                            <td>{{ $favorite->area }}</td>
                            <td><a href="tel: +{{ $favorite->number }}">+{{ $favorite->number }}</a></td>
                        </tr>
                        @endforeach

                </table>

            </div>
        </div>
    </div>

@endsection
