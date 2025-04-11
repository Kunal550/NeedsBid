<body>

    @component('mail::message')

    # Hi {{$mail_arr['name']}},<br>
    <hr>
    {!! $mail_arr['txt'] !!}

    <hr>

    Thanks,<br>
    # {{ config('app.name') }}
    @endcomponent

</body>