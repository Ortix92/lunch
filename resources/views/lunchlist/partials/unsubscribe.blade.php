<form action="{{route('name.destroy',[$name->id, 'list_id'=>$lunchlist->id,'persist'=>$persist])}}"
      method="POST" id="name-delete">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    @if(!$lunchlist->closed)
        <button type="submit" class="btn btn-warning btn-xs" title="Unsubscribe once">
            <i class="fa fa-minus" aria-hidden="true"></i>
        </button>
    @endif
</form>