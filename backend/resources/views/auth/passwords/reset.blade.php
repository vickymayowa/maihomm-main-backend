@extends('auth.layouts.app')
@section('content')
    <main id="login_bg" class="auth_container">
        <section class="py-5">
            <div class="container">
                <div class="row login-register d-flex justify-content-center mt-100">
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-xxs-2 mb-6">
                            <div class="card-body px-8 py-6">
                                @include('notifications.flash_messages')
                                <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">Reset Password</h2>
                                <form action="{{ route('password.update') }}" class="form" method="POST"> @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group mb-4">
                                        <label for="username-1">Email</label>
                                        <input name="email" class="form-control" value="{{ $email ?? old('email') }}"
                                            type="email" required id="email" placeholder="Your email address here">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="username-1">New Password</label>
                                        <input name="password" class="form-control" required
                                            placeholder="Your new password">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="username-1">Confirm Password</label>
                                        <input name="password_confirmation" class="form-control" required
                                            placeholder="Confirm your new password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Reset
                                        Password</button>
                                </form>
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
        })
    </script>
@endsection
