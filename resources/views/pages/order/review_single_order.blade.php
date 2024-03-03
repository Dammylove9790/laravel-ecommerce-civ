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
            <div>
                @if(session('qty'))
                    @php
                        $qty = session('qty');
                    @endphp
                @else
                    @php
                        $qty = 1;
                    @endphp      
                @endif

                @php
                    $total = $qty * $product->price;
                @endphp
                <h6>Order 1 of 1</h6>
                <div>
                    <span class="mr-3"><span id="qtyOrdered">{{$qty}}</span>x</span>
                    <span>{{$product->name}}</span>
                </div>
                <div>Unit Price: <span>&#8358</span>{{$product->price}}</div>
                <div>Total Item Price: <span>&#8358</span>{{$total}}</div>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <h6>
            Total <span class="float-right"><span>&#8358</span>{{$total}}</span>
        </h6>
    </div>
    @php
        $message = "Hello, I want to buy:\n$qty quantity of $product->name - ";
        $message .= 'https://' . $_SERVER['HTTP_HOST'] .  "/products/" . $product->slug . "\n";

        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/+22504099410?text=$encodedMessage";
    @endphp
    <div class="row mt-3">
        <a href="{{ $whatsappUrl }}" target="_blank" class="d-block col btn btn-success text-white text-center p-2">Buy Now</a>
    </div>
  </div>
@endsection


