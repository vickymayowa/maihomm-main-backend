@extends('auth.layouts.app', [
    'page_title' => 'Login',
    'page_subtitle' => 'We are super excited to have you on board.',
    'SEO_Metadata' => ['title' => 'Register | ' . env('APP_NAME')],
])

@section('style')
    <style>
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        .safetyNotice {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 3px;
        }
    </style>
@endsection
@section('content')
    <main id="login_bg" class="auth_container">
        <div class="text-center pt-5">
            <a class="navbar-brand mt-5" href="{{ route('web.index') }}">
                <img src="{{ $web_assets }}/images/logom.png" width="80" alt="Maihomm">
            </a>
        </div>
        <section class="py-5">
            <div class="container">
                <div class="row login-register d-flex justify-content-center mt-5">
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-xxs-2 mb-6">
                            <div class="card-body px-8 py-6">
                                <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">Log In</h2>
                                @include('notifications.flash_messages')

                                <form action="{{ route('login') }}" class="form" method="POST"> @csrf
                                    <div class="form-group mb-4">
                                        <label for="username-1">Email</label>
                                        <input type="text" class="form-control form-control-lg border-0" id="username-1" name="email" placeholder="Your email">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="password-2">Password</label>
                                        <div class="input-group input-group-lg">
                                            <input type="password" class="form-control border-0 shadow-none fs-13" id="password" name="password" placeholder="Password">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-gray-01 password_toggle border-0 text-body fs-18" data-target="#password">
                                                    <i class="far fa-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="remember-me-1" name="remember">
                                            <label class="form-check-label" for="remember-me-1">
                                                Stay signed in
                                            </label>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="d-inline-block ml-auto fs-13 lh-2 text-body">
                                            <u>Forgot your password?</u>
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Log
                                        in</button>
                                </form>
                                @if (request()->route()->getName() != 'admin.login')
                                    <div class="my-4 text-center">
                                        <p class="mb-2">Don't have an account? <a href="{{ route('register') }}" class="text-heading hover-primary"><u>Click to Sign up</u></a></p>
                                    </div>
                                @endif
                                <div class="my-2 text-center">
                                    <p>Are my funds and asset safe at Maihomm?
                                        <a class="text-heading hover-primary"></a>
                                    </p>
                                </div>

                                <div class="safetyNotice alert-info">
                                    <p>All clients funds and co-owned properties are
                                        held in Trust by Maihomm Trustees, a UK registered trust
                                        and regulated by the HMRC
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
@section('script')
    <script>
        $(".password_toggle").on("click", function() {
            const target = $($(this).attr("data-target"));
            const target_type = target.attr("type");
            if (target_type == "text") {
                target.attr("type", "password");
                $(this).html('<i class="far fa-eye-slash"></i>');
            } else {
                target.attr("type", "text");
                $(this).html('<i class="far fa-eye"></i>');
            }
        })
    </script>
@endsection
@section('script')
    <script>
        $(".password_toggle").on("click", function() {
            const target = $($(this).attr("data-target"));
            const target_type = target.attr("type");
            if (target_type == "text") {
                target.attr("type", "password");
                $(this).html('<i class="far fa-eye-slash"></i>');
            } else {
                target.attr("type", "text");
                $(this).html('<i class="far fa-eye"></i>');
            }
        });
    </script>
@endsection
