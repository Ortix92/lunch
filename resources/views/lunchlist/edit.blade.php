@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            @include('lunchlist.partials.form')

            @if (count($lunchlist->names) > 0)
                @include('lunchlist.partials.names')
            @endif
        </div>
    </div>
@endsection
