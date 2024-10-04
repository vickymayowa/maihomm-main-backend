@component('mail::message')
Hey Admin,

A new loan request has been placed on the Maihomm system. View loan details below:

<p>Reference: <b>{{$loan->reference}}</b></p>
<p>Requester: <b>{{$loan->user->names()}}</b></p>
<p>Amount: <b>{{$loan->amount}}</b></p>
<p>Eligibile Amount: <b>{{$loan->eligible_amount}}</b></p>
<p>Date Requested: <b>{{$loan->created_at}}</b></p>

{{-- @component('mail::button', ['url' => route("login")])
    Login
@endcomponent --}}

Thanks,<br>
Customer Care
@endcomponent
