@component('mail::message')

Hello <b>{{$name}}!</b><br>

Your are attempting to log into your account. Here`s your One Time Password (OTP)<br>

<b>OTP</b>: {{$pin}} <i>(Expires in 5 minutes)<i><br><br>

@endcomponent
