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
                $items = [];
            @endphp
            @foreach ($cartContent as $index => $content)
                @php
                    $message = "";
                    $totalItemPrice = $content->price * $content->quantity;
                    $message .= ++$index . ") $content->quantity quantity of $content->name - ";
                    $message .= 'https://' . $_SERVER['HTTP_HOST'] .  "/products/" . $content->associatedModel->slug ;
                    $items[] = $message;
                @endphp
                <div class="cartItems">
                    <h6>Order {{++$i}} of {{$cartLength}}</h6>
                    <div>
                        <span class="mr-3">{{$content->quantity}}x</span>
                        <span>{{$content->name}}</span>
                    </div>
                    <div>Unit Price: <span>&#8358</span>{{$content->price}}</div>
                    <div>Total Item Price: <span>&#8358</span>{{$totalItemPrice}}</div>
                    <div class="row">
                        @if (count($content->size) > 0)
                        <div class="col-sm-6 col-md-3 mt-3">
                            <label for="size{{ $i }}" class="font-bold">Size</label>
                            <select name="" id="size{{ $i }}" class="form-control border-dark size" style="font-size: 17px">
                                @foreach ($content->size as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if (count($content->color) > 0)
                        <div class="col-sm-6 col-md-3 mt-3">
                            <label for="color{{ $i }}" class="font-bold">Color</label>
                            <select name="" id="color{{ $i }}" class="form-control border-dark color" style="font-size: 17px">
                                @foreach ($content->color as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
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
    <div class="row mt-3">
        <a href="javacript:void(0)" target="_blank" id="whatsappNow" class="d-block col btn btn-success text-white text-center p-2">Buy Now</a>
    </div>
  </div>
@endsection

@section('js')
    <script>


        let whatsappNow = document.getElementById('whatsappNow');

        let cartItems = document.querySelectorAll('.cartItems');

        let i = 0;
        whatsappNow.addEventListener('click', function () {
            let message = "Hello, I want to buy:\n";
            let items = @json($items);
            cartItems.forEach((value, index) => {
            i = ++index;
            var size = value.querySelector(`#size${i}`);
            var color = value.querySelector(`#color${i}`);

            if(size && color) {
                items[index - 1] += ` (Size: ${size.value} and Color: ${color.value})`;
            } else if(size) {
                items[index - 1] += ` (Size: ${size.value})`;
            } else if(color) {
                items[index - 1] += ` (Color: ${color.value})`;
            } else {
                items[index - 1] += '';
            }
        })

        message += items.join('\n');

        message = encodeURIComponent(message);
        let whatsappUrl = `https://wa.me/+22504099410?text=${message}`;

        whatsappNow.href = whatsappUrl;
        });

    </script>
@endsection

