@extends('web.pages.properties.layout')
@section('style')
    <link rel="stylesheet" href="{{ $web_assets }}/css/leaflet.css" />
    <style>
        #map {
            height: 100%;
        }
    </style>
@endsection
@section('content')
    <main id="content" class="my-7">
        <section>
            <div class="container-fluid">
                <div class="position-relative" data-animate="zoomIn">
                    <div class="position-absolute pos-fixed-top-right z-index-3">
                    </div>
                    <div class="row galleries m-n1">
                        <div class="col-lg-6 p-1">
                            <div class="item item-size-4-3">
                                <div class="card p-0 hover-zoom-in">
                                    <a href="{{ $property->getDefaultImage() }}" class="card-img" data-gtf-mfp="true"
                                        data-gallery-id="01"
                                        style="background-image:url('{{ $property->getDefaultImage() }}')">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 p-1">
                            <div class="row m-n1">
                                @foreach ($image_files as $key => $property_file)
                                    @if (in_array($property_file->id, $display_image_data['property_files_id']))
                                        <div class="col-md-6 p-1">
                                            <div class="item item-size-4-3">
                                                <div class="card p-0 hover-zoom-in">
                                                    <a href="{{ $property_file->file->url() }}" class="card-img"
                                                        data-gtf-mfp="true" data-gallery-id="01"
                                                        style="background-image:url('{{ $property_file->file->url() }}')">
                                                    </a>
                                                    @if ($key + 1 == count($display_image_data['property_files_id']))
                                                        <a href="#"
                                                            class="card-img-overlay d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                                                            <p class="fs-48 font-weight-600 text-white lh-1 mb-4">
                                                                +{{ $display_image_data['remaining_images'] }}</p>
                                                            <p
                                                                class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">
                                                                View
                                                                more</p>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="primary-content pt-8">
            <div class="container">

                <div class="row">
                    <article class="col-lg-8 pr-xl-7">
                        <section class="pb-7 border-bottom">
                            <ul class="list-inline d-sm-flex align-items-sm-center mb-2">
                                <li class="list-inline-item badge badge-orange mr-2">Featured</li>
                                <li class="list-inline-item badge badge-primary mr-3">{{ $property->status }}</li>
                                <li class="list-inline-item mr-2 mt-2 mt-sm-0"><i
                                        class="fal fa-clock mr-1"></i>{{ $property->created_at->diffForHumans() }}
                                </li>
                                {{-- <li class="list-inline-item mt-2 mt-sm-0"><i class="fal fa-eye mr-1"></i>{{ $property->total_views }} views</li> --}}
                            </ul>
                            <div class="d-sm-flex justify-content-sm-between">
                                <div>
                                    <h2 class="fs-35 font-weight-600 lh-15 text-heading">{{ $property->name }}</h2>
                                    <p class="mb-0"><i class="fal fa-map-marker-alt mr-2"></i>{{ $property->address }}</p>
                                </div>
                                <div class="mt-2 text-lg-right">
                                    <p class="fs-22 text-heading font-weight-bold mb-0">
                                        {{ format_money($property->per_slot, 2, $property->currency->short_name) }}</p>
                                    {{-- <p class="mb-0">$9350/SqFt</p> --}}
                                </div>
                            </div>

                        </section>
                        <section class="pb-7 border-bottom">
                            <div class="d-flex mt-8">
                                <div>
                                    <img src="{{ $property->getFlagUrl() }}" alt="">
                                </div>

                                <div class="pl-1">
                                    <h6 class=" px-3 font-weight-600">{{ $property->address }}</h6>
                                    <p class="px-3" style="margin-top: -7px;">A mature real estate market with favourable
                                        returns.</p>
                                </div>
                            </div>



                            <div class="d-flex my-4">
                                <div>
                                    <img src="https://maihomm.com/wp-content/uploads/2023/01/Asset-31.png" class="img-fluid"
                                        style="width: 37px;" alt="">
                                </div>

                                <div>
                                    <h6 class="px-3 font-weight-600">Average occupancy {{ $property->average_occupancy }}%
                                    </h6>
                                    <p class="px-3" style="margin-top: -7px;">A mature real estate market with favourable
                                        returns.</p>
                                </div>
                            </div>
                            <div class="d-flex my-4">
                                <div>
                                    <img src="https://maihomm.com/wp-content/uploads/2023/01/Asset-28.png" class="img-fluid"
                                        style="width: 37px;" alt="">
                                </div>

                                <div>
                                    <h6 class="px-3 font-weight-600">Projected annual yield
                                        {{ $property->projected_annual_yield }}%</h6>
                                    <p class="px-3" style="margin-top: -7px;">
                                        {{ $property->projected_annual_yield_subtext }}</p>
                                </div>
                            </div>

                        </section>
                        <section class="pb-7 border-bottom">
                            <h4 class="fs-22 text-heading mt-6 mb-2">Property Overview</h4>
                            <p class="mb-0 lh-214">{{ $property->description }}</p>
                        </section>
                        <section class="pb-7 border-bottom pt-3">
                            {{-- <h4 class="fs-22 text-heading lh-15 mb-5 ">Projected Returns</h4> --}}
                            <div class="card border-0 mb-4 mt-4">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-sm-6 mb-6 mb-sm-0">
                                            <div>
                                                <div class="">
                                                    <h4 class="fs-22 text-heading mb-7">Financial Details</h4>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Property Price Per Slot</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 font-weight-bold">
                                                            {{ format_money($property->per_slot, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Maihomm fee</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 font-weight-bold">
                                                            {{ format_money($property->maihomm_fee, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Legal and closing cost</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 font-weight-bold">
                                                            {{ format_money($property->legal_and_closing_cost, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr style="margin-top: -3px;">

                                                <div class="d-flex justify-content-between mb-0">
                                                    <div>
                                                        <p>Property Acq cost</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 text-primary font-weight-bold">
                                                            {{ format_money($property->property_acq_cost, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Per Slot</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 text-primary font-weight-bold">
                                                            {{ format_money($property->per_slot, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div> --}}

                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-6 mb-sm-0">
                                            <div>
                                                <div class="">
                                                    <h4 class="fs-22 mb-7 text-primary">Projected Returns</h4>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Projected Gross Rent</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 font-weight-bold">
                                                            {{ format_money($property->projected_gross_rent, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Management fees</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 font-weight-bold">
                                                            {{ format_money($property->management_fees, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Service charge</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 font-weight-bold">
                                                            {{ format_money($property->service_charge, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <hr style="margin-top: -3px;">

                                                <div class="d-flex justify-content-between mb-0">
                                                    <div>
                                                        <p>Projected Net Rent</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 text-primary font-weight-bold">
                                                            {{ format_money($property->projected_annual_net_rental_income, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p>Per Slot</p>
                                                    </div>

                                                    <div class="font-weight-bold">
                                                        <p class="fs-17 text-primary font-weight-bold">
                                                            {{ format_money($property->projected_annual_rental_income_per_slot, 2, $property->currency->short_name) }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- <section class="pb-7 border-bottom">
                            <h4 class="fs-20 text-heading lh-15 mb-5 pt-3 mt-4 px-0">Funding Timeline</h4>
                            <div class="px-1 pl-4">
                                <ul class="timeline-with-icons">
                                    @forelse ($timelines as $timeline)
                                        @php
                                            $decoded = json_decode($timeline->metadata);
                                            $date = carbon()
                                                ->parse(str_replace(' ', '', $timeline->value))
                                                ->format('F d Y');
                                        @endphp
                                        <li class="timeline-item mb-7">
                                            <span class="timeline-icon">
                                                <i class="{{ $decoded->icon }} text-primary fa-sm fa-fw"></i>
                                            </span>

                                            <p class="mb-2 fw-bold">{{ $timeline->title }}</p>
                                            <h6 class="font-weight-bold">{{ $date }}</h6>
                                        </li>
                                    @empty
                                        <div class="col-12 text-center mb-4">
                                            <h5>No timeline yet</h5>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </section> --}}
                        @if (!empty($features->count()))
                            <section class="pt-6 border-bottom">
                                <h4 class="fs-22 text-heading mb-6">Facts and Features</h4>
                                <div class="row">
                                    @forelse ($features as $feature)
                                        @php
                                            $decoded = json_decode($feature->metadata);
                                        @endphp
                                        <div class="col-lg-3 col-sm-4 mb-6">
                                            <div class="media">
                                                <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                                    <svg class="icon {{ $decoded->icon }} fs-32 text-primary">
                                                        <use xlink:href="#{{ $decoded->icon }}"></use>
                                                    </svg>
                                                </div>
                                                <div class="media-body">
                                                    <h5
                                                        class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                        {{ $feature->key }}</h5>
                                                    <p class="mb-0 fs-13 font-weight-bold text-heading">
                                                        {{ $feature->value }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center mb-4">
                                            <h5>No features yet</h5>
                                        </div>
                                    @endforelse
                                </div>
                            </section>
                        @endif

                        @if ($additional_details->count() > 0)
                            <section class="pt-6 border-bottom pb-4">
                                <h4 class="fs-22 text-heading mb-4">Additional Details</h4>
                                <div class="row">
                                    @foreach ($additional_details as $specification)
                                        <dl class="col-sm-4 mb-0 d-flex">
                                            <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">
                                                {{ $specification->title }}</dt>
                                            <dd>{{ $specification->value }}</dd>
                                        </dl>
                                    @endforeach
                                    <dl class="col-sm-4 mb-0 d-flex">
                                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Area</dt>
                                        <dd>{{ $property->sqft }} Sq.Ft</dd>
                                    </dl>
                                </div>
                            </section>
                        @endif
                        @if ($amenities->count() > 0)
                            <section class="pt-6 border-bottom pb-4">
                                <h4 class="fs-22 text-heading mb-4">Offices Amenities</h4>
                                <ul class="list-unstyled mb-0 row no-gutters">
                                    @forelse ($amenities as $amenity)
                                        <li class="col-sm-3 col-6 mb-2"><i
                                                class="far fa-check mr-2 text-primary"></i>{{ $amenity->key }}
                                        </li>
                                    @empty
                                        <div class="col-12 text-center mb-4">
                                            <h5>No features yet</h5>
                                        </div>
                                    @endforelse
                                </ul>
                            </section>
                        @endif
                        @if ($document_files->count() > 0)
                            <section class="py-6 border-bottom">
                                <h4 class="fs-22 text-heading mb-6">Property Attachments</h4>
                                <div class="d-sm-flex">
                                    @foreach ($document_files as $document_file)
                                        @if ($document_file->type == 'word_document')
                                            <div class="w-sm-170 mb-sm-0 mb-6 mr-sm-6">
                                                <div class="card text-center pt-4">
                                                    <img src="{{ $web_assets }}/images/single-detail-property-05.png"
                                                        class="card-img card-img w-78px mx-auto"
                                                        alt="{{ $property->name }} Word Document">
                                                    <div class="card-body p-0 mt-4">
                                                        <p class="fs-13 lh-2  mb-0 py-0 px-2">{{ $document_file->name }}
                                                        </p>
                                                        <a href="{{ $document_file->file->url() }}"
                                                            class="btn btn-block bg-gray-01 border-0 fs-14 text-heading">Download<i
                                                                class="far fa-arrow-alt-circle-down ml-1 text-primary"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($document_file->type == 'pdf')
                                            <div class="w-sm-170 mb-sm-0 mb-6 mr-sm-6">
                                                <div class="card text-center pt-4">
                                                    <img src="{{ $web_assets }}/images/single-detail-property-06.png"
                                                        class="card-img card-img w-78px mx-auto"
                                                        alt="{{ $property->name }} PDF Document">
                                                    <div class="card-body p-0 mt-4">
                                                        <p class="fs-13 lh-2  mb-0 py-0 px-2">{{ $document_file->name }}
                                                        </p>
                                                        <a href="{{ $document_file->file->url() }}"
                                                            class="btn btn-block bg-gray-01 border-0 fs-14 text-heading">Download<i
                                                                class="far fa-arrow-alt-circle-down ml-1 text-primary"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        <section class="py-6 border-bottom">
                            <h4 class="fs-22 text-heading mb-6">Location</h4>
                            <div class="position-relative">
                                <div id="map" class="" style="height: 500px"> </div>
                                <p
                                    class="mb-0 p-3 bg-white shadow rounded-lg position-absolute pos-fixed-bottom mb-4 ml-4 lh-17 z-index-2">
                                    {{ $property->address }}</p>
                            </div>
                        </section>
                    </article>
                    <aside class="col-lg-4 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar">
                        <div class="primary-sidebar-inner">
                            <div class="card border-0">
                                <div class="card-body px-sm-6 shadow-xxs-2 pb-5 pt-0">
                                    <form>
                                        <div class="tab-content pt-4 pb-0 px-0 shadow-none">
                                            <div class="tab-pane fade show active" id="schedule" role="tabpanel">
                                                <!-- <input type="hidden" class="date" name="date" value="March 17, 2020"> -->
                                                <h2 class="fs-25 font-weight-bold text-center mb-1">Financial Summary</h2>
                                                <p class="lead text-center mb-0">Property price</p>
                                                <hr>
                                                <h2 class="display-4 font-weight-bold text-center mb-2">
                                                    {{ format_money($property->price, 2, $property->currency->short_name) }}
                                                </h2>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p>{{ $property->total_slots - $property->total_sold }}/{{ $property->total_slots }} Available Slots</p>
                                                    </div>
                                                </div>


                                                <div class="py-3 mt-1" style="background: #f9f9f9;">
                                                    <div class="">
                                                        <h2 class="fs-17 font-weight-bold text-center mb-5">Financial
                                                            Summary</h2>
                                                    </div>

                                                    <div class="d-flex justify-content-between px-4">
                                                        <div>
                                                            <p>First year projection</p>
                                                        </div>

                                                        <div class="font-weight-bold">
                                                            <p class="fs-17 text-primary font-weight-bold">
                                                                {{ format_money($property->first_year_projection, 2, $property->currency->short_name) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between px-4">
                                                        <div>
                                                            <p>Fifth year projection</p>
                                                        </div>

                                                        <div class="font-weight-bold">
                                                            <p class="fs-17 text-primary font-weight-bold">
                                                                {{ format_money($property->fifth_year_projection, 2, $property->currency->short_name) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between px-4">
                                                        <div>
                                                            <p>Tenth year projection</p>
                                                        </div>

                                                        <div class="font-weight-bold">
                                                            <p class="fs-17 text-primary font-weight-bold">
                                                                {{ format_money($property->tenth_year_projection, 2, $property->currency->short_name) }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>

                                                @if ($property->isAvailable())
                                                    <a target="_blank"
                                                        href="{{ route('dashboard.user.properties.payments.index', [$property->id]) }}"
                                                        class="btn btn-primary btn-lg btn-block rounded">Proceed to
                                                        payment
                                                    </a>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-primary btn-lg btn-block rounded">
                                                        {{ $property->getStatus() }}
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="tab-pane fade pt-5" id="request-info" role="tabpanel">
                                                <div class="form-check d-flex align-items-center border-bottom pb-3 mb-3">
                                                    <input class="form-check-input" type="radio" name="agent"
                                                        value="option1">
                                                    <div class="form-check-label ml-2">
                                                        <div class="d-flex align-items-center">
                                                            <a href="agent-details-1.html"
                                                                class="d-block w-60px h-60 mr-3">
                                                                <img src="{{ $web_assets }}/images/agent-2.jpg"
                                                                    class="rounded-circle" alt="agent-2">
                                                            </a>
                                                            <div>
                                                                <a href="agent-details-1.html"
                                                                    class="d-block text-dark font-weight-500 lh-15 hover-primary">Oliver
                                                                    Beddows</a>
                                                                <p class="mb-0 fs-13 mb-0 lh-17">Sales Excutive</p>
                                                                <p class="mb-0 fs-13 mb-0 lh-17">
                                                                    <span>(+123)</span><span
                                                                        class="text-heading d-inline-block ml-2">1900
                                                                        68668</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check d-flex align-items-center mb-6">
                                                    <input class="form-check-input" type="radio" name="agent"
                                                        id="inlineRadio2" value="option2">
                                                    <div class="form-check-label ml-2">
                                                        <div class="d-flex align-items-center">
                                                            <a href="agent-details-1.html"
                                                                class="d-block w-60px h-60 mr-3">
                                                                <img src="{{ $web_assets }}/images/agent-1.jpg"
                                                                    class="rounded-circle" alt="agent-1">
                                                            </a>
                                                            <div>
                                                                <a href="agent-details-1.html"
                                                                    class="d-block text-dark font-weight-500 lh-15 hover-primary">Max
                                                                    Kordex</a>
                                                                <p class="mb-0 fs-13 mb-0 lh-17">Real estate broker</p>
                                                                <p class="mb-0 fs-13 mb-0 lh-17">
                                                                    <span>(+123)</span><span
                                                                        class="text-heading d-inline-block ml-2">1900
                                                                        68668</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control form-control-lg border-0"
                                                        placeholder="First Name, Last Name">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <input type="email" class="form-control form-control-lg border-0"
                                                        placeholder="Your Email">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <input type="tel" class="form-control form-control-lg border-0"
                                                        placeholder="Your phone">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <textarea class="form-control border-0" rows="4">Hello, I'm interested in Villa Called Archangel</textarea>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary btn-lg btn-block rounded">Request
                                                    Info
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
        @if ($category_properties->isNotEmpty())
            <section class="pt-6 pb-8">
                <div class="container">
                    <h4 class="fs-22 text-heading mb-6">Similar Homes You May Like</h4>
                    <div class="slick-slider"
                        data-slick-options='{"slidesToShow": 3, "dots":false,"arrows":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                        @foreach ($category_properties as $category_property)
                            @php
                                $image_count = $category_property
                                    ->files()
                                    ->where('type', 'image')
                                    ->count();
                                $video_count = $category_property
                                    ->files()
                                    ->where('type', 'video')
                                    ->count();
                            @endphp
                            <div class="box">
                                <div class="card shadow-hover-2">
                                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top property_main_img"
                                        data-url="{{ route('web.properties.show', $category_property->id) }}">
                                        <img src="{{ $category_property->getDefaultImage() }}" alt="">
                                        <div class="card-img-overlay p-2 d-flex flex-column">
                                            <div>
                                                <span class="badge mr-2 badge-orange">featured</span>
                                                <span
                                                    class="badge mr-2 badge-indigo">{{ $category_property->status }}</span>
                                            </div>
                                            <ul class="list-inline mb-0 mt-auto hover-image">
                                                @if ($image_count > 0)
                                                    <li class="list-inline-item mr-2" data-toggle="tooltip"
                                                        title="{{ $image_count }} Images">
                                                        <a href="{{ route('web.properties.show', $category_property->id) }}"
                                                            class="text-white hover-primary">
                                                            <i class="far fa-images"></i><span
                                                                class="pl-1">{{ $image_count }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($video_count > 0)
                                                    <li class="list-inline-item" data-toggle="tooltip"
                                                        title="{{ $video_count }} Video">
                                                        <a href="{{ route('web.properties.show', $category_property->id) }}"
                                                            class="text-white hover-primary">
                                                            <i class="far fa-play-circle"></i><span
                                                                class="pl-1">{{ $video_count }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                        <h2 class="card-title fs-16 lh-2 mb-0"><a
                                                href="{{ route('web.properties.show', $category_property->id) }}"
                                                class="text-dark hover-primary">{{ $category_property->name }}</a></h2>
                                        <p class="card-text font-weight-500 text-gray-light mb-2">
                                            {{ $category_property->address }}</p>
                                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="3 Bedroom">
                                                <svg class="icon icon-bedroom fs-17 text-primary mr-1">
                                                    <use xlink:href="#icon-bedroom"></use>
                                                </svg>
                                                {{ $category_property->bedrooms }} Br
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="3 Bathrooms">
                                                <svg class="icon icon-shower fs-17 text-primary mr-1">
                                                    <use xlink:href="#icon-shower"></use>
                                                </svg>
                                                {{ $category_property->bathrooms }} Ba
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="Size">
                                                <svg class="icon icon-square fs-17 text-primary mr-1">
                                                    <use xlink:href="#icon-square"></use>
                                                </svg>
                                                {{ $category_property->sqft }} Sq.Ft
                                            </li>
                                        </ul>
                                    </div>
                                    <div
                                        class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                        <p class="fs-17 font-weight-bold text-heading mb-0">
                                            {{ format_money($category_property->price, 2, $category_property->currency->short_name) }}
                                        </p>
                                        <ul class="list-inline mb-0">

                                            <li class="list-inline-item">
                                                <a href="{{ route('web.properties.show', $category_property->id) }}"
                                                    data-toggle="tooltip" title="View Details"
                                                    class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent"><i
                                                        class="fas fa-arrow-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @if ($close_by_properties->isNotEmpty())
            <section class="pb-12">
                <div class="container">
                    <h4 class="fs-22 text-heading mb-6">Listings near {{ optional($property->state)->name }}
                        {{ optional($property->country)->name }}</h4>
                    <div class="slick-slider"
                        data-slick-options='{"slidesToShow": 3, "dots":false,"arrows":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                        @foreach ($close_by_properties as $close_by_property)
                            @php
                                $image_count = $close_by_property
                                    ->files()
                                    ->where('type', 'image')
                                    ->count();
                                $video_count = $close_by_property
                                    ->files()
                                    ->where('type', 'video')
                                    ->count();
                            @endphp
                            <div class="box">
                                <div class="card shadow-hover-2">
                                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top property_main_img"
                                        data-url="{{ route('web.properties.show', $close_by_property->id) }}">
                                        <img src="{{ $close_by_property->getDefaultImage() }}" alt="">
                                        <div class="card-img-overlay p-2 d-flex flex-column">
                                            <div>
                                                <span
                                                    class="badge mr-2 badge-primary">{{ $close_by_property->status }}</span>
                                            </div>
                                            <ul class="list-inline mb-0 mt-auto hover-image">
                                                @if ($image_count > 0)
                                                    <li class="list-inline-item mr-2" data-toggle="tooltip"
                                                        title="{{ $image_count }} Images">
                                                        <a href="{{ route('web.properties.show', $close_by_property->id) }}"
                                                            class="text-white hover-primary">
                                                            <i class="far fa-images"></i><span
                                                                class="pl-1">{{ $image_count }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ($video_count > 0)
                                                    <li class="list-inline-item" data-toggle="tooltip"
                                                        title="{{ $video_count }} Video">
                                                        <a href="{{ route('web.properties.show', $close_by_property->id) }}"
                                                            class="text-white hover-primary">
                                                            <i class="far fa-play-circle"></i><span
                                                                class="pl-1">{{ $video_count }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                        <h2 class="card-title fs-16 lh-2 mb-0"><a
                                                href="{{ route('web.properties.show', $close_by_property->id) }}"
                                                class="text-dark hover-primary">{{ $close_by_property->name }}</a></h2>
                                        <p class="card-text font-weight-500 text-gray-light mb-2">
                                            {{ $close_by_property->address }}</p>
                                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="3 Bedroom">
                                                <svg class="icon icon-bedroom fs-17 text-primary mr-1">
                                                    <use xlink:href="#icon-bedroom"></use>
                                                </svg>
                                                {{ $close_by_property->bedrooms }} Br
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="3 Bathrooms">
                                                <svg class="icon icon-shower fs-17 text-primary mr-1">
                                                    <use xlink:href="#icon-shower"></use>
                                                </svg>
                                                {{ $close_by_property->bathrooms }} Ba
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="Size">
                                                <svg class="icon icon-square fs-17 text-primary mr-1">
                                                    <use xlink:href="#icon-square"></use>
                                                </svg>
                                                {{ $close_by_property->sqft }} Sq.Ft
                                            </li>
                                        </ul>
                                    </div>
                                    <div
                                        class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                        <p class="fs-17 font-weight-bold text-heading mb-0">
                                            {{ format_money($close_by_property->price, 2, $close_by_property->currency->short_name) }}
                                        </p>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('web.properties.show', $close_by_property->id) }}"
                                                    data-toggle="tooltip" title="View Details"
                                                    class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent">
                                                    <i class="fas fa-arrow-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <input type="hidden" onload="loadChart({{ json_encode($location) }})">
    </main>
@endsection
@section('script')
    <script src="{{ $web_assets }}/js/custom.js"></script>
    <script src="{{ $web_assets }}/js/leaflet.js"></script>
    <script>
        // Creating map options
        var mapOptions = {
            center: [{{ $location['lat'] ?? null }}, {{ $location['lng'] ?? null }}],
            zoom: 10
        }

        // Creating a map object
        var map = new L.map("map", mapOptions);

        // Creating a Layer object
        var layer = new L.TileLayer(`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`);

        // Adding layer to the map
        map.addLayer(layer);
    </script>
@endsection
