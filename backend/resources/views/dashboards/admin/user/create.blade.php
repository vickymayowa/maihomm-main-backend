@extends('dashboards.admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h5 class="default-color">Create User</h5>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('dashboard.admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Middle Name</label>
                                <input type="text" name="middle_name" placeholder="Enter middle name..."
                                    class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Phone Number</label>
                                <input type="text" name="phone_no" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="">Gender</label>
                                <select name="gender" id="" class="form-control">
                                    <option disabled selected>Select Options</option>
                                    @foreach ($genders as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-md default-btn">Create</button>
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
