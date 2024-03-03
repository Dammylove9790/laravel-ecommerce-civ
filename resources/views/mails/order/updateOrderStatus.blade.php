<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update on your order {{$order->wefarm_tx_ref}}</title>
</head>
<body>
    <h3>Dear {{$order->buyer_name}},</h3>
    @if($order->order_status === 'processing')
        <p>Your order {{$order->wefarm_tx_ref}} has been received and is currently being processed. You will receive an email once your order has been shipped.</p>
    @endif
     @if($order->order_status === 'shipped')
        <p>Your order {{$order->wefarm_tx_ref}} has been shipped and is currently on its way to your address.</p>
    @endif
     @if($order->order_status === 'delivered')
        <p>Your order {{$order->wefarm_tx_ref}} has been delivered successfully.</p>
    @endif
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>
</body>
</html>