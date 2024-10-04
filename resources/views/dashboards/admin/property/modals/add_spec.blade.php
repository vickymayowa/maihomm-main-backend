<!-- Modal -->
<div class="modal fade" id="addSpec_{{ $group }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Specifications</h4>
                <button type="button" class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.admin.property-specs.store', $property->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="property_id" id="" value="{{ $property->id }}">
                    <input name="group" class="form-control" type="hidden" value="{{ $group }}" required>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="">Key</label>
                            <input type="text" class="form-control" name="key" value="{{ old('key') }}">
                        </div> --}}
                        <div class="mb-3">
                            <label for="">Value</label>
                            <input type="text" class="form-control" name="value" value="{{ old('value') }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Price</label>
                            <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Icon</label>
                            <select name="icon" class="form-control" id="">
                                <option disabled selected>Select Option</option>
                                @foreach ($iconGroups as $icon_name => $icon_key)
                                    <option value="{{ $icon_key }}"
                                        {{ $icon_key == old('icon') ? 'selected' : '' }}>{{ $icon_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm default-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
