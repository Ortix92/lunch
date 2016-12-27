<div class="row">
    <div class="col-xs-2">
        {{--Unly removes user form the lunch list once--}}
        @include('lunchlist.partials.unsubscribe',['persist' => '1'])
    </div>
    <div class="col-xs-2">
        {{--Removes persistence of user for the rest of the lunches--}}
        @include('lunchlist.partials.unpersist',['persist' => '0'])
    </div>
</div>