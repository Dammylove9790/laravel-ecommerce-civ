@extends('users.admin.layout.app')
@section('title', 'Wefarm Buyer Orders')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Wefarm Buyer Orders</li>
@endsection

@section('content') 
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $processingBuyerOrder = 0;
                $shippedBuyerOrder = 0;
                $deliveredBuyerOrder = 0;
                $totalBuyerOrder = count($buyerOrders);

                foreach($buyerOrders as $buyerOrder){
                    if($buyerOrder['status'] === 'processing'){
                        $processingBuyerOrder += 1;
                    }
                    if($buyerOrder['status'] === 'shipped'){
                        $shippedBuyerOrder += 1;
                    }
                    if($buyerOrder['status'] === 'delivered'){
                        $deliveredBuyerOrder += 1;
                    }
                }
            @endphp
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                    <h3>{{$totalBuyerOrder}}</h3>

                    <h6>Total Wefarm Buyer Orders</h6>
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
                    <h3>{{$deliveredBuyerOrder}}</h3>

                    <h6>Delivered Wefarm Buyer Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#deliveredBuyerOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$shippedBuyerOrder}}</h3>

                    <h6>Shipped Wefarm Buyer Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#shippedBuyerOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->


            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$processingBuyerOrder}}</h3>

                    <h6>Processing Wefarm Buyer Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#processingBuyerOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Processing Wefarm Buyer orders <sup><span class="badge bg-warning">{{$processingBuyerOrder}}</span></sup></h3>
                        
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
                        <table id="processingBuyerOrder" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Buyer</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // processing order S/N
                                    $posn = 0;
                                @endphp

                                @foreach ($buyerOrders as $pBuyerOrder)
                                    @if ($pBuyerOrder['status'] === 'processing')
                                        <tr>
                                            <td>{{++$posn}}</td>
                                            <td>{{$pBuyerOrder['admin']}}</td>
                                            <td>{{$pBuyerOrder['name']}}</td>
                                            <td>{{$pBuyerOrder['quantity']}}</td>
                                            <td class="localePrice">{{$pBuyerOrder['total_price']}}</td>
                                            <td>{{$pBuyerOrder['buyer']}}</td>
                                            <td>{{$pBuyerOrder['date']}}</td>
                                            <td>{{$pBuyerOrder['wefarm_tx_ref']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.wefarm_product.show', ['id' => $pBuyerOrder['wefarm_tx_ref'], 'slug' => $pBuyerOrder['slug']])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-warning">{{$pBuyerOrder['status']}}</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Buyer</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
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
                        <h3 class="card-title">Shipped Wefarm Buyer Order <sup><span class="badge bg-info">{{$shippedBuyerOrder}}</span></sup></h3>
                        
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
                        <table id="shippedBuyerOrder" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Buyer</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // shipped order S/N
                                    $sosn = 0;
                                @endphp

                                @foreach ($buyerOrders as $sBuyerOrder)
                                    @if ($sBuyerOrder['status'] === 'shipped')
                                        <tr>
                                            <td>{{++$sosn}}</td>
                                            <td>{{$sBuyerOrder['admin']}}</td>
                                            <td>{{$sBuyerOrder['name']}}</td>
                                            <td>{{$sBuyerOrder['quantity']}}</td>
                                            <td class="localePrice">{{$sBuyerOrder['total_price']}}</td>
                                            <td>{{$sBuyerOrder['buyer']}}</td>
                                            <td>{{$sBuyerOrder['date']}}</td>
                                            <td>{{$sBuyerOrder['wefarm_tx_ref']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.wefarm_product.show', ['id' => $sBuyerOrder['wefarm_tx_ref'], 'slug' => $sBuyerOrder['slug']])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-info">{{$sBuyerOrder['status']}}</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Buyer</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
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
                        <h3 class="card-title">Delivered Wefarm Buyer Order <sup><span class="badge bg-success">{{$deliveredBuyerOrder}}</span></sup></h3>
                        
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
                        <table id="deliveredBuyerOrder" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Buyer</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // delievered order S/N
                                    $dosn = 0;
                                @endphp

                                @foreach ($buyerOrders as $dBuyerOrder)
                                    @if ($dBuyerOrder['status'] === 'delivered')
                                        <tr>
                                            <td>{{++$dosn}}</td>
                                            <td>{{$dBuyerOrder['admin']}}</td>
                                            <td>{{$dBuyerOrder['name']}}</td>
                                            <td>{{$dBuyerOrder['quantity']}}</td>
                                            <td class="localePrice">{{$dBuyerOrder['total_price']}}</td>
                                            <td>{{$dBuyerOrder['buyer']}}</td>
                                            <td>{{$dBuyerOrder['date']}}</td>
                                            <td>{{$dBuyerOrder['wefarm_tx_ref']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.wefarm_product.show', ['id' => $dBuyerOrder['wefarm_tx_ref'], 'slug' => $dBuyerOrder['slug']])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-success">{{$dBuyerOrder['status']}}</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Buyer</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
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
    <script>
        document.querySelector('#redirect').addEventListener('click', ()=>{
            window.location.assign("{{route('users.farmer.products.create')}}")
        })
    </script>
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
        $("#processingBuyerOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#processingBuyerOrder_wrapper .col-md-6:eq(0)');

        $("#shippedBuyerOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#shippedBuyerOrder_wrapper .col-md-6:eq(0)');

        $("#deliveredBuyerOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#deliveredBuyerOrder_wrapper .col-md-6:eq(0)');

    });

</script>
@endsection
