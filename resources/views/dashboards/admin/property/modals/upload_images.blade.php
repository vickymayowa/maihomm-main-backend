<!-- Modal -->
<div class="modal fade" id="upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{route("dashboard.admin.properties.upload-files", $property->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="">Images</label>
                            <input type="file" class="form-control" name="images[]">
                        </div>
                        <div class="mb-3">
                            <label for="">Videos</label>
                            <input type="file" class="form-control" name="videos[]">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm default-btn">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
