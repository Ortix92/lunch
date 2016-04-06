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
@include('lunchlist.partials.close')