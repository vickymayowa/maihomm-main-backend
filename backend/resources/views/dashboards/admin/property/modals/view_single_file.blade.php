<!-- Modal -->
<div class="modal fade" id="view_{{ $file->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View {{ ucfirst($file->type) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    @if ($file->type == 'image')
                        <img src="{{ $file->file->url() }}" class="img-fluid property-image" alt="">
                    @else
                        <video src="{{ $file->file->url() }}" controls class="img-fluid property-image" alt="">
                    @endif
                </div>
                <div class="text-center mt-2">
                    <form action="{{ route('dashboard.admin.properties.change-single-file', $file->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @method('PATCH') @csrf
                        <div class="mb-3">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="mb-3">
                            <input type="number" placeholder="specify image/video order e.g 1,2,3 " name="order"
                                value="{{ $file->order }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-md btn-success mb-3">Update</button>
                    </form>
                    <form action="{{ route('dashboard.admin.properties.delete-single-file', $file->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf @method('DELETE')
                        <button
                            onclick="if (confirm('Are you sure?')){return true;}else{event.stopPropagation(); event.preventDefault();}"
                            class="btn btn-danger btn-md">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
