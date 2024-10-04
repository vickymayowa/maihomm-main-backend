@extends('dashboards.admin.layouts.app')
@section('content')
@section('style')
    <style>
        b,
        strong {
            font-weight: bolder;
            margin-left: 38px;
            text-decoration: underline;
        }
    </style>
@endsection
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h5 class="default-color">{{ isset($property) ? 'Update' : 'Create' }} Property</h5>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body p-3">
            @if (isset($property))
                <form action="{{ route('dashboard.admin.properties.update', $property->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf @method('PATCH')
                @else
                    <form action="{{ route('dashboard.admin.properties.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
            @endif
            <div class="mt-4">
                <b class="default-color">Basic Info</b>
            </div>
            <div class="row mt-2">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="">Property Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ isset($property) ? $property->name : old('name') }}">
                    </div>
                </div>

                {{-- <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">Category</label>
                        <select name="category_id" id="" class="form-control">
                            <option disabled selected>Select Options</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (isset($property)) {{ $category->id == $property->category_id ? 'selected' : '' }} @endif>
                                    {{ $category->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="">Currencies</label>
                        <select name="currency_id" id="" class="form-control">
                            <option disabled selected>Select Options</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                    @if (isset($property)) {{ $currency->id == $property->currency_id ? 'selected' : '' }} @endif>
                                    {{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="">Property Description/Overview</label>
                        <textarea rows="10" name="description" class="form-control">{{ isset($property) ? $property->description : old('description') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <b class="default-color">Files Upload</b>
            </div>
            <div class="row mt-2">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="">Property Images</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="">Property Video</label>
                        <input type="file" name="videos[]" class="form-control" multiple>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <b class="default-color">Costing</b>
            </div>
            <div class="row mt-2">
                <div class="col-md-3 form-group">
                    <label for="">Price</label>
                    <input type="number" class="form-control" placeholder="" name="price" required
                        value="{{ isset($property) ? $property->price : old('price') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">MaiHomm Fee</label>
                    <input type="text" class="form-control" placeholder="" name="maihomm_fee"
                        value="{{ isset($property) ? $property->maihomm_fee : old('maihomm_fee') }}" required>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Legal And Closing Cost</label>
                    <input type="text" class="form-control" placeholder="" name="legal_and_closing_cost"
                        value="{{ isset($property) ? $property->legal_and_closing_cost : old('legal_and_closing_cost') }}"
                        required>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Total Sold Slots</label>
                    <input type="text" class="form-control" placeholder="" name="total_sold"
                        value="{{ isset($property) ? $property->total_sold : old('total_sold') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Total Slots</label>
                    <input type="text" class="form-control" placeholder="" name="total_slots"
                        value="{{ isset($property) ? $property->total_slots : old('total_slots') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Property Price Per Slot</label>
                    <input type="text" class="form-control" placeholder="" name="per_slot"
                        value="{{ isset($property) ? $property->per_slot : old('per_slot') }}" required>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Per Acq Cost</label>
                    <input type="text" class="form-control" placeholder="" name="property_acq_cost"
                        value="{{ isset($property) ? $property->property_acq_cost : old('property_acq_cost') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Service Charge</label>
                    <input type="text" class="form-control" placeholder="" name="service_charge"
                        value="{{ isset($property) ? $property->service_charge : old('service_charge') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Management Fees</label>
                    <input type="text" class="form-control" placeholder="" name="management_fees"
                        value="{{ isset($property) ? $property->management_fees : old('management_fees') }}" required>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Projected Gross Rent</label>
                    <input type="number" class="form-control" placeholder="" name="projected_gross_rent"
                        value="{{ isset($property) ? $property->projected_gross_rent : old('projected_gross_rent') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">One Time Payment Per Slot</label>
                    <input type="number" class="form-control" placeholder="" name="one_time_payment_per_slot"
                        value="{{ isset($property) ? $property->one_time_payment_per_slot : old('one_time_payment_per_slot') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Rental Cost Per Night</label>
                    <input type="number" class="form-control" placeholder="" name="rental_cost_per_night"
                        value="{{ isset($property) ? $property->rental_cost_per_night : old('rental_cost_per_night') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Projected Annual Yield</label>
                    <input type="number" class="form-control" placeholder="" name="projected_annual_yield"
                        value="{{ isset($property) ? $property->projected_annual_yield : old('projected_annual_yield') }}">
                </div>
                <div class="col-md-9 form-group">
                    <label for="">Projected Annual Yield SubText</label>
                    <input type="text" class="form-control" placeholder="" name="projected_annual_yield_subtext"
                        value="{{ isset($property) ? $property->projected_annual_yield_subtext : old('projected_annual_yield_subtext') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Average Occupancy</label>
                    <input type="number" class="form-control" placeholder="" name="average_occupancy"
                        value="{{ isset($property) ? $property->average_occupancy : old('average_occupancy') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Projected Annual Net Rental Income</label>
                    <input type="number" class="form-control" placeholder=""
                        name="projected_annual_net_rental_income"
                        value="{{ isset($property) ? $property->projected_annual_net_rental_income : old('projected_annual_net_rental_income') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Projected Annual Rental Income Per Slot</label>
                    <input type="number" class="form-control" placeholder=""
                        name="projected_annual_rental_income_per_slot"
                        value="{{ isset($property) ? $property->projected_annual_rental_income_per_slot : old('projected_annual_rental_income_per_slot') }}">
                </div>
            </div>
            <div class="mt-4">
                <b class="default-color">Location</b>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">Country</label>
                        <select name="country_id" id="country" onchange="populateStates()" class="form-control">
                            <option disabled selected>Select Options</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    @if (isset($property)) {{ $country->id == $property->country_id ? 'selected' : '' }} @endif>
                                    {{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">State</label>
                        <select name="state_id" id="state" onchange="populateCity()" class="form-control">
                            <option disabled selected>Select Options</option>
                            @if (isset($property))
                                <option value="{{ $property->state_id }}"{{ $property->state_id ? 'selected' : '' }}>
                                    {{ optional($property->state)->name }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">City</label>
                        <select name="city_id" id="city" class="form-control">
                            <option disabled selected>Select Options</option>
                            @if (isset($property))
                                <option value="{{ $property->city_id }}"{{ $property->city_id ? 'selected' : '' }}>
                                    {{ optional($property->city)->name }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ isset($property) ? $property->address : old('address') }}">

                    </div>
                </div>

            </div>
            <div class="mt-4">
                <b class="default-color">Features</b>
            </div>
            <div class="row mt-2">
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label for="">Square Feet</label>
                        <input type="number" name="sqft" class="form-control"
                            value="{{ isset($property) ? $property->sqft : old('sqft') }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label for="">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control"
                            value="{{ isset($property) ? $property->bedrooms : old('bedrooms') }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label for="">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control"
                            value="{{ isset($property) ? $property->bathrooms : old('bathrooms') }}">
                    </div>
                </div>
                {{-- <div class="col-sm-3">
                    <div class="mb-3">
                        <label for="">Average Ratings</label>
                        <input type="number" name="avg_ratings" class="form-control"
                            value="{{ isset($property) ? $property->avg_ratings : old('avg_ratings') }}">
                    </div>
                </div> --}}
                {{-- <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="">Landmark</label>
                        <input type="text" name="landmark" class="form-control"
                            value="{{ isset($property) ? $property->landmark : old('landmark') }}">
                    </div>
                </div> --}}
            </div>
            <div class="mt-4">
                <b class="default-color">Projections</b>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">First Year</label>
                        <input type="text" name="first_year_projection" class="form-control"
                            value="{{ isset($property) ? $property->first_year_projection : old('first_year_projection') }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">Fifth Year</label>
                        <input type="text" name="fifth_year_projection" class="form-control"
                            value="{{ isset($property) ? $property->fifth_year_projection : old('fifth_year_projection') }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label for="">Tenth Year</label>
                        <input type="text" name="tenth_year_projection" class="form-control"
                            value="{{ isset($property) ? $property->tenth_year_projection : old('tenth_year_projection') }}">
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <b class="default-color">Other Info</b>
            </div>
            <div class="row mt-2">
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label for="">Closing Date</label>
                        <input type="date" name="closing_date" class="form-control"
                            value="{{ isset($property) ? $property->closing_date : old('closing_date') }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="status" id="country" class="form-control">
                            <option disabled selected>Select Options</option>
                            @foreach ($statusOptions as $key => $value)
                                <option value="{{ $key }}"
                                    @if (isset($property)) {{ $key == $property->status ? 'selected' : '' }} @endif>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-2">
            <button type="submit"
                class="btn btn-md default-btn">{{ isset($property) ? 'Update' : 'Create' }}</button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
    function populateStates() {
        var country = document.getElementById('country').value;
        var stateSelect = document.getElementById('state');
        var citySelect = document.getElementById('city');
        var stateValue = stateSelect.value;
        stateSelect.innerHTML = '';
        var defaultOption = document.createElement('option');
        defaultOption.text = 'Select State';
        defaultOption.value = "";

        stateSelect.add(defaultOption);
        $.get('/get-state/' + country, function(data) {
            $.each(data.states, function(index, state) {
                var stateOption = document.createElement('option');
                stateOption.text = state;
                stateOption.value = index;
                stateSelect.add(stateOption);
            });
        });
    }

    function populateCity() {
        var stateSelect = document.getElementById('state');
        var citySelect = document.getElementById('city');
        var stateValue = stateSelect.value;
        citySelect.innerHTML = '';
        defaultOption = document.createElement('option');
        defaultOption.text = 'Select City';
        defaultOption.value = "";

        citySelect.add(defaultOption);
        $.get('/get-city/' + stateValue, function(data) {
            $.each(data.cities, function(index, city) {
                var cityOption = document.createElement('option');
                cityOption.text = city;
                cityOption.value = index;
                citySelect.add(cityOption);
            });
        });
    }
</script>
@endsection
