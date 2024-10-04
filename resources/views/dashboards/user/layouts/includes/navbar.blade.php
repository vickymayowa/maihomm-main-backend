<nav class="navbar navbar-expand-xl navbar-light d-block px-0 header-sticky dashboard-nav py-0">
    <div class="sticky-area shadow-xs-1 py-3">
        <div class="d-flex px-3 px-xl-6 w-100">
            <a class="navbar-brand" href="{{ route("dashboard.home") }}">
                <img src="{{ $web_assets }}/images/logom.png" width="100" alt="Maihomm">
            </a>
            <div class="ml-auto d-flex align-items-center ">
                <div class="d-flex align-items-center d-xl-none">
                    <div class="dropdown px-3">
                        <a href="#" class="dropdown-toggle d-flex align-items-center text-heading" data-toggle="dropdown">
                            <div class="mr-4 w-48px">
                                <img src="{{ auth()->user()->imageUrl() }}" style="height: 47px" alt="{{ auth()->user()->full_name }}" class="rounded-circle">
                            </div>
                            <div class="fs-13 font-weight-500 lh-1">
                                {{ auth()->user()->full_name }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('dashboard.user.profile-page') }}">My Profile</a>
                            <a class="dropdown-item logout_btn" href="#" onclick="$('#logoutForm').submit()">Logout</a>
                            <form id="logoutForm" onsubmit="return confirm('Are you sure you want logout?')" action="{{ route('logout') }}" method="post">@csrf</form>
                        </div>
                    </div>
                    {{-- <div class="dropdown no-caret py-4 px-3 d-flex align-items-center notice mr-3">
                        <a href="#" class="dropdown-toggle text-heading fs-20 font-weight-500 lh-1" data-toggle="dropdown">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-primary badge-circle badge-absolute font-weight-bold fs-13">1</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div> --}}
                </div>
                <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse" data-target="#primaryMenuSidebar" aria-controls="primaryMenuSidebar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
        <div class="collapse navbar-collapse bg-white" id="primaryMenuSidebar">
            {{-- <form class="d-block d-xl-none pt-5 px-3">
                <div class="input-group">
                    <div class="input-group-prepend mr-0 bg-input">
                        <button class="btn border-0 shadow-none fs-20 text-muted pr-0" type="submit"><i class="far fa-search"></i></button>
                    </div>
                    <input type="text" class="form-control border-0 form-control-lg shadow-none" placeholder="Search for..." name="search">
                </div>
            </form> --}}
            <ul class="list-group list-group-flush w-100">
                <li class="list-group-item pt-6 pb-4">
                    <h5 class="fs-13 letter-spacing-087 text-muted mb-3 text-uppercase px-3">Main</h5>
                    <ul class="list-group list-group-no-border rounded-lg">
                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                            <a href="{{ route('dashboard.user.portfolio.index') }}" class="text-heading lh-1 sidebar-link">
                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i class="fal fa-briefcase"></i></span>
                                <span class="sidebar-item-text">My Portfolio</span>
                            </a>
                        </li>

                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                            <a href="{{ route('dashboard.user.properties.index') }}" class="text-heading lh-1 sidebar-link">
                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i class="fal fa-building"></i></span>
                                <span class="sidebar-item-text">All Properties</span>
                            </a>
                        </li>

                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                            <a href="{{ route('dashboard.user.saved-properties') }}" class="text-heading lh-1 sidebar-link">
                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i class="fal fa-building"></i></span>
                                <span class="sidebar-item-text">Saved Properties</span>
                            </a>
                        </li>

                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                            <a href="{{ route('dashboard.user.profile-page') }}" class="text-heading lh-1 sidebar-link">
                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i class="fal fa-user"></i></span>
                                <span class="sidebar-item-text">My Profile</span>
                            </a>
                        </li>

                        <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                            <a onclick="$('#logoutForm').submit()" class="text-heading lh-1 sidebar-link">
                                <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i class="fal fa-sign-out"></i></span>
                                <span class="sidebar-item-text">Logout</span>
                            </a>
                            <form id="logoutForm" action="{{ route('logout') }}" method="post">@csrf</form>
                        </li>

                    </ul>
                </li>
                </li>
            </ul>
        </div>
    </div>
</nav>
