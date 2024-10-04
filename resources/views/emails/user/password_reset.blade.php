@component('mail::message')

Hello <b>{{$name}}!</b><br>

You requested for a password reset on your account. Here`s your One Time Password (OTP)<br>

<b>OTP</b>: {{$pin}} <i>(Expires in 5 minutes)<i><br><br>

If you did not request for a password reset, ignore this message, no further action is required.<br>
Regards.
@endcomponent
