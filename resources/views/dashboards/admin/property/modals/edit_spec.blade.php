<!-- Modal -->
<div class="modal fade" id="editSpec_{{ $spec->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Specifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.admin.property-specs.update', [$property->id, $spec->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <input type="hidden" name="property_id" id="" value="{{ $spec->property_id }}">
                    <input name="group" class="form-control" type="hidden" value="{{ $spec->group }}" required>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $spec->title }}">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="">Key</label>
                            <input type="text" class="form-control" name="key" value="{{ $spec->key }}">
                        </div> --}}
                        <div class="mb-3">
                            <label for="">Value</label>
                            <input type="text" class="form-control" name="value" value="{{ $spec->value }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Price</label>
                            <input type="text" class="form-control" name="price" value="{{ $spec->price }}">
                        </div>
                        <div class="mb-3">
                            <label for="">Icon</label>
                            <select name="icon" class="form-control" id="">
                                <option disabled selected>Select Option</option>
                                @foreach ($iconGroups as $icon_name => $icon_key)
                                    @php
                                        $decoded = json_decode($spec->metadata);
                                    @endphp
                                    <option value="{{ $icon_key }}"
                                        {{ (isset($spec) ? $decoded->icon : old('icon')) == $icon_key ? 'selected' : '' }}>
                                        {{ $icon_name }}</option>
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
