<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PRICCADDO:: @yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/wefarm-nav.png')}}">
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

    <!-- animate.style CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

      <!-- fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('css')

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<body>

  <!-- Start of main navigation Bar  -->
  <div id="main_nav" class="main_nav">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        {{-- <div class="logo"> --}}
          <a class="navbar-brand" href="{{ route('pages.index') }}"> 
            <img src="{{ asset('img/logo2.png') }}" alt="" style="max-height: 80px;">
          </a>
        {{-- </div> --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav main mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('pages.index') }}"><i class="fa-solid fa-house-user me-1"></i>Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-cart-arrow-down me-1"></i>Shopping Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('pages.products') }}"><i class="fa-solid fa-basket-shopping me-1 "></i>Products</a>
            </li>

          </ul>


            <ul class="navbar-nav sub-main mb-2 mb-lg-0 mx-3">
              @guest
                  @if (Route::has('login'))
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-from-bracket me-1"></i>Login</a>
                    </li>    
                  @endif

                  @if (Route::has('register'))
                      <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="fa-solid fa-user-plus me-1"></i>Register</a>
                      </li>
                  @endif
                
              @else
              <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }}
                  </a>
                
                <ul class="dropdown-menu">
                  @php
                      $role = Auth::user()->role;
                      $dashboard = "";
                      if ($role === "admin") {
                        $dashboard = 'users.admin.dashboard';
                      } 
                      // elseif ($role === "farmer") {
                      //   $dashboard = 'users.farmer.dashboard'; 
                      // } elseif($role === "buyer"){
                      //   $dashboard = 'users.buyer.dashboard';
                      // } elseif($role === "logistics"){
                      //   $dashboard = 'users.logistics.dashboard';
                      // } 
                      else{
                        $dashboard = 'pages.index';
                      }
                  @endphp
                  @if ($role == 'admin')
                  <li class="dropdown-item">
                    <a href="{{ route($dashboard) }}">
                          {{ __('Dashboard') }}
                    </a>
                  </li>
                  @endif
                  <li class="dropdown-item">
                    <a href="#"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </li>
                </ul>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      
                  </div>
              </li>
              @endguest

            </ul>
  
          <div class="my_cart px-md-3">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-danger text-danger pr-4" onclick="">
              <i class="fas fa-cart-arrow-down me-1"></i>
              My Cart 
              <h5 class="cart-quantity" id="cart-qty">{{Cart::session('user')->getContent()->count()}}</h5>
            </a>
          </div>

          <!-- <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form> -->
        </div>
      </div>
    </nav>
  </div>
<!-- End of main navigation bar -->



          