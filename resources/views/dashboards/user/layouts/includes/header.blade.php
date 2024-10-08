<header class="main-header shadow-none shadow-lg-xs-1 bg-white position-relative d-none d-xl-block">
    <div class="container-fluid">
        <nav class="navbar navbar-light py-0 row no-gutters px-3 px-lg-0">
            <div class="col-md-4 px-0 px-md-6 order-1 order-md-0">
                {{-- <form>
                    <div class="input-group">
                        <div class="input-group-prepend mr-0">
                            <button class="btn border-0 shadow-none fs-20 text-muted p-0" type="submit"><i class="far fa-search"></i></button>
                        </div>
                        <input type="text" class="form-control border-0 bg-transparent shadow-none" placeholder="Search for..." name="search">
                    </div>
                </form> --}}
            </div>
            <div class="col-md-6 d-flex flex-wrap justify-content-md-end order-0 order-md-1">
                <div class="dropdown border-md-right border-0 py-3 text-right">
                    <a href="#" class="dropdown-toggle text-heading pr-3 pr-sm-6 d-flex align-items-center justify-content-end" data-toggle="dropdown">
                        <div class="mr-4 w-48px">
                            <img src="{{ auth()->user()->imageUrl() }}" style="height: 47px" alt="{{ auth()->user()->full_name }}" class="rounded-circle">
                        </div>
                        <div class="fs-13 font-weight-500 lh-1">
                            {{ auth()->user()->full_name }}
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right w-100">
                        <a class="dropdown-item" href="{{ route("dashboard.user.profile-page") }}">My Profile</a>
                        <a class="dropdown-item" onclick="$('#logoutForm').submit()">Logout</a>
                        <form id="logoutForm" onsubmit="return confirm('Are you sure you want logout?')" action="{{ route("logout") }}" method="post">@csrf</form>
                    </div>
                </div>
                {{-- <div class="dropdown no-caret py-3 px-3 px-sm-6 d-flex align-items-center justify-content-end notice">
                    <a href="#" class="dropdown-toggle text-heading fs-20 font-weight-500 lh-1" data-toggle="dropdown">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-primary badge-circle badge-absolute font-weight-bold fs-13">
                            {{auth()->user()->unreadNotifications->count()}}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                        <a class="dropdown-item" href="{{ route("dashboard.notifications.info" , $notification->id) }}">
                            {{ $notification->data['title'] ?? "" }}
                        </a>
                        @empty
                        <div class="text-center">No notifications</div>
                        @endforelse
                    </div>
                </div> --}}
            </div>
        </nav>
    </div>
</header>
