@extends("layouts.dashboard.app")
@section('content')


<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>Notifications</h1>
                <div class="separator mb-5"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            @include("layout.notifications.flash_messages")
        </div>

        @if(!empty($notifications->count()))
        @foreach ($notifications as $notification)
        <div class="col-12 mb-2">
            <a href="{{ route("auth.notifications.info" ,$notification->id) }}" class="{{ !empty($notification->read_at) ? "text-dark" : "text-success"}}">
                <div class="card">
                    <div class="card-body">
                        <div>{{ $notification->data["title"] ?? ""}}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @else
        @include("dashboard.fragments.no_item" , ["message" => "No notifications at the moment"])
        @endif
    </div>
</div>


@endsection
