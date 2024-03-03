@extends('layouts.app')
@section('title', 'Review Order')

@section('content')
    <!-- ##### Breadcrumb Area Start ##### -->
  <div class="famie-breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('pages.index')}}"><i class="fa fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Review Order</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- ##### Breadcrumb Area End ##### -->

  <div class="container mb-5">
    <div class="card">
        <div class="card-header">ORDER SUMMARY</div>
        <div class="card-body">
            @php
                $i = 0;
                $cartLength = count($cartContent);
                $message = "Hello, I want to buy:\n";
            @endphp
            @foreach ($cartContent as $content)
                @php
                    $totalItemPrice = $content->price * $content->quantity;
                    $message .= "$content->quantity quantity of $content->name - ";
                    $message .= 'https://' . $_SERVER['HTTP_HOST'] .  "/products/" . $content->associatedModel->slug . "\n";
                @endphp
                <div>
                    <h6>Order {{++$i}} of {{$cartLength}}</h6>
                    <div>
                        <span class="mr-3">{{$content->quantity}}x</span>
                        <span>{{$content->name}}</span>
                    </div>
                    <div>Unit Price: <span>&#8358</span>{{$content->price}}</div>
                    <div>Total Item Price: <span>&#8358</span>{{$totalItemPrice}}</div>
                    @if ($i != $cartLength)
                        <hr>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-2">
        <h6>
            Total <span class="float-right"><span>&#8358</span>{{$cartTotal}}</span>
        </h6>
    </div>
    @php
        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/+22504099410?text=$encodedMessage";
    @endphp

    <div class="row mt-3">
        <a href="{{ $whatsappUrl }}" target="_blank" class="d-block col btn btn-success text-white text-center p-2">Buy Now</a>
    </div>
  </div>
@endsection
