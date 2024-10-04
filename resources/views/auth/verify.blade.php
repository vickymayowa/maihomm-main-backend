@extends('auth.layouts.app', [
    'page_title' => 'Verify Your Email Address',
    'page_subtitle' => 'Don`t worry, you will not repeat this process unless you change your email address.',
    'SEO_Metadata' => ['title' => 'Verify Email | ' . env('APP_NAME')],
])
@section('content')
    <main id="content">
        <section class="py-13">
            <div class="container">
                @include('notifications.flash_messages')
                <div class="row login-register">
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-xxs-2 mb-6">
                            <div class="card-body px-8 py-6">
                                <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">Log In</h2>
                                <form class="d-inline mb-2" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    @if (session('resent'))
                                        <div class="alert alert-success" role="alert">
                                            {{ __('A fresh verification link has been sent to your email address.') }}
                                        </div>
                                    @endif

                                    {{ __('Before proceeding, please check your email for a verification link.') }}
                                    {{ __('If you did not receive the email') }},
                                    <button class="btn btn-primary w-100 mt-3" type="submit">Click here to request another</button>
                                </form>
                                <hr>
                                <div class="row mt-2">
                                    <div class="col-md-6 mb-3">
                                        <button class="btn btn-success w-100" type="button" data-bs-toggle="modal" data-bs-target="#change_email">Change Email</button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <form method="POST" onsubmit="return confirm('Are you sure you want logout?')" action="{{ route('logout') }}" id="logoutForm">@csrf
                                            <button class="btn btn-outline-danger w-100" type="submit">
                                                Sign Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
