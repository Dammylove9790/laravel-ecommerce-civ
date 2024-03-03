<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Product {{$product->name}} is now live!</title>
</head>
<body>
    <h3>Dear {{ucfirst($product->role)}} {{$product->user_name}},</h3>
    <p>Your product <strong>{{$product->name}}</strong> is now live on our website. Find below your product details:</p>

    <ul class="list-group">
        <li class="list-group-item">Product Name: {{$product->name}}</li>
        <li class="list-group-item">Quantity: {{$product->quantity}}</li>
        <li class="list-group-item">Unit Price: <span>&#8358</span><span class="localePrice">{{$product->price}}</span>/{{$product->measurement}}</li>
        <li class="list-group-item">Expected Unit Price after sale: <span>&#8358</span><span class="localePrice">{{0.9*$product->price}}</span>/{{$product->measurement}}</li>
    </ul>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>

    <script>
        let locale_price = document.querySelectorAll(".localePrice");
        for(let loc = 0; loc < locale_price.length; loc++){
            locale_price[loc].innerHTML = Number(locale_price[loc].innerHTML).toLocaleString()
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>