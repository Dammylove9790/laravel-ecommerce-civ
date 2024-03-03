<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$restore->item}} Restored Sucessfully</title>
</head>
<body>
    <h3>Dear {{ucfirst(strtolower($restore->role))}}
        @if ($restore->item === "account")
            {{$restore->name}},
        @endif 

        @if ($restore->item === "product")
            {{(explode("/", $restore->added_by))[0]}},
        @endif
    </h3>
    <p>Your {{$restore->item}}
        @if ($restore->item === "product") <b>{{$restore->name}}</b> @endif
        has been restored successfully.</p>
    <p>
        Regards,<br>
        <a href="{{route('pages.index')}}" style="text-decoration: none">Wefarm</a>
    </p>
</body>
</html>