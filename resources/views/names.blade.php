@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add me to the list
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                            <!-- New Task Form -->
                    <form action="/name" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                                <!-- Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control"
                                       value="{{ old('name') }}">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="persist-box">Stay in the list</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="persist-box" name="persist">
                            </div>
                        </div>
                        <!-- Add Name Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Sign up
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Names -->
            @if (count($names) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Names
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                            <th>Name</th>
                            <th>Signed up at</th>
                            <th>&nbsp;</th>
                            </thead>
                            <tbody>
                            @foreach ($names as $name)
                                <tr>
                                    <td class="table-text">
                                        <div>{{ $name->name }}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{$name->created_at->toTimeString()}}</div>
                                    </td>

                                    <!-- Task Delete Button -->
                                    <td>
                                        <form action="/name/{{ $name->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('partials.close')
            @endif
        </div>
    </div>
@endsection
