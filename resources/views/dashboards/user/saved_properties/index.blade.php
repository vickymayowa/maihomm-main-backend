@extends('dashboards.user.layouts.app')

@section('content')
    <main id="content" class="bg-gray-01">
        <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
            <div class="d-flex flex-wrap flex-md-nowrap mb-6">
                <div class="mr-0 mr-md-auto">
                    <h2 class="mb-0 text-heading fs-22 lh-15">Saved properties<span class="badge badge-white badge-pill text-primary fs-18 font-weight-bold ml-2">{{ $properties->count() }}</span>
                    </h2>
                    {{-- <p>Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscipit</p> --}}
                </div>
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
                    <div class="col-md-6 col-xxl-3 mb-6">
                        <div class="card shadow-hover-1">
                            <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                                <img src="{{ $property->getDefaultImage() }}" alt="Home in Metric Way">
                                <div class="card-img-overlay p-2 d-flex flex-column">
                                    <div>
                                        <span class="badge badge-primary">{{ $property->status }}</span>
                                    </div>
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
                                    <span class="text-heading lh-15 font-weight-bold fs-17">{{ format_money($property->price, 2, $property->currency->short_name) }}</span>
                                </div>
                                <ul class="list-inline mb-0">
                                    <form class="d-flex savedPropertyForm_{{ $property->id }}" action="{{ route('dashboard.user.saved-properties.store', $property->id) }}" method="post" data-action_type="delete">
                                        @csrf
                                        <li>
                                            <a id="{{ $property->id }}" data-toggle="tooltip" title="Remove from Wish list"
                                                class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-secondary bg-accent border-accent savedProperty">
                                                <i class="fas fa-heart icon_{{ $property->id }}" id="icon_{{ $property->id }}"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{ route('dashboard.user.properties.show', $property->id) }}" data-toggle="tooltip" title="View Details"
                                                class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent"><i
                                                    class="fas fa-arrow-right"></i></a>
                                        </li>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 col-xxl-12 mt-6">
                        <h5 class="text-center">No saved properties</b></h5>
                    </div>
                @endforelse
            </div>
        </div>
        <input type="hidden" name="" id="user_saved_properties" value="">
    </main>
@endsection

@section('script')
    <script src="{{ $web_assets }}/js/custom.js"></script>
@endsection
