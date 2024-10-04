<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

@include('dashboards.admin.layouts.includes.head')

<body>
    <div class="wrapper dashboard-wrapper">
        <div class="d-flex flex-wrap flex-xl-nowrap">
            <div class="db-sidebar bg-white">
                @include('dashboards.admin.layouts.includes.navbar')
            </div>
            <div class="page-content">
                @include('dashboards.admin.layouts.includes.header')
                @include('layout.notifications.flash_messages')
                @yield('content')
            </div>
        </div>
    </div>

    @include('dashboards.admin.layouts.includes.scripts')
    @include('dashboards.admin.layouts.includes.symbols')
    <form id="logoutForm" onsubmit="return confirm('Are you sure you want logout?')" action="{{ route('logout') }}"
        method="post">@csrf</form>
</body>

</html>
