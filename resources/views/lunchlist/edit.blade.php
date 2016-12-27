@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
{{--            {{dd(session()->all())}}--}}
            @if(session()->has('status'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    {!! session('status') !!}
                </div>
            @endif
            @if($lunchlist->dinner)
                <div class="alert alert-warning" role="alert">
                    <strong>Attention!</strong> This is a dinner list!
                </div>
            @endif
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
