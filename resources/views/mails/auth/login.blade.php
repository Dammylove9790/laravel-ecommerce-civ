<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Successful</title>
</head>
<body>
    <h3>Dear {{ucfirst(strtolower($user->role))}} {{$user->name}},</h3>
    <p>This is to notify you that your account was accessed on {{date("Y-m-d h:i:sa")}}</p>
    <p>If you did not make this request, kindly change your password or reach out to us immediately.</p>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Priccado Shop</a>
    </p>
</body>
</html>