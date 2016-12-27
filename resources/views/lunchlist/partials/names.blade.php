<div class="panel panel-default">
    <div class="panel-heading">
        Full-time Names
    </div>

    <div class="panel-body">
        <table class="table table-striped task-table">
            <thead>
            <th class="col-xs-2">Name</th>
            <th class="col-xs-1">Veggy</th>
            <th class="visible-lg visible-md col-xs-2">Signed up at</th>
            <th class="col-xs-5s">Note</th>
            <th class="col-xs-2">&nbsp;</th>
            </thead>
            <tbody>

            @foreach ($lunchlist->names as $name)
                @if($name->persist)
                    <tr>
                        <td class="table-text">
                            <div>{{ $name->name }}</div>
                        </td>
                        <td class="table-text">
                            @if($name->veggy)
                                <i class="fa fa-check"></i>
                            @endif
                        </td>
                        <td class="table-text visible-lg visible-md">
                            <div>{{$name->updated_at->toTimeString()}}</div>
                        </td>
                        <td class="table-text">
                            <div>{{$name->pivot->note}}</div>
                        </td>

                        <!-- Task Delete Button -->
                        <td>
                            @include('lunchlist.partials.removename')
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Part-time Names
    </div>

    <div class="panel-body">
        <table class="table table-striped task-table">
            <thead>
            <th class="col-xs-2">Name</th>
            <th class="col-xs-1">Veggy</th>
            <th class="visible-lg visible-md col-xs-2">Signed up at</th>
            <th class="col-xs-5s">Note</th>
            <th class="col-xs-2">&nbsp;</th>
            </thead>
            <tbody>

            @foreach ($lunchlist->names as $name)
                @if(!$name->persist)
                    <tr>
                        <td class="table-text">
                            <div>{{ $name->name }}</div>
                        </td>
                        <td class="table-text">
                            @if($name->veggy)
                                <i class="fa fa-check"></i>
                            @endif
                        </td>
                        <td class="table-text visible-lg visible-md">
                            <div>{{$name->updated_at->toTimeString()}}</div>
                        </td>
                        <td class="table-text">
                            <div>{{$name->pivot->note}}</div>
                        </td>

                        <!-- Task Delete Button -->
                        <td>
                            @include('lunchlist.partials.unpersist',['persist' => '0'])
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>