@extends('dashboards.user.layouts.app')

@section('style')
 <style>
        .tabs {
            clear: both;
            position: relative;
            max-width: 650px;
            margin: 0 auto;
            min-height: 40px
        }

        .tab {
            float: left;
        }

        .tab .tab_btn {
            margin-top: 10px;
            margin-right: 20px;
            position: relative;
            top: 0;
            cursor: pointer;
            color: #333;
            text-transform: uppercase;
            font-size: 15px
        }

        .tab [type=radio] {
            display: none;
        }

        .active_properties_tab {
            border: 2px solid #dea739;
            border-radius: 50px;
            padding: 0px 5px;
            color: #fff !important;
            background-color: #dea739 !important;
            z-index: 2;
        }

        .slideDiv {
            background-color: #ffffff;
            height: 47px;
            width: 430px;
            border-radius: 90px
        }

        @media (min-width:800px) {
            .form-inline {
                margin-top: 1.875rem
            }
        }

        @media (max-width:800px) {
            #searchInput {
                width: 120px;
            }

            .tab label {
                font-size: 13px
            }

            .slideDiv {
                width: 359px;
            }

            .tab .tab_btn {
                margin-right: 8px;
                font-size: 14px
            }
        }
    </style>
@endsection
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        <div class="d-flex flex-wrap flex-md-nowrap mb-6">
            <div class="mr-0 mr-md-auto">
                <h2 class="mb-0 text-heading fs-22 lh-15">All properties<span class="badge badge-white badge-pill text-primary fs-18 font-weight-bold ml-2">{{ $properties->count() }}</span>
                </h2>

               <div class="mt-2 slideDiv">
                        <div data-tabs class="tabs col-12 pt-2">
                            @foreach ($statusOptions as $key => $value)
                                <a class="tab ml-2" href="{{ route('dashboard.user.properties.index', ['status' => $key]) }}">
                                    <span class="tab_btn {{ $key == (request()->status ?? 'Available') ? 'active_properties_tab' : '' }}">{{ $value }}</label>
                                </a>
                            @endforeach
                        </div>
                    </div>
            </div>
            {{-- <form id="sortByForm" class="form-inline justify-content-md-end mx-n2" action="{{ url()->current() }}" method="GET">
            <div class="p-2">
                <div class="input-group input-group-lg bg-white border searchInput" style="height: 50px">
                    <div class="input-group-prepend">
                        <button class="btn pr-0 shadow-none" type="submit"><i class="far fa-search"></i></button>
                    </div>
                    <input id="searchInput" type="search" value="{{ request()->search }}" class="form-control bg-transparent border-0 shadow-none text-body" placeholder="Search listing" name="search">
                </div>
            </div>
            <div class="p-2">
                <div class="input-group input-group-lg bg-white border" style="height: 50px">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent letter-spacing-093 border-0 pr-0"><i class="far fa-align-left mr-2"></i>Sort by:</span>
                    </div>
                    <select id="status" class="form-control bg-transparent pl-0 selectpicker d-flex align-items-center sortby" name="sortby" data-style="bg-transparent px-1 py-0 lh-1 font-weight-600 text-body">
                        @foreach ($filterOptions as $key => $value)
                        <option value="{{ $key }}" {{ request()->sortby == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </form> --}}
        </div>
        <div class="row">
            @forelse ($properties as $property)
            @php
            $image_count = $property
            ->files()
            ->where('type', 'image')
            ->count();
            $video_count = $property
            ->files()
            ->where('type', 'video')
            ->count();
            @endphp
            <div class="col-md-3 mb-6">
                <div class="card shadow-hover-1">
                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top property_main_img" data-url="{{ route('dashboard.user.properties.show', $property->id) }}">
                        <img src="{{ $property->getDefaultImage() }}" alt="">
                        <div class="card-img-overlay p-2 d-flex flex-column">
                            <div class="mt-auto hover-image">
                                <ul class="list-inline mb-0 d-flex align-items-end">
                                    @if ($image_count > 0)
                                    <li class="list-inline-item mr-2" data-toggle="tooltip" title="{{ $image_count }} Images">
                                        <a href="#" class="text-white hover-primary">
                                            <i class="far fa-images"></i><span class="pl-1">{{ $image_count }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($video_count > 0)
                                    <li class="list-inline-item" data-toggle="tooltip" title="{{ $video_count }} Video">
                                        <a href="#" class="text-white hover-primary">
                                            <i class="far fa-play-circle"></i><span class="pl-1">{{ $video_count }}</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <h2 class="card-title fs-16 lh-2 mb-0"><a href="{{ route('dashboard.user.properties.show', $property->id) }}" class="text-dark hover-primary">{{ $property->name }}</a>
                        </h2>
                        <p class="card-text font-weight-500 text-gray-light mb-2">{{ $property->address }}</p>
                        <ul class="list-inline d-flex mb-0 flex-wrap">
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2 " data-toggle="tooltip" title="{{ $property->bedrooms }} Br">
                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-bedroom"></use>
                                </svg>
                                {{ $property->bedrooms }} Br
                            </li>
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2" data-toggle="tooltip" title="{{ $property->bathrooms }} Ba">
                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-shower"></use>
                                </svg>
                                {{ $property->bathrooms }} Ba
                            </li>
                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center px-1 mr-2" data-toggle="tooltip" title="{{ $property->sqft }} Sq.Ft">
                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-square"></use>
                                </svg>
                                {{ $property->sqft }} Sq.Ft
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                        <div class="mr-auto">
                            <label for="">Per Slot</label>
                            <span class="text-heading lh-15 font-weight-bold fs-15 ml-1">{{ format_money($property->per_slot, 2, $property->currency->short_name) }}</span>
                        </div>
                        <form class="d-flex savedPropertyForm_{{ $property->id }}" action="{{ route('dashboard.user.saved-properties.store', $property->id) }}" method="post" data-action_type="add">@csrf
                            <li class="list-inline-item">
                                <a id="{{ $property->id }}" data-toggle="tooltip" title="Wish list" class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-secondary bg-accent border-accent savedProperty"><i class="fas fa-heart icon_{{ $property->id }}" id="icon_{{ $property->id }}"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ route('dashboard.user.properties.show', $property->id) }}" data-toggle="tooltip" title="View Details" class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent"><i class="fas fa-arrow-right"></i></a>
                            </li>
                        </form>
                        </ul>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12 col-xxl-12 mt-6">
                <h5 class="text-center">No properties found in this category</b></h5>
            </div>
            @endforelse
        </div>
    </div>
    <input type="hidden" name="" id="user_saved_properties" value="{{ $property_ids }}">
</main>
@endsection

@section('script')
    <script src="{{ $web_assets }}/js/custom.js"></script>
@endsection
