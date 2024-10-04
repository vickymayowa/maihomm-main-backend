@component('mail::message')
Hey Admin,

A new property sale request from <b>{{$owner->fullname}}</b> has been placed on the Maihomm system. View details on your dashboard

{{-- @component('mail::button', ['url' => route("login")])
    Login
@endcomponent --}}

Thanks,<br>
Customer Care
@endcomponent
