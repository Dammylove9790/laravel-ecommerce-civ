<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order {{$order_details->wefarm_tx_ref}} has been received</title>
</head>
<body>
    <h3>Dear {{$order_details->buyer_name}},</h3>
    <p>Your order {{$order_details->wefarm_tx_ref}} has been received and is currently being processed. You will receive an email once your order has been shipped.</p>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>
</body>
</html>