@extends('layouts.app')
@section('title', 'My Cart')
@section('css')
  <link rel="stylesheet" href="{{asset('css/pages/cartMessage.css')}}">
@endsection

@section('content')
    <!-- ##### Breadcrumb Area Start ##### -->
  <div class="famie-breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('pages.index')}}"><i class="fa fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- ##### Breadcrumb Area End ##### -->

  <div class="container mb-5">
    <div class="row justify-content-center" id="allCartItems">
        @if (count($cartContent) === 0)
            <p>You have no product in your cart.</p>
        @else
            @foreach ($cartContent as $eachCartContent)
                @php
                    $img = $eachCartContent->associatedModel->picture->front_view;
                    $model = $eachCartContent->associatedModel;
                @endphp
                <div class="col-sm-3 text-center mb-4">
                  <div><a href="{{route('pages.products.show', $model->slug)}}"><img src="{{asset('pictures/'.$img)}}" class="img-fluid" alt="{{$eachCartContent->name}}"></a></div>
                  <p><a href="{{route('pages.products.show', $model->slug)}}">{{$eachCartContent->name}}</a></p>
       
                  {{-- get the available quantity of the product --}}
                  @foreach ($products as $product)
                    @if ($product->name === $eachCartContent->name)
                      @php
                        $availableQty = $product->quantity;
                      @endphp
                    @endif
                  @endforeach

                  {{-- get already ordered product for the items --}}
                    @if (array_key_exists($eachCartContent->name, $orderWithQuantity))
                      @php
                        $alreadyOrderedItem = $orderWithQuantity[$eachCartContent->name];
                      @endphp
                    @else
                      @php
                        $alreadyOrderedItem = 0;
                      @endphp
                    @endif
                  <div class="text-right">{{$availableQty + $alreadyOrderedItem}}</div>
                  <div class="progress mb-3" style="height:25px">
                    <div class="progress-bar bg-success"
                     style="width:{{($availableQty/($availableQty + $alreadyOrderedItem)) * 100}}%; height:25px">
                      {{$availableQty}} remaining
                    </div>
                    <div class="progress-bar bg-danger"
                     style="width:{{($alreadyOrderedItem/($availableQty + $alreadyOrderedItem)) * 100}}%; height:25px">
                      {{$alreadyOrderedItem}} ordered
                    </div>
                  </div>

                  <input type="hidden" name="availabeQty" class="availableQty" value="{{$availableQty}}">
                  <div class="input-group">
                    <button class="btn btn-success" type="button" onclick="decreaseQty(this)">-</button>
                    <input type="number" class="form-control text-center inputs" onchange="changeQty(this)" onkeyup="changeQty(this)" value="{{$eachCartContent->quantity}}">
                    <button class="btn btn-success" type="button" onclick="increaseQty(this)">+</button>
                    <input type="hidden" name="slug" value="{{$model->slug}}">
                  </div>
                  <p>Price: <span>&#8358</span><span>{{$eachCartContent->price}}</span></p>
                  <p>Total Price: <span>&#8358</span><span class="totalPrice">{{$eachCartContent->price * $eachCartContent->quantity}}</span></p>
                  <button class="btn btn-danger" onclick="removeItem(this)" value="{{$model->slug}}">Remove</button>
                </div>            
            @endforeach
        @endif    
    </div>

    @if ($getTotal > 0)
      <button id="clearCart" class="btn btn-danger" onclick="clearCart()">Clear Cart</button>

      <div class="row mt-3" id="checkout">
        <button id="checkout_btn" class="d-block col btn btn-success text-white text-center p-2">CHECKOUT <span>&#8358</span><span id="cartTotalPrice"></span></button>
      </div>
      {{-- <form action="{{route('order.review')}}" class="row mt-3" id="checkout">
        @method('post')
        @csrf
        <button type="submit" class="d-block col btn btn-success text-white text-center p-2">CHECKOUT <span>&#8358</span><span id="cartTotalPrice"></span></button>
      </form> --}}

    @endif
  </div>

@endsection

@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @include('pages.cart.jsCart')
@endsection
