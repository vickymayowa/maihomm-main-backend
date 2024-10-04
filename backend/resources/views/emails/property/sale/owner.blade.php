@component('mail::message')
Hey {{$owner->fullname}},

Your request to sell your <b>{{$property->name}}</b> property is being processed. You will be notified on the status of this request.
{{-- @component('mail::button', ['url' => route("login")])
    Login
@endcomponent --}}

Thanks,<br>
Customer Care
@endcomponent
