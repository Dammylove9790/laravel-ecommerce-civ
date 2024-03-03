<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Product has been deleted</title>
</head>
<body>
    <h3>Dear {{ucfirst(strtolower($product->role))}} {{$product->user_name}},</h3>
    <p>Your product, <b>{{$product->name}}</b> has been deleted. If you think this is a mistake, kindly contact us.</p>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>
</body>
</html>