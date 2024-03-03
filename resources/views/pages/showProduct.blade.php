@extends('layouts.app')
@section('title', $product->name)
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
          <li class="breadcrumb-item"><a href="{{route('pages.products')}}">Our Products</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- ##### Breadcrumb Area End ##### -->

  <div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-4 px-5">
          <div class="row mb-2 justify-content-center">
            <img class="img-fluid" id="mainImage" src="{{asset('pictures/'.$product->picture->front_view)}}" alt="{{$product->name}}">
          </div>
          <div class="row justify-content-center">
            <img class="mx-2 smallImages" onclick="smallImage(this)" src="{{asset('pictures/'.$product->picture->front_view)}}" width="50px" height="35px" alt="{{$product->name}}">
            @if ($product->picture->back_view)
              <img class="mx-2 smallImages" onclick="smallImage(this)" src="{{asset('pictures/'.$product->picture->back_view)}}" width="50px" height="35px" alt="{{$product->name}}">
            @endif

            @if ($product->picture->left_view)
              <img class="mx-2 smallImages" onclick="smallImage(this)" src="{{asset('pictures/'.$product->picture->left_view)}}" width="50px" height="35px" alt="{{$product->name}}">
            @endif

            @if ($product->picture->right_view)
              <img class="mx-2 smallImages" onclick="smallImage(this)" src="{{asset('pictures/'.$product->picture->right_view)}}" width="50px" height="35px"  alt="{{$product->name}}">
            @endif

          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div>
            <p><b>Item Name:</b> <span>{{$product->name}}</span></p>
            <p><b>Available quantity:</b> <span id="availableQty">{{$product->quantity}}</span></p>
            <p><b>Price:</b> <span>&#8358</span><span id="itemPrice">{{$product->price}}/{{$product->measurement}}</span></p>
          </div>

          <form name="addCartBuy" class="row" action="{{route('order.single.review.post', $product->slug)}}" method="post">
            @method('post')
            @csrf

            <div class="col-12">
              <div class="row mb-3">
                <label for="qty" class="form-label col-3">Quantity:</label>
                <div class="col-12 col-sm-9 input-group">
                  <button class="btn btn-success" type="button" onclick="decreaseQty(this)">-</button>
                  <input type="number" name="qtyOrdered" class="form-control text-center" id="input" onchange="changeQty(this)" onkeyup="changeQty(this)" value="1">
                  <button class="btn btn-success" type="button" onclick="increaseQty(this)">+</button>
                  <input type="hidden" name="slug" value="{{$product->slug}}">
                </div>
              </div>
              <h6>Total price: <span>&#8358</span> <span id="itemTotalPrice">{{number_format($product->price, 2)}}</span></h6>
              
              
              <div class="row">
                <button id="addCartBtn" class="d-block col-5 btn btn-success">Add to Cart <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                <div class="col-2"></div>
                <button id="buyBtn" class="d-block col-5 btn btn-primary" type="submit">Buy now <i class="fa fa-credit-card" aria-hidden="true"></i></button>
              </div>
            </div>
          </form>
        </div>
        
    </div>
  </div>
  <div id="cartAlert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
    <strong id="cartMessage"></strong>
  </div>

@endsection

@section('js')
    <script src="{{asset('js/showProduct.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @include('pages.jsShowProduct')
@endsection
