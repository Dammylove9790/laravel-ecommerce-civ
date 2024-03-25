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
                <div class="row">
                    @if (count($product->size) > 0)
                    <div class="col-sm-6 col-md-3 mt-3">
                        <label for="size" class="font-bold">Size</label>
                        <select name="" id="size" class="form-control border-dark" style="font-size: 17px">
                            @foreach ($product->size as $size)
                            <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if (count($product->color) > 0)
                    <div class="col-sm-6 col-md-3 mt-3">
                        <label for="color" class="font-bold">Color</label>
                        <select name="" id="color" class="form-control border-dark" style="font-size: 17px">
                            @foreach ($product->color as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <h6>
            Total <span class="float-right"><span>&#8358</span>{{$total}}</span>
        </h6>
    </div>
    @php
        $message = "Hello, I want to buy:\n1) $qty quantity of $product->name - ";
        $message .= 'https://' . $_SERVER['HTTP_HOST'] .  "/products/" . $product->slug;

    @endphp
    <div class="row mt-3">
        <a href="javascript:void(0)" target="_blank" id="whatsappNow" class="d-block col btn btn-success text-white text-center p-2">Buy Now</a>
    </div>
  </div>
@endsection

@section('js')
    <script>

        let whatsappNow = document.getElementById('whatsappNow');

        whatsappNow.addEventListener('click', function () {
            let message = @json($message);
            let size = document.getElementById('size');
            let color = document.getElementById('color');

            if(size && color) {
                message += ` (Size: ${size.value} and Color: ${color.value})\n`;
            } else if(size) {
                message += ` (Size: ${size.value})\n`;
            } else if(color) {
                message += ` (Color: ${color.value})\n`;
            } else {
                message += '\n';
            }

            message = encodeURIComponent(message);
            let whatsappUrl = `https://wa.me/+22504099410?text=${message}`;

            whatsappNow.href = whatsappUrl;
        });

    </script>
@endsection


