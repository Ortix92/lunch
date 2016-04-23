@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            @if($lunchlist->closed)
                <div class="secret_button alert alert-danger alert-dismissible fade in">
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
            <form action="{{route('lunchlist.destroy', $lunchlist->id)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" id="delete_button" class="hidden btn btn-danger btn-block btn-lg">
                    <i class="fa fa-btn fa-trash"></i>DELETE LIST
                </button>
            </form>
        </div>
    </div>
@endsection
