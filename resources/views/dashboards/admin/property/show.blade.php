@extends('dashboards.admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h5 class="default-color">View {{ $property->name }}</h5>
                </div>
            </div>
        </div>
        <div class="separator mb-5"></div>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="justify-content-between align-items-center d-flex">
                            <h6>Images/Videos</h6>
                            <button data-target="#upload" data-toggle="modal" class="btn btn-sm default-btn">Upload</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($property->files as $file)
                                    <div class="col-md-3 col-6 mb-2">
                                        <a href="javascript:;" data-toggle="modal" data-target="#view_{{ $file->id }}">
                                            @if ($file->type == 'image')
                                                <img src="{{ $file->file->url() }}" class="img-fluid property-image"
                                                    alt="">
                                            @else
                                                <video src="{{ $file->file->url() }}" class="img-fluid property-image"
                                                    alt="">
                                            @endif
                                        </a>
                                    </div>
                                    @include('dashboards.admin.property.modals.view_single_file')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card mb-3">
                    <div class="card-body">
                        <div class="justify-content-between align-items-center d-flex">
                            <h6>Videos</h6>
                            <button data-target="#uploadVideo" data-toggle="modal" class="btn btn-sm default-btn">Upload</button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                @foreach ($property->files as $video)
                                    <div>
                                        @dd($video->type("video"))
                                        <iframe class="embed-responsive-item" src="{{$video->video}}" allowfullscreen></iframe>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> --}}
                @foreach ($specGroups as $spec_key => $spec_value)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="justify-content-between align-items-center d-flex">
                                <h6>{{ $spec_value }}</h6>
                                <button data-target="#addSpec_{{ $spec_key }}" data-toggle="modal"
                                    class="btn btn-sm default-btn">Add</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sn</th>
                                                <th>Title</th>
                                                <th>Value</th>
                                                {{-- <th>Price</th> --}}
                                                <th>Icon</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sn = 1;
                                            @endphp
                                            @foreach ($property->specifications->where('group', $spec_key)->all() as $spec)
                                                <tr>
                                                    <td>{{ $sn++ }}</td>
                                                    <td>{{ $spec->title }}</td>
                                                    <td>{{ $spec->value }}</td>
                                                    {{-- <td>{{ $spec->price }}</td> --}}
                                                    <td>{{ $spec->getIcon() ?? 'N/A' }}</td>
                                                    <td>{{ $spec->status }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <form
                                                                action="{{ route('dashboard.admin.property-specs.destroy', [$property->id, $spec->id]) }}"
                                                                method="post">
                                                                @csrf @method('delete')
                                                                <a class="btn btn-success btn-sm mb-2" data-toggle="modal"
                                                                    data-target="#editSpec_{{ $spec->id }}">
                                                                    <i class="fa fa-pencil text-white"></i>
                                                                </a>
                                                                <button type="submit" class="btn btn-danger btn-sm mb-2"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('dashboards.admin.property.modals.edit_spec')
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('dashboards.admin.property.modals.add_spec', ['group' => $spec_key])
                @endforeach
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <b>More Details</b>
                        <a class="btn btn-success btn-sm mb-2"
                            href="{{ route('dashboard.admin.properties.edit', $property->id) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mt-2">
                            <div class="mt-4">
                                <b class="default-color">Property</b>
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>Property Name</b> : {{ $property->name }}
                            </div>
                            <div class="mb-2">
                                <b>Description/Overview</b> : {{ $property->description }}
                            </div>
                            {{-- <div class="mb-2">
                                <b>Category</b> : {{ optional($property->category)->name }}
                            </div> --}}
                            <div class="mb-2">
                                <b>UUID</b> : {{ $property->uuid }}
                            </div>
                            <div class="mb-2">
                                <b>Currency</b> : {{ optional($property->currency)->name }}
                            </div>
                            <div class="mb-2">
                                <b>Created By</b> : {{ optional($property->owner)->names() }}
                            </div>
                            <div class="mb-2">
                                <b>Closing Date</b> : {{ $property->closing_date }}
                            </div>
                            <div class="mt-4">
                                <b class="default-color">Costings</b>
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>Price</b> : {{ format_money($property->price, 2, $property->currency->short_name) }}
                            </div>
                            <div class="mb-2">
                                <b>MaiHomm Fee</b> : {{ $property->maihomm_fee }}
                            </div>
                            <div class="mb-2">
                                <b>Legal And Closing Cost</b> : {{ $property->legal_and_closing_cost }}
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>Property Price Per Slot</b> : {{ $property->per_slot }}
                            </div>
                            <div class="mb-2">
                                <b>Total Slots</b> : {{ $property->total_slots }}
                            </div>
                            <div class="mb-2">
                                <b>Total Sold</b> : {{ $property->total_sold }}
                            </div>
                            <div class="mb-2">
                                <b>Available Slots</b> : {{ $property->total_slots - $property->total_slod }}
                            </div>
                            <div class="mb-2">
                                <b>Per Acq Slot</b> : {{ $property->property_acq_cost }}
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>Service Charge</b> : {{ $property->service_charge }}
                            </div>
                            <div class="mb-2">
                                <b>Management Fees</b> : {{ $property->management_fees }}
                            </div>
                            <div class="mb-2">
                                <b>Projected Gross Rent</b> : {{ $property->projected_gross_rent }}
                            </div>
                            <div class="mb-2">
                                <b>One Time Payment Per Slot</b> : {{ $property->one_time_payment_per_slot }}
                            </div>
                            <div class="mb-2">
                                <b>Rental Cost Per Night</b> : {{ $property->rental_cost_per_night }}
                            </div>
                            <div class="mb-2">
                                <b>Projected Annual Yield</b> : {{ $property->projected_annual_yield }}
                            </div>
                            <div class="mb-2">
                                <b>Projected Annual Yield SubText</b> : {{ $property->projected_annual_yield_subtext }}
                            </div>
                            <div class="mb-2">
                                <b>Average Occupancy</b> : {{ $property->average_occupancy }}
                            </div>
                            <div class="mb-2">
                                <b>Projected Annual Net Rental Income</b> :
                                {{ $property->projected_annual_net_rental_income }}
                            </div>
                            <div class="mb-2">
                                <b>Projected Annual Rental Income Per Slot</b> :
                                {{ $property->projected_annual_rental_income_per_slot }}
                            </div>
                            <div class="mt-4">
                                <b class="default-color">Impressions</b>
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>Total Views</b> : {{ $property->total_views ?? 'N/A' }}
                            </div>

                            <div class="mb-2">
                                <b>Total Reviews</b> : {{ $property->total_reviews ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Total Clicks</b> : {{ $property->total_clicks ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Total Sold</b> : {{ $property->total_sold ?? 'N/A' }}
                            </div>
                            {{-- <div class="mb-2">
                                <b>Avg Rating</b> : {{ $property->avg_rating ?? 'N/A' }}
                            </div> --}}
                            <div class="mt-4">
                                <b class="default-color">Location</b>
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>Country</b> : {{ optional($property->country)->name }}
                            </div>
                            <div class="mb-2">
                                <b>State</b> : {{ optional($property->state)->name }}
                            </div>
                            <div class="mb-2">
                                <b>City</b> : {{ optional($property->city)->name }}
                            </div>
                            <div class="mb-2">
                                <b>Address</b> : {{ $property->address ?? 'N/A' }}
                            </div>
                            <div class="mt-4">
                                <b class="default-color">Features</b>
                            </div>
                            <hr>
                            <div class="mb-2 mb-3">
                                <b>Square Feet</b> : {{ $property->sqft ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Bedrooms</b> : {{ $property->bedrooms ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Bathrooms</b> : {{ $property->bathrooms ?? 'N/A' }}
                            </div>
                            {{-- <div class="mb-2">
                                <b>Landmark</b> : {{ $property->landmark ?? 'N/A' }}
                            </div> --}}
                            <div class="mt-4">
                                <b class="default-color">Projections</b>
                            </div>
                            <hr>
                            <div class="mb-2">
                                <b>First Year</b> : {{ $property->first_year_projection ?? 'N/A' }}%
                            </div>
                            <div class="mb-2">
                                <b>Fifth Year</b> : {{ $property->fifth_year_projection ?? 'N/A' }}%
                            </div>
                            <div class="mb-2">
                                <b>Tenth Year</b> : {{ $property->tenth_year_projection ?? 'N/A' }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('dashboards.admin.property.modals.upload_images')
        @include('dashboards.admin.property.modals.upload_video')
    </div>
@endsection
