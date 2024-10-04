@if (!empty($items) && $items->total() > 0)
<div class="d-flex justify-content-center">
    {!! $items->links("pagination::simple-bootstrap-4") !!}
</div>
<div class="text-center mb-4">
    Showing {{$items->firstItem() }} to {{$items->lastItem()}} of {{$items->total()}}
</div>
@endif
                