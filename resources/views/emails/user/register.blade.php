@component('mail::message')
Hey {{ $name }},

You have been registered as a user on the MaiHomm system. Your login details are as follows:


<b>Email</b>: {{ $email }} <br>
<b>Password</b>: {{ $password }}

@component('mail::button', ['url' => route("login")])
    Login
@endcomponent

Thanks,<br>
Customer Care
@endcomponent
