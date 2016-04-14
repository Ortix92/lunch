@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            @if($lunchlist->closed)
                <div class="alert alert-danger alert-dismissible fade in">
                    This lunchlist has been closed.
                </div>
            @else
                @include('lunchlist.partials.form')
            @endif
            @if (count($lunchlist->names) > 0)
                @include('lunchlist.partials.names')
                @if(!$lunchlist->closed)
                    @include('lunchlist.partials.close')
                @endif
            @endif
        </div>
    </div>
@endsection
