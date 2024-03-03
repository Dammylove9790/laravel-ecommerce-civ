@extends('users.buyer.layout.app')
@section('title', 'Dashboard')

@section('css')
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $processingOrder = 0;
                $shippedOrder = 0;
                $deliveredOrder = 0;

                foreach($orders as $order){
                    if($order['order_status'] === 'processing'){
                        $processingOrder += 1;
                    }
                    if($order['order_status'] === 'shipped'){
                        $shippedOrder += 1;
                    }

                    if($order['order_status'] === 'delivered'){
                        $deliveredOrder += 1;
                    }
                }
                $totalOrder = count($orders);

            @endphp
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                    <h3>{{$totalOrder}}</h3>

                    <h6>Total orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$deliveredOrder}}</h3>

                    <h6>Delivered orders</h5>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('users.buyer.orders')}}#deliveredOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$processingOrder}}</h3>

                    <h6>Processing orders</h5>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#processingOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->



            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$shippedOrder}}</h3>

                    <h6>Shipped orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#shippedOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Processing orders <sup><span class="badge bg-warning">{{$processingOrder}}</span></sup></h3>
                        
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
                                            <td>{{str_replace("****", ", ", $pOrder->order_products)}}</td>
                                            <td>{{str_replace("****", ", ", $pOrder->order_products_quantity)}}</td>
                                            <td class="localePrice">{{$pOrder->total_price}}</td>
                                            <td>{{$pOrder->created_at}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.buyer.orders.show', $pOrder->wefarm_tx_ref)}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-warning">{{$pOrder->order_status}}</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
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
                        <h3 class="card-title">Shipped orders <sup><span class="badge bg-info">{{$shippedOrder}}</span></sup></h3>
                        
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
                                            <td>{{str_replace("****", ", ", $sOrder->order_products)}}</td>
                                            <td>{{str_replace("****", ", ", $sOrder->order_products_quantity)}}</td>
                                            <td class="localePrice">{{$sOrder->total_price}}</td>
                                            <td>{{$sOrder->created_at}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.buyer.orders.show', $sOrder->wefarm_tx_ref)}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-info">{{$sOrder->order_status}}</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
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

        $("#shippedOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#shippedOrder_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
