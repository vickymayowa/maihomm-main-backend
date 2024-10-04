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
                                <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">Confirm Password</h2>
                                <form action="{{ route('password.confirm') }}" class="form" method="POST"> @csrf
                                    <div class="form-group mb-4">
                                        <label for="username-1">Password</label>
                                        <input name="password" class="form-control" required
                                            placeholder="Enter password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Confirm
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
