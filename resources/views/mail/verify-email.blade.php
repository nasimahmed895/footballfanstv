<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $content->subject }}</title>
</head>

<body>
    <h4>
        Hello {{ $content->user->name }},
        <br>
        Email: {{ $content->user->email }},
    </h4>
    <br>
    <br>
    <p>
        Here is your one time password (OTP) to validate your email address!
    <h2>{{ decrypt($content->user->verification) }}</h2>
    <br>
    Don't share it with anyone!
    </p>
    <br>
    <br>
    Thank You,
    <br>
    {{ $content->app_name }}
</body>

</html>
