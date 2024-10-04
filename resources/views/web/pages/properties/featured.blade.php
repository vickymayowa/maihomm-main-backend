@extends('web.pages.properties.layout')
@section('content')
    <main id="content" class="bg-gray-01">
        <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
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
                            <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top property_main_img" data-url="{{ route('web.properties.show', $property->id) }}">
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
                                <h2 class="card-title fs-16 lh-2 mb-0"><a href="{{ route('web.properties.show', $property->id) }}" class="text-dark hover-primary">{{ $property->name }}</a>
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
                                    <span class="text-heading lh-15 font-weight-bold fs-15">{{ format_money($property->price, 2, $property->currency->short_name) }}</span>
                                </div>
                                <li class="list-inline-item">
                                    <a href="{{ route('web.properties.show', $property->id) }}" data-toggle="tooltip" title="View Details"
                                        class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent"><i
                                            class="fas fa-arrow-right"></i></a>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>
    </main>
@endsection

