@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <!-- Display Validation Errors -->
            @include('common.errors')
            <div class="panel panel-default">
                <div class="panel-heading">Panel heading</div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Opened On</th>
                        <th>Closed On</th>
                        <th>Amount</th>
                        <th>Veggy</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $list)
                        <tr>
                            <th scope="row">{{$list->id}}</th>
                            <td>{{($list->opened_on)}}</td>
                            <td>{{$list->closed_on}}</td>
                            {{--                            <td>{{count($list->names)}}</td>--}}
                            <td>
                                @if($list->veggy)
                                    Yes
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
