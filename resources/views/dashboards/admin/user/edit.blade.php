@extends('dashboards.admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h5 class="default-color">Edit {{ $user->names() }}'s Details</h5>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('dashboard.admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method("PATCH")
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $user->first_name }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Middle Name</label>
                                <input type="text" name="middle_name" placeholder="Enter middle name..."
                                    class="form-control" value="{{ $user->middle_name }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Phone Number</label>
                                <input type="text" name="phone_no" class="form-control" value="{{ $user->phone_no }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Avatar</label>
                                <input type="file" name="avatar_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Gender</label>
                                <select name="gender" id="" class="form-control">
                                    <option disabled selected>Select Options</option>
                                    @foreach ($genders as $key => $value)
                                        <option value="{{ $key }}"{{ $key == $user->gender ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Maiden Name</label>
                                <input type="text" name="maiden_name" class="form-control"
                                    value="{{ $user->maiden_name }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Home Address</label>
                                <input type="text" name="home_address" class="form-control"
                                    value="{{ $user->home_address }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Date Of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control"
                                    value="{{ $user->date_of_birth }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Country</label>
                                <select name="country_id" id="country" onchange="populateStates()" class="form-control">
                                    <option disabled selected>Select Options</option>
                                    @foreach ($countries as $country)
                                        <option
                                            value="{{ $country->id }}"{{ $country->id == $user->country_id ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">State</label>
                                <select name="state_id" id="state" onchange="populateCity()" class="form-control">
                                    <option disabled selected>Select Options</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">City</label>
                                <select name="city_id" id="city" class="form-control">
                                    <option disabled selected>Select Options</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option disabled selected>Select Options</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}"{{ $key == $user->status ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-md default-btn">Update</button>
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
