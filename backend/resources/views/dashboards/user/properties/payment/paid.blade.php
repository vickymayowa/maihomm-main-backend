@extends('dashboards.user.layouts.app')

@section('content')
    <main id="content" class="bg-gray-01">
        <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 text-md-center">
            <div class="mb-5 text-center">
                <img src="{{ asset("assets/images/bg-img/16271-payment-successful.gif")}}" class="img-fluid" style="width:30vh" alt="">
            </div>
            <div class="mb-6">
                <p class="lead">Your payment is under review, admin will reachout to you once the payment is confirmed</p>
            </div>

            <!-- Button trigger modal -->
            <div>
                <a href="{{ route('dashboard.user.portfolio.index') }}" class="btn btn-secondary mb-3">Portfolio page</a>
            </div>
        </div>
    </main>
@endsection
