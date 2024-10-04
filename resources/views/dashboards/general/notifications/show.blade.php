@extends('dashboards.user.layouts.app')

@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        <div class="container-fluid pt-3">
            <div class="row">
                <div class="col-12">
                    <div class="mb-2">
                        <h1>{{$notification["data"]["title"] ?? "New notification"}}</h1>
                        <div class="separator mb-5"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-2">
                    @include("layout.notifications.flash_messages")
                </div>

                <div class="col-12">
                    <div class="mt-2 mb-2">
                        {!! $notification->data["message"] ?? "" !!}
                    </div>
                    @if (!empty($link = $notification->data["link"] ?? null))

                    <div class="mb-2">
                        <a href="{{$link}}"> Open link</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
