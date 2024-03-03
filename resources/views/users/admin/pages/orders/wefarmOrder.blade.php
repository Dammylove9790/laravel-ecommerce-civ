@extends('users.admin.layout.app')
@section('title', 'Wefarm Orders')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Wefarm Orders</li>
@endsection

@section('content') 
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $processingOrder = 0;
                $shippedOrder = 0;
                $deliveredOrder = 0;
                $totalOrder = count($wefarmOrders);

                foreach($wefarmOrders as $wefarmOrder){
                    if($wefarmOrder['status'] === 'processing'){
                        $processingOrder += 1;
                    }
                    if($wefarmOrder['status'] === 'shipped'){
                        $shippedOrder += 1;
                    }
                    if($wefarmOrder['status'] === 'delivered'){
                        $deliveredOrder += 1;
                    }
                }
            @endphp
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                    <h3>{{$totalOrder}}</h3>

                    <h6>Wefarm Total Orders</h6>
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

                    <h6>Wefarm Delivered Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#deliveredOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$shippedOrder}}</h3>

                    <h6>Wefarm Shipped Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#shippedOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->


            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$processingOrder}}</h3>

                    <h6>Wefarm Processing Orders</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#processingOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Wefarm Processing Orders <sup><span class="badge bg-warning">{{$processingOrder}}</span></sup></h3>
                        
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
                                    <th>Admin</th>
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

                                @foreach ($wefarmOrders as $pOrder)
                                    @if ($pOrder['status'] === 'processing')
                                        <tr>
                                            <td>{{++$posn}}</td>
                                            <td>{{$pOrder['admin']}}</td>
                                            <td>{{str_replace("****", ", ", $pOrder['name'])}}</td>
                                            <td>{{str_replace("****", ", ", $pOrder['quantity'])}}</td>
                                            <td class="localePrice">{{$pOrder['total_price']}}</td>
                                            <td>{{$pOrder['date']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.self.show', $pOrder['wefarm_tx_ref'])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-warning">{{$pOrder['status']}}</button>
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
                        <h3 class="card-title">Wefarm Shipped Orders <sup><span class="badge bg-info">{{$shippedOrder}}</span></sup></h3>
                        
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
                                    <th>Admin</th>
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

                                @foreach ($wefarmOrders as $sOrder)
                                    @if ($sOrder['status'] === 'shipped')
                                        <tr>
                                            <td>{{++$sosn}}</td>
                                            <td>{{$sOrder['admin']}}</td>
                                            <td>{{str_replace("****", ", ", $sOrder['name'])}}</td>
                                            <td>{{str_replace("****", ", ", $sOrder['quantity'])}}</td>
                                            <td class="localePrice">{{$sOrder['total_price']}}</td>
                                            <td>{{$sOrder['date']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.self.show', $sOrder['wefarm_tx_ref'])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-info">{{$sOrder['status']}}</button>
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
                        <h3 class="card-title">Wefarm Delivered Orders <sup><span class="badge bg-success">{{$deliveredOrder}}</span></sup></h3>
                        
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
                                    <th>Admin</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Date Ordered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // delievered order S/N
                                    $dosn = 0;
                                @endphp

                                @foreach ($wefarmOrders as $dOrder)
                                    @if ($dOrder['status'] === 'delivered')
                                        <tr>
                                            <td>{{++$dosn}}</td>
                                            <td>{{$dOrder['admin']}}</td>
                                            <td>{{str_replace("****", ", ", $dOrder['name'])}}</td>
                                            <td>{{str_replace("****", ", ", $dOrder['quantity'])}}</td>
                                            <td class="localePrice">{{$dOrder['total_price']}}</td>
                                            <td>{{$dOrder['date']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.admin.orders.self.show', $dOrder['wefarm_tx_ref'])}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-success">{{$dOrder['status']}}</button>
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
        $("#processingOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#processingOrder_wrapper .col-md-6:eq(0)');

        $("#shippedOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#shippedOrder_wrapper .col-md-6:eq(0)');

        $("#deliveredOrder").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#deliveredOrder_wrapper .col-md-6:eq(0)');

    });

</script>
@endsection
