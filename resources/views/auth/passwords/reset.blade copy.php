
@extends("auth.layouts.app" , [
"page_title" => "Reset Password",
"page_subtitle" => "Create your new password.",
"SEO_Metadata" => ["title" => "Reset Password | ".env("APP_NAME")]
])
@section("content")
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
    <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required placeholder="Enter your password">
        <label for="floatingPassword">Password</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" name="password_confirmation" class="form-control" id="floatingPassword" placeholder="Password" required placeholder="Re-enter your password">
        <label for="floatingPassword">Confirm Password</label>
    </div>

    <button class="btn btn-primary w-100" type="submit">Reset Password</button>

    <!--end col-->
</form>
@endsection
