@extends('layouts.app')
@section('title', 'Our Products')
    
@section('css')
<link rel="stylesheet" href="{{asset('css/pages/cartMessage.css')}}">
@endsection

@section('content')

@include('header')


  <div class="famie-breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('pages.index')}}"><i class="fa fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Our Products</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- ##### Breadcrumb Area End ##### -->

  <div class="all-products-page-container">
    <div class="products-category-filter">
        <p class="filter-title mt-lg-5"> Categories </p>
          <ul>
            <form action="{{route('pages.searchProductCategory')}}" method="get">
              @foreach ($categories as $category)
                <li><input type="submit" class="mb-2 border-0 text-start " name="category" value="{{$category->name}}"></li>
              @endforeach
            </form>
          </ul>
    </div>

    <div class="all-product-wrapper ">
        <div id="all-products" class="container-fluid page-content">

          <p class="container-title all-products-title ">All Products</p>
      
          {{-- <div class="float-left mr-2">
            {{ $products->links() }}
          </div> --}}
  
          <div class="all-products " style="clear: both;">

            @foreach ($products as $product)
            {{-- <div class="product-page-wrapper border border-3 border-primary "> --}}
            <div class="product-page-wrapper col-lg-3 col-md-4 col-sm-6 px-lg-2 px-md-1 px-sm-2 my-4 rounded">
              <div class="product bg-white ">
                <a href="{{route('pages.products.show', $product->slug)}}">
                  <img class="rounded-top" src="{{asset('pictures/'.$product->picture->front_view)}}" alt="{{$product->name}}" alt="">
                </a>
                
                <div class="product-info ">
                  <p class="product-name m-0 p-0 "> {{ $product->name }} </p>
                  <!-- <p class="product-description">its very nice</p> -->
                  <label for="">
                    <span class="currency-symbol product-price">&#8358 {{ number_format($product->price, 2  ) }}</span>
                  </label>
            
                </div>
          
                <div class="product-button justify-content-sm-start ">
                  <form action="{{route('order.single.review.post', $product->slug)}}" method="post">
                    @method('post')
                    @csrf
                    <input type="hidden" name="qtyOrdered" value="1">
                    <button type="submit" class="mr-sm-2">Buy now <i class="fa fa-credit-card" aria-hidden="true"></i></button>
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
          </div>

            <div class="float-right mr-2">
              {{ $products->links() }}
            </div>
       
        </div>
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
