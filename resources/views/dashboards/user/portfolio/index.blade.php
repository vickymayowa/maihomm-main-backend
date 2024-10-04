@extends('dashboards.user.layouts.app')

@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include("layout.notifications.flash_messages")
        <div class="d-flex flex-wrap flex-md-nowrap mb-6">
            <div class="mr-0 mr-md-auto">
                <h2 class="mb-0 text-heading fs-22 lh-15">Welcome back, {{ auth()->user()->full_name }}!</h2>
            </div>
            <div>
                <a href="{{ route('dashboard.user.properties.index') }}" class="btn btn-primary btn-lg">
                    <span>Get a new Property</span>
                    <span class="d-inline-block ml-1 fs-20 lh-1"><svg class="icon icon-add-new">
                            <use xlink:href="#icon-add-new"></use>
                        </svg></span>
                </a>
            </div>
        </div>
        {{-- <!--------- Chart ----->
            <div class="row">
                <div class="col-xxl-12 mb-6">
                    <div class="card px-7 py-6 h-100 chart">
                        <div class="card-body p-0 collapse-tabs">
                            <div class="d-flex align-items-center mb-5">
                                <h2 class="mb-0 text-heading fs-22 lh-15 mr-auto">Portfolio Value</h2>
                                <ul class="nav nav-pills justify-content-end d-none d-sm-flex nav-pills-01" role="tablist">
                                    <li class="nav-item px-5 py-1">
                                        <a class="nav-link active bg-transparent shadow-none p-0 letter-spacing-1" id="hours-tab" data-toggle="tab" href="#hours" role="tab" aria-controls="hours"
                                            aria-selected="true">Hours</a>
                                    </li>
                                    <li class="nav-item px-5 py-1">
                                        <a class="nav-link bg-transparent shadow-none p-0 letter-spacing-1" id="weekly-tab" data-toggle="tab" href="#weekly" role="tab" aria-controls="weekly"
                                            aria-selected="false">Weekly</a>
                                    </li>
                                    <li class="nav-item px-5 py-1">
                                        <a class="nav-link bg-transparent shadow-none p-0 letter-spacing-1" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly"
                                            aria-selected="false">Monthly</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content shadow-none p-0">
                                <div id="collapse-tabs-accordion">
                                    <div class="tab-pane tab-pane-parent fade show active px-0" id="hours" role="tabpanel" aria-labelledby="hours-tab">
                                        <div class="card bg-transparent mb-sm-0 border-0">
                                            <div class="card-header d-block d-sm-none bg-transparent px-0 py-1 border-bottom-0" id="headingHours">
                                                <h5 class="mb-0">
                                                    <button class="btn collapse-parent font-size-h5 btn-block border shadow-none" data-toggle="collapse" data-target="#hours-collapse" aria-expanded="true"
                                                        aria-controls="hours-collapse">
                                                        Hours
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="hours-collapse" class="collapse show collapsible" aria-labelledby="headingHours" data-parent="#collapse-tabs-accordion">
                                                <div class="card-body p-0 py-4">
                                                    <canvas class="chartjs" data-chart-options="[]" data-chart-labels='["05h","08h","11h","14h","17h","20h","23h"]'
                                                        data-chart-datasets='[{"label":"Clicked","data":[0,7,10,3,15,30,10],"backgroundColor":"rgba(105, 105, 235, 0.1)","borderColor":"#6969eb","borderWidth":3,"fill":true},{"label":"View","data":[10,9,18,20,28,40,27],"backgroundColor":"rgba(254, 91, 52, 0.1)","borderColor":"#ff6935","borderWidth":3,"fill":true}]'>
                                                    </canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane tab-pane-parent fade px-0" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                                        <div class="card bg-transparent mb-sm-0 border-0">
                                            <div class="card-header d-block d-sm-none bg-transparent px-0 py-1 border-bottom-0" id="headingWeekly">
                                                <h5 class="mb-0">
                                                    <button class="btn collapse-parent font-size-h5 btn-block collapsed border shadow-none" data-toggle="collapse" data-target="#weekly-collapse" aria-expanded="true"
                                                        aria-controls="weekly-collapse">
                                                        Weekly
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="weekly-collapse" class="collapse collapsible" aria-labelledby="headingWeekly" data-parent="#collapse-tabs-accordion">
                                                <div class="card-body p-0 py-4">
                                                    <canvas class="chartjs" data-chart-options="[]" data-chart-labels='["Mar 12","Mar 13","Mar 14","Mar 15","Mar 16","Mar 17","Mar 18","Mar 19"]'
                                                        data-chart-datasets='[{"label":"Clicked","data":[0,13,9,3,15,15,10,0],"backgroundColor":"rgba(105, 105, 235, 0.1)","borderColor":"#6969eb","borderWidth":3,"fill":true},{"label":"View","data":[10,20,18,15,28,33,27,10],"backgroundColor":"rgba(254, 91, 52, 0.1)","borderColor":"#ff6935","borderWidth":3,"fill":true}]'>
                                                    </canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane tab-pane-parent fade px-0" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                        <div class="card bg-transparent mb-sm-0 border-0">
                                            <div class="card-header d-block d-sm-none bg-transparent px-0 py-1 border-bottom-0" id="headingMonthly">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-block collapse-parent collapsed border shadow-none" data-toggle="collapse" data-target="#monthly-collapse" aria-expanded="true"
                                                        aria-controls="monthly-collapse">
                                                        Monthly
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="monthly-collapse" class="collapse collapsible" aria-labelledby="headingMonthly" data-parent="#collapse-tabs-accordion">
                                                <div class="card-body p-0 py-4">
                                                    <canvas class="chartjs" data-chart-options="[]" data-chart-labels='["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]'
                                                        data-chart-datasets='[{"label":"Clicked","data":[2,15,20,10,15,20,10,0,20,30,10,0],"backgroundColor":"rgba(105, 105, 235, 0.1)","borderColor":"#6969eb","borderWidth":3,"fill":true},{"label":"View","data":[10,20,18,15,28,33,27,10,20,30,10,0],"backgroundColor":"rgba(254, 91, 52, 0.1)","borderColor":"#ff6935","borderWidth":3,"fill":true}]'>
                                                    </canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!------Chart ends ----> --}}

        <div class="d-flex flex-wrap flex-md-nowrap mb-6">
            <div class="mr-0 mr-md-auto">
                <h2 class="mb-0 text-heading fs-22 lh-15">Quick Insights</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xxl-4 mb-6">
                <div class="card">
                    <div class="card-body row align-items-center px-6 py-7">
                        <div class="col-5">
                            <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-blue badge-circle">
                                <svg class="icon icon-my-properties">
                                    <use xlink:href="#icon-my-properties"></use>
                                </svg>
                            </span>
                        </div>
                        <div class="col-7 text-center">
                            <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="{{ $portfolio->pending_investments_count }}" data-decimals="0" data-duration="0" data-separator="">
                                {{ $portfolio->pending_investments_count }}
                            </p>
                            <p>Pending Investments</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-4 mb-6">
                <div class="card">
                    <div class="card-body row align-items-center px-6 py-7">
                        <div class="col-5">
                            <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-green badge-circle">
                                <svg class="icon icon-building">
                                    <use xlink:href="#icon-building"></use>
                                </svg>
                            </span>
                        </div>
                        <div class="col-7 text-center">
                            <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="{{ $portfolio->active_investments_count }}" data-decimals="0" data-duration="0" data-separator="">
                                {{ $portfolio->active_investments_count }}
                            </p>
                            <p>Active Investments</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-4 mb-6">
                <div class="card">
                    <div class="card-body row align-items-center px-6 py-7">
                        <div class="col-5">
                            <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-pink badge-circle">
                                <svg class="icon icon-heart">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                            </span>
                        </div>
                        <div class="col-7 text-center">
                            <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="{{ $saved_properties_count }}" data-decimals="0" data-duration="0" data-separator="">
                                {{$saved_properties_count }}
                            </p>
                            <p>Saved Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- {{-- <div class="d-flex flex-wrap flex-md-nowrap mb-6">
                <div class="mr-0 mr-md-auto">
                    <h2 class="mb-0 text-heading fs-22 lh-15">Key Financials</h2>
                </div>
            </div> -- }} --}}

        {{-- <div class="row">
                <div class="col-sm-6 col-xxl-4 mb-6">
                    <div class="card">
                        <div class="card-body row align-items-center px-6 py-7">
                            <div class="col-5">
                                <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-blue badge-circle">
                                    <svg class="icon icon-1">
                                        <use xlink:href="#icon-1"></use>
                                    </svg>
                                </span>
                            </div>
                            <div class="col-7 text-center">
                                <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="{{ $portfolio->monthly_income }}" data-decimals="0" data-duration="0" data-separator="">{{ $portfolio->monthly_income }}
        </p>
        <p>Monthly Income</p>
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-6 col-xxl-4 mb-6">
        <div class="card">
            <div class="card-body row align-items-center px-6 py-7">
                <div class="col-5">
                    <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-green badge-circle">
                        <svg class="icon icon-2">
                            <use xlink:href="#icon-2"></use>
                        </svg>
                    </span>
                </div>
                <div class="col-7 text-center">
                    <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="{{ $portfolio->total_income }}" data-decimals="0" data-duration="0" data-separator="">{{ $portfolio->total_income }}</p>
                    <p>Total Income</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xxl-4 mb-6">
        <div class="card">
            <div class="card-body row align-items-center px-6 py-7">
                <div class="col-4">
                    <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-yellow badge-circle">
                        <svg class="icon icon-review">
                            <use xlink:href="#icon-review"></use>
                        </svg>
                    </span>
                </div>
                <div class="col-8 text-center">
                    <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="{{ $portfolio->value_appreciation }}" data-decimals="0" data-duration="0" data-separator="">
                        {{ $portfolio->value_appreciation }}</p>
                    <p>Value Appreciation</p>
                </div>
            </div>
        </div>
    </div>
    </div> --}}

    <!--------- Table ----->
    <div class="row">
        <!--------- Table ----->

        <div class="col-xxl-12 mb-6">
            @if ($investments->isNotEmpty())
            <div class="card px-7 py-6 h-100 chart">
                <div class="card-body p-0 collapse-tabs">
                    <h2 class="mb-0 text-heading fs-22 lh-15 mr-auto">Investments</h2>

                    <div class="d-flex align-items-center mb-5">
                        <table class="table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Property</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Investment Cost</th>
                                    <th scope="col">Start date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investments->take(3) as $investment)
                                <tr>
                                    <td>
                                        {{ $investment->property->name }}
                                    </td>
                                    <td>
                                        {{ $investment->property->address }}
                                    </td>
                                    <td>
                                        {{ $investment->value }}
                                    </td>
                                    <td>
                                        {{ $investment->start_date ?? "N/A" }}
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-{{pillClasses($investment->status)}} ">
                                            {{ $investment->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="card px-7 py-6 h-100 chart">
                <div class="card-body p-0 collapse-tabs">
                    <div class="text-center m-5">
                        No properties
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!--------- Table ends ------>
    </div>
</main>
@endsection
