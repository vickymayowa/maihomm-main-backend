@component('mail::message')

Hello <b>{{$name}}!</b><br>

You requested for a password reset on your account. Click the link below to reset password or copy your One Time Password (OTP)<br>

<b>OTP</b>: {{$otp}} <i>(Expires in 5 minutes)<i><br><br>

{{-- @component('mail::button', ['url' => $link])
Reset Password
@endcomponent --}}

If you did not request for a password reset, ignore this message, no further action is required.<br>
Regards.
@endcomponent
