<!-- Button trigger modal -->
<button type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#verification">
    <span class="glyphicon glyphicon-lock"></span> Close Lunch List
</button>

<!-- Modal -->
<div class="modal fade" id="verification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Close Lunch List</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade in">
                    You are about to close the lunch list which will lock it for any further admissions. Are you sure?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Lock that sucker</button>
            </div>
        </div>
    </div>
</div>