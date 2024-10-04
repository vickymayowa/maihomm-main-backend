<!-- Modal -->
<div class="modal fade" id="upload_properties" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Properties</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Select a CSV or Excel file containing the properties you want to upload in the right format.</p>
                <form id="kycForm" action="{{ route("dashboard.admin.upload-property") }}" method="POST" class="form pb-3" enctype="multipart/form-data">@csrf
                    <div class="form-group mb-4">
                        <input type="file" class="form-control" name="property_file">
                    </div>

                    <button type="submit" class="btn btn-outline-primary btn-lg btn-block rounded">Upload</button>
                </form>

            </div>
        </div>
    </div>
</div>
