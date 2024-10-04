@extends('auth.layouts.app', [
'page_title' => 'Register',
'page_subtitle' => 'We are super excited to have you on board.',
'SEO_Metadata' => ['title' => 'Register | ' . env('APP_NAME')],
])

@section('content')
<main id="register_bg" class="auth_container">
    <div class="text-center pt-5">
        <a class="navbar-brand mt-5" href="{{ route("web.index") }}">
            <img src="{{ $web_assets }}/images/logom.png" width="80" alt="Maihomm">
        </a>
    </div>
    <section class="py-5">
        <div class="container">
            <div class="row login-register d-flex justify-content-center mt-5">
                <div class="col-lg-7">
                    @include('layout.notifications.flash_messages')
                    <div class="card border-0 shadow-xxs-2">
                        <div class="card-body px-6 py-6">
                            <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">Sign Up</h2>
                            <form action="{{ route('register') }}" class="form" method="POST"> @csrf
                                <div class="form-row mx-n2">
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label for="firstName" class="text-heading">First Name</label>
                                            <input type="text" name="first_name" class="form-control form-control-lg border-0" id="firstName" placeholder="First Name" value="{{ old('first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label for="lastName" class="text-heading">Last Name</label>
                                            <input type="text" name="last_name" class="form-control form-control-lg border-0" id="lastName" placeholder="Last Name" value="{{ old('last_name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mx-n2">
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label for="email" class="text-heading">Email</label>
                                            <input type="text" class="form-control form-control-lg border-0" id="email" placeholder="Your Email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label for="phone" class="text-heading">Phone</label>
                                            <input type="text" class="form-control form-control-lg border-0" id="phone" placeholder="Your Phone Number" name="phone_no" value="{{ old('phone_no') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mx-n2">
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label for="password-1" class="text-heading">Password</label>
                                            <div class="input-group input-group-lg">
                                                <input type="password" class="form-control border-0 shadow-none" id="password" name="password" placeholder="Password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gray-01 border-0 text-body password_toggle fs-18" data-target="#password">
                                                        <i class="far fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label for="re-password">Re-Enter Password</label>
                                            <div class="input-group input-group-lg">
                                                <input type="password" class="form-control border-0 shadow-none" id="password2" name="password_confirmation" placeholder="Password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gray-01 border-0 text-body password_toggle fs-18" data-target="#password2">
                                                        <i class="far fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Register</button>
                            </form>
                            <div class="my-4 text-center">
                                <p class="mb-2">Already have an account? <a href="{{ route('login') }}" class="text-heading hover-primary"><u>Login here</u></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section("script")
    <script>
        $(".password_toggle").on("click" , function(){
            const target = $( $(this).attr("data-target"));
            const target_type = target.attr("type");
            if(target_type == "text"){
                target.attr("type" , "password");
                $(this).html('<i class="far fa-eye-slash"></i>');
            }else{
                target.attr("type" , "text");
                $(this).html('<i class="far fa-eye"></i>');
            }
        })
    </script>
@endsection
