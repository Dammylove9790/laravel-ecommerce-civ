<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Approved</title>
</head>
<body>
    <h3>Dear {{ucfirst(strtolower($user->role))}} {{$user->name}},</h3>
    <p>Thank you for creating an account with us.</p>
    <p>This is to notify you that your account has been approved.</p>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>
</body>
</html>