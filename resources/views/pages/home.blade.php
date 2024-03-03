@extends('layouts.app')
@section('title', 'Home')

@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/cartMessage.css')}}">
@endsection

@section('content')

@include('header')


{{-- <div class="available-product-container">
  <div id="available-products" class="container-fluid available-products page-content">

    <p class="container-title available-products-title">Available Products</p>

    @foreach ($products as $product)
    <div class="col-lg-2 col-md-3 col-sm-4 col-6 px-2 my-4 rounded">
      <div class="product bg-white ">
        <a href="{{route('pages.products.show', $product->slug)}}">
          <img class="rounded-top" src="{{asset('pictures/'.$product->picture->front_view)}}" alt="{{$product->name}}" alt="">
        </a>
        
        <div class="product-info ">
        <p class="product-name m-0 p-0 "> {{ $product->name }} </p>
        <label for="">
          <span class="currency-symbol product-price">&#8358 {{ number_format($product->price, 2  ) }}</span>
        </label>
  
        </div>
  
        <div class="product-button">
          <form action="{{route('order.single.review.post', $product->slug)}}" method="post">
            @method('post')
            @csrf
            <input type="hidden" name="qtyOrdered" value="1">
            <button class="btn btn-primary" type="submit">Buy now <i class="fa fa-credit-card" aria-hidden="true"></i></button>
          </form>

          <form name="addCart{{$product->id}}" action="{{route('cart.add')}}" method="post" class="addCart">
            @method('post')
            @csrf
            <input type="hidden" name="productSlug" value="{{$product->slug}}">
            <button type="submit">Add to Cart <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
          </form>

        </div>
      </div>  
    </div>
    @endforeach

  </div>

  <p class="view-all-product text-center mt-5">
    <a href="{{ route('pages.products') }}" class="btn btn-outline-warning btn-dark">View all products >>> </a>
  </p>
  
</div> --}}

<div class="container-fluid d-flex  justify-content-center ">

  <div class="product-container col d-flex flex-wrap px-0 mx-0 ">
    <p class="w-100 container-title mt-5 mb-lg-5 mb-md-4 mb-sm-3 mb-3 text-center">Available Products</p>


    @foreach ($products as $product)
    <div class="col-lg-2 col-md-3 col-sm-4 col-6 px-2 mb-lg-4 mb-sm-3 mb-2 rounded">
      <div class="product bg-white ">
        <a href="{{route('pages.products.show', $product->slug)}}">
          <img class="rounded-top" src="{{asset('pictures/'.$product->picture->front_view)}}" alt="{{$product->name}}" alt="">
        </a>
        
        <div class="product-info px-lg-2 px-1 pt-3 pb-lg-3 pb-2">
          <p class="product-name m-0 p-0 "> {{ $product->name }} </p>
          <!-- <p class="product-description">its very nice</p> -->
          <label for="">
            <span class="currency-symbol product-price">&#8358 {{ number_format($product->price, 2  ) }}</span>
          </label>
        </div>
  
        <div class="product-button px-lg-2 px-1 ">
          <form action="{{route('order.single.review.post', $product->slug)}}" method="post">
            @method('post')
            @csrf
            <input type="hidden" name="qtyOrdered" value="1">
            <button class="btn btn-primary" type="submit">Buy now <i class="fa fa-credit-card" aria-hidden="true"></i></button>
          </form>

          {{-- <button class="" onclick="shareOnWhatsApp(this)">Whatsapp Buy</button> --}}
          <form name="addCart{{$product->id}}" action="{{route('cart.add')}}" method="post" class="addCart">
            @method('post')
            @csrf
            <input type="hidden" name="productSlug" value="{{$product->slug}}">
            <button type="submit">Add to Cart <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
          </form>

        </div>
      </div>  
    </div>
    @endforeach

    <p class="w-100 text-center my-5">
      <a href="{{ route('pages.products') }}" class="btn btn-dark">View all products >>> </a>
    </p>
  </div>

</div>



  <div id="cartAlert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
    <strong id="cartMessage"></strong>
  </div>


@endsection

@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @include('pages.cart.jsAddCart')
@endsection

