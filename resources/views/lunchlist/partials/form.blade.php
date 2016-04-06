<div class="panel panel-default">
    <div class="panel-heading">
        Add me to the list
    </div>

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

                <!-- New Task Form -->

        <form action="{{route('lunchlist.store')}}" method="POST" class="form-horizontal">
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