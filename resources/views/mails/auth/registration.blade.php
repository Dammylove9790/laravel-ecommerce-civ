<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Successful</title>
</head>
<body>
    <h3>Welcome {{$user->name}},</h3>
    <p>Thank you for creating an account with us.</p>
    <p>Before you will be able to have access to your account, kindly check your email, <strong>{{$user->email}}</strong>, for instructions on how to verify your account.</p>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>
</body>
</html>