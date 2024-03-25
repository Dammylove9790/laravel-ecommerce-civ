<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PRICCADDO:: Admin - @yield('title')</title>

  <!-- Favicon -->
    <link rel="icon" href="{{asset('img/logo2.png')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Bootstrap -->
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('users.admin.dashboard')}}" class="nav-link">Dashboard</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('pages.index')}}" class="nav-link">Customer Home</a>
      </li>
    </ul>

  </nav>
  <!-- /.navbar -->

   <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('pages.index')}}" class="brand-link px-3">
      {{-- <img src="{{asset('img/logo2.png')}}" alt="Priccaddo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Priccaddo</span> --}}
      <img src="{{ asset('img/logo2.png') }}" alt="" class="img-fluid " {{-- style="max-height: 70px;" --}}>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        {{-- <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
          <a href="{{route('users.admin.dashboard')}}" class="d-block">{{Auth::user()->name}} - {{ucfirst(Auth::user()->role)}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('users.admin.dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="{{route('users.admin.registerUser')}}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Register User
              </p>
            </a>
          </li> --}}

          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- <li class="nav-item">
                <a href="{{route('users.admin.manageAdmin')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('users.admin.manageFarmer')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Farmer</p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{route('users.admin.manageBuyer')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buyer</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{route('users.admin.manageLogistics')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logistics</p>
                </a>
              </li> --}}

            </ul>
          </li>

          <li class="nav-item">
            <a href="{{route('users.admin.category')}}" class="nav-link">
              <i class="nav-icon fas fa-cookie-bite"></i>
              <p>
                Categories
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('users.admin.size')}}" class="nav-link">
              <i class="nav-icon fas fa-cookie-bite"></i>
              <p>
                Size
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('users.admin.color')}}" class="nav-link">
              <i class="nav-icon fas fa-cookie-bite"></i>
              <p>
                Color
              </p>
            </a>
          </li>


           <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link">
              <i class="nav-icon fas fa-cookie-bite"></i>
              <p>
                Product
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('users.admin.products.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('users.admin.products')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Products</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('pages.products')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Product</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('users.admin.orders')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Orders</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('users.admin.orders.wefarm_product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Wefarm Product Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('users.admin.orders.farmer_product')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Farmer Product Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('users.admin.orders.self')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Wefarm Orders</p>
                </a>
              </li>

            </ul>
          </li> --}}

          {{-- <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link">
              <i class="nav-icon far fa-credit-card"></i>
              <p>
                Income
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('users.admin.income')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Wefarm Product Income</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('users.admin.charges')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Charges Income</p>
                </a>
              </li>
            </ul>
          </li> --}}

          <li class="nav-item">
            <a href="{{route('users.admin.bin')}}" class="nav-link">
              <i class="nav-icon fas fa-trash"></i>
              <p>
                Recycle Bin
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('users.admin.account')}}" class="nav-link">
              <i class="fas fa-user nav-icon"></i>
              <p>My Account</p>
            </a>
          </li>


          <li class="nav-item">
              <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

