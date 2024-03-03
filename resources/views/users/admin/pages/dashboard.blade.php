@extends('users.admin.layout.app')
@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/dropdown.css')}}">
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('success')}}</strong> 
        </div>
    @endif
    @if(session('unauthorized'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('unauthorized')}}</strong> 
        </div>
    @endif
    
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $totalAdmin = 0;
                $totalFarmer = 0;
                $totalBuyer = 0;
                $totalLogistics = 0;
                $totalPendingUsers = 0;
                $processingOrders = 0;
                $shippedOrders = 0;

                foreach($users as $user){
                    if($user['role'] === 'admin'){
                        $totalAdmin += 1;
                    }
                    if($user['role'] === 'farmer'){
                        $totalFarmer += 1;
                    }
                    if($user['role'] === 'buyer'){
                        $totalBuyer += 1;
                    }
                    if($user['role'] === 'logistics'){
                        $totalLogistics += 1;
                    }
                    if($user['status'] === 'pending'){
                        $totalPendingUsers += 1;
                    }
                }

                foreach($orders as $order){
                    if($order['order_status'] === 'processing'){
                        $processingOrders += 1;
                    }
                    if($order['order_status'] === 'shipped'){
                        $shippedOrders += 1;
                    }

                }
            @endphp
            {{-- <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$totalAdmin}}</h3>

                    <h6>Admin</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('users.admin.manageAdmin')}}#approvedAdmin" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->

            {{-- <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$totalFarmer}}</h3>

                    <h6>Farmers</h5>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('users.admin.manageFarmer')}}#approvedFarmer" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$totalBuyer}}</h3>

                    <h6>Buyers</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('users.admin.manageBuyer')}}#approvedBuyer" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            {{-- <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                    <h3>{{$totalLogistics}}</h3>

                    <h6>Logistic Companies</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('users.admin.manageLogistics')}}#approvedLogistics" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->

            {{-- <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$processingOrders}}</h3>

                    <h6>Processing Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#processingOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->

            {{-- <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$shippedOrders}}</h3>

                    <h6>Shipped Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#shippedOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending users <sup><span class="badge bg-danger">{{$totalPendingUsers}}</span></sup></h3>
                        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="pendingUser" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Names</th>
                                    <th>Email</th>
                                    <th>Email verified</th>
                                    <th>Role</th>
                                    <th>Registration date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                    $pusn = 0;
                                @endphp

                                @foreach ($users as $user)
                                    @if ($user->status === 'pending')
                                        <tr>
                                            <td>{{++$pusn}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->email_verified_at ? "Yes" : "No"}}</td>
                                            <td class="text-capitalize">{{$user->role}}</td>
                                            <td>{{$user->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.showUser', $user->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.pendinguser.accept', $user->slug)}}" method="POST">
                                                            @method('put')
                                                            @csrf
                                                            <button title="Accept" type="submit" class="btn btn-success mx-lg-2">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.deleteUser', $user->slug)}}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button title="Reject and Delete" type="submit" class="btn btn-danger">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                    {{-- <button title="Delete" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$pusn}}">
                                                    <i class="fas fa-trash"></i>
                                                </button> --}}
                                                {{-- <div class="modal fade" id="deleteModal{{$pusn}}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Post Title: {{$pusn}}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this post? This action cannot be undone.
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <form action="" method="POST">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <input type="hidden" name="picture_id" value="{{$user->slug}}">
                                                                    <button title="Delete" type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </td> 
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Names</th>
                                    <th>Email</th>
                                    <th>Email verified</th>
                                    <th>Role</th>
                                    <th>Registration date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


        {{-- <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @php
                            $pendingProduct = 0;
                            foreach ($products as $product){
                                if ($product['status'] === 'pending'){
                                    $pendingProduct += 1;
                                }
                            }
                        @endphp
                        <h3 class="card-title">Pending products <sup><span class="badge bg-danger">{{$pendingProduct}}</span></sup></h3>
                        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="pendingProduct" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Quantity</th>
                                    <th>Front view</th>
                                    <th>Date Uploaded</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // pending product S/N
                                    $ppsn = 0;
                                @endphp

                                @foreach ($products as $product)
                                    @if ($product->status === 'pending')
                                        @php
                                            $img = $product['picture']['front_view'];
                                        @endphp
                                        <tr>
                                            <td>{{++$ppsn}}</td>
                                            <td>{{$product->added_by}}</td>
                                            <td>{{ucfirst($product->role)}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->quantity}}</td>
                                            <td><img class="" src="{{asset('pictures/'.$img)}}" style='max-height:100px' alt="{{$product->name}}"></td>
                                            <td>{{$product->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.products.show', $product->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.products.accept', $product->slug)}}" method="POST">
                                                            @method('put')
                                                            @csrf
                                                            <button title="Accept" type="submit" class="btn btn-success mx-lg-2">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.products.delete', $product->slug)}}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button title="Reject and Delete" type="submit" class="btn btn-danger">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                    {{-- <button title="Delete" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$pusn}}">
                                                    <i class="fas fa-trash"></i>
                                                </button> --}}
                                                {{-- <div class="modal fade" id="deleteModal{{$pusn}}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Post Title: {{$pusn}}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this post? This action cannot be undone.
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <form action="" method="POST">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <input type="hidden" name="picture_id" value="{{$product->slug}}">
                                                                    <button title="Delete" type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </td> 
                                        </tr>
                                    {{-- @endif --}}
                                {{-- @endforeach --}}
                            {{-- </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Quantity</th>
                                    <th>Front view</th>
                                    <th>Date Uploaded</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div> --}}
        <!-- /.row -->

        {{-- <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Processing Orders <sup><span class="badge bg-warning">{{$processingOrders}}</span></sup></h3>
                        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="processingOrder" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Buyer</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date Ordered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // processing order S/N
                                    $posn = 0;
                                @endphp

                                @foreach ($orders as $pOrder)
                                    @if ($pOrder->order_status === 'processing')
                                        <tr>
                                            <td>{{++$posn}}</td>
                                            <td>{{$pOrder['customer_email']}}</td>
                                            <td>{{str_replace("****", ", ", $pOrder['order_products'])}}</td>
                                            <td>{{str_replace("****", ", ", $pOrder['order_products_quantity'])}}</td>
                                            <td>{{$pOrder['total_price']}}</td>
                                            <td>{{$pOrder['created_at']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.show', $pOrder['wefarm_tx_ref'])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-warning">{{$pOrder['order_status']}}</button>
                                                <div class="my-dropdown">
                                                    <button class="my-dropbtn">Update Order Status</button>
                                                    <div class="my-dropdown-content">
                                                        <form class="my-2" action="{{route('users.admin.orders.update_status', $pOrder['wefarm_tx_ref'])}}" method="POST">
                                                                @method('put')
                                                                @csrf
                                                                <button title="Processing" type="submit" name="update_order_status" value="processing" class="btn btn-warning mx-lg-2">
                                                                    Processing
                                                                </button>
                                                        </form>
                                                        <form class="my-2" action="{{route('users.admin.orders.update_status', $pOrder['wefarm_tx_ref'])}}" method="POST">
                                                                @method('put')
                                                                @csrf
                                                                <button title="Shipped" type="submit" name="update_order_status" value="shipped" class="btn btn-info mx-lg-2">
                                                                    Shipped
                                                                </button>
                                                        </form>
                                                        <form class="my-2" action="{{route('users.admin.orders.update_status', $pOrder['wefarm_tx_ref'])}}" method="POST">
                                                                @method('put')
                                                                @csrf
                                                                <button title="Delivered" type="submit" name="update_order_status" value="delivered" class="btn btn-success mx-lg-2">
                                                                    Delivered
                                                                </button>
                                                        </form>
                                                    </div>
                                                </div>                    
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Buyer</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date Ordered</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div> --}}
        <!-- /.row -->

        {{-- <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shipped Orders <sup><span class="badge bg-success">{{$shippedOrders}}</span></sup></h3>
                        
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="shippedOrder" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Buyer</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date Ordered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // shipped order S/N
                                    $sosn = 0;
                                @endphp

                                @foreach ($orders as $sOrder)
                                    @if ($sOrder->order_status === 'shipped')
                                        <tr>
                                            <td>{{++$sosn}}</td>
                                            <td>{{$sOrder['customer_email']}}</td>
                                            <td>{{str_replace("****", ", ", $sOrder['order_products'])}}</td>
                                            <td>{{str_replace("****", ", ", $sOrder['order_products_quantity'])}}</td>
                                            <td>{{$sOrder['total_price']}}</td>
                                            <td>{{$sOrder['created_at']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.show', $sOrder['wefarm_tx_ref'])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-info">{{$sOrder['order_status']}}</button>
                                                <div class="my-dropdown">
                                                    <button class="my-dropbtn">Update Order Status</button>
                                                    <div class="my-dropdown-content">
                                                        <form class="my-2" action="{{route('users.admin.orders.update_status', $sOrder['wefarm_tx_ref'])}}" method="POST">
                                                                @method('put')
                                                                @csrf
                                                                <button title="Processing" type="submit" name="update_order_status" value="processing" class="btn btn-warning mx-lg-2">
                                                                    Processing
                                                                </button>
                                                        </form>
                                                        <form class="my-2" action="{{route('users.admin.orders.update_status', $sOrder['wefarm_tx_ref'])}}" method="POST">
                                                                @method('put')
                                                                @csrf
                                                                <button title="Shipped" type="submit" name="update_order_status" value="shipped" class="btn btn-info mx-lg-2">
                                                                    Shipped
                                                                </button>
                                                        </form>
                                                        <form class="my-2" action="{{route('users.admin.orders.update_status', $sOrder['wefarm_tx_ref'])}}" method="POST">
                                                                @method('put')
                                                                @csrf
                                                                <button title="Delivered" type="submit" name="update_order_status" value="delivered" class="btn btn-success mx-lg-2">
                                                                    Delivered
                                                                </button>
                                                        </form>
                                                    </div>
                                                </div>                    

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Buyer</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date Ordered</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div> --}}
        <!-- /.row -->
        @endif
    </div>
    <!-- /.container-fluid -->
  
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#pendingUser").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#pendingUser_wrapper .col-md-6:eq(0)');
  });

    $(function () {
    $("#pendingProduct").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#pendingProduct_wrapper .col-md-6:eq(0)');
  });

    $(function () {
    $("#processingOrder").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#processingOrder_wrapper .col-md-6:eq(0)');
  });

    $(function () {
    $("#shippedOrder").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#shippedOrder_wrapper .col-md-6:eq(0)');
  });


</script>
@endsection
