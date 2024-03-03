@extends('users.admin.layout.app')
@section('title', 'All Orders')

@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/dropdown.css')}}">
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">All Orders</li>
@endsection

@section('content')    
    @if(session('update_order_status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('update_order_status')}}</strong> 
        </div>
    @endif
    
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $processingOrders = 0;
                $shippedOrders = 0;
                $deliveredOrders = 0;

                foreach($orders as $order){
                    if($order['order_status'] === 'processing'){
                        $processingOrders += 1;
                    }
                    if($order['order_status'] === 'shipped'){
                        $shippedOrders += 1;
                    }
                    if($order['order_status'] === 'delivered'){
                        $deliveredOrders += 1;
                    }



                }
            @endphp

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$processingOrders}}</h3>

                    <h6>Processing Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#processingOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
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
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$deliveredOrders}}</h3>

                    <h6>Delivered Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#deliveredOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.row -->


        <div class="row mb-3">
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
                                            <td class="localePrice">{{$pOrder['total_price']}}</td>
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
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shipped Orders <sup><span class="badge bg-info">{{$shippedOrders}}</span></sup></h3>
                        
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
                                            <td class="localePrice">{{$sOrder['total_price']}}</td>
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
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Delivered Orders <sup><span class="badge bg-success">{{$deliveredOrders}}</span></sup></h3>
                        
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
                        <table id="deliveredOrder" class="table table-bordered table-striped text-center">
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
                                // delivered order S/N
                                    $dosn = 0;
                                @endphp

                                @foreach ($orders as $dOrder)
                                    @if ($dOrder->order_status === 'delivered')
                                        <tr>
                                            <td>{{++$dosn}}</td>
                                            <td>{{$dOrder['customer_email']}}</td>
                                            <td>{{str_replace("****", ", ", $dOrder['order_products'])}}</td>
                                            <td>{{str_replace("****", ", ", $dOrder['order_products_quantity'])}}</td>
                                            <td class="localePrice">{{$dOrder['total_price']}}</td>
                                            <td>{{$dOrder['created_at']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.show', $dOrder['wefarm_tx_ref'])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-success">{{$dOrder['order_status']}}</button>
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
        </div>
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

  $(function () {
    $("#deliveredOrder").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#deliveredOrder_wrapper .col-md-6:eq(0)');
  });


</script>

@endsection
