<form action="{{route('name.destroy',[$name->id, 'list_id'=>$lunchlist->id,'persist'=>$persist])}}"
      method="POST" id="name-delete">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    @if(!$lunchlist->closed)
        <button type="submit" class="btn btn-danger btn-xs" title="Unsubscribe forever">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    @endif
</form>