<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

@include('dashboards.user.layouts.includes.head')

<body>
    <div class="wrapper dashboard-wrapper">
        <div class="d-flex flex-wrap flex-xl-nowrap">
            <div class="db-sidebar bg-white">
                @include('dashboards.user.layouts.includes.navbar')
            </div>
            <div class="page-content">
                @include('dashboards.user.layouts.includes.header')

                @yield("content")
            </div>
        </div>
    </div>

    @include('dashboards.user.layouts.includes.scripts')
    @include('dashboards.user.layouts.includes.symbols')
</body>

</html>
