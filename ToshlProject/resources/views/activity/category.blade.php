@extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-5" align="center">
                <div class="category col-md-12">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>ENTRIES</th>
                            <th>TAGS</th>
                        </tr>

                        @for($i = 0; $i < count($category); $i++)
                        <tr>
                                <td>{{ $category[$i]['id'] }}</td>
                                <td>{{ $category[$i]['name'] }}</td>
                                <td>{{ $category[$i]['counts']['entries'] }}</td>
                                <td>{{ $category[$i]['counts']['tags'] }}</td>
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>

        @endsection
