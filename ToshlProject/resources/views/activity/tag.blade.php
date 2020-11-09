@extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-5" align="center">
                <div class="category col-md-12">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>TYPE</th>
                            <th>CATEGORY</th>
                        </tr>

                        @for($i = 0; $i < count($tags); $i++)
                        <tr>
                                <td>{{ $tags[$i]['id'] }}</td>
                                <td>{{ $tags[$i]['name'] }}</td>
                                <td>{{ $tags[$i]['type'] }}</td>
                                <td>{{ $tags[$i]['category'] }}</td>
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>

        @endsection
