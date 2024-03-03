@extends('users.farmer.layout.app')
@section('title', 'My Income')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">My Income</li>
@endsection

@section('content') 
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $processingIncome = 0;
                $paidIncome = 0;

                $processingIncomeOrder = 0;
                $paidIncomeOrder = 0;

                foreach($buyerOrders as $buyerOrder){
                    if($buyerOrder['status'] === 'processing' || $buyerOrder['status'] === 'shipped'){
                        $processingIncome += $buyerOrder['total_price'];
                        $processingIncomeOrder += 1;
                    }
                    if($buyerOrder['status'] === 'delivered'){
                        $paidIncome += $buyerOrder['total_price'];
                        $paidIncomeOrder += 1;
                    }
                }
            @endphp

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3 class="localePrice">{{$paidIncome}}</h3>

                    <h6>Paid Income - {{$paidIncomeOrder}} order(s)</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#paidIncome" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3 class="localePrice">{{$processingIncome}}</h3>

                    <h6>Processing Income - {{$processingIncomeOrder}} order(s)</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#processingIncome" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Processing Income <sup><span class="badge bg-warning">{{$processingIncomeOrder}}</span></sup></h3>
                        
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
                        <table id="processingIncome" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
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
                                // processing income S/N
                                    $pisn = 0;
                                @endphp

                                @foreach ($buyerOrders as $pBuyerOrder)
                                    @if ($pBuyerOrder['status'] === 'processing' || $pBuyerOrder['status'] === 'shipped')
                                        <tr>
                                            <td>{{++$pisn}}</td>
                                            <td>{{$pBuyerOrder['name']}}</td>
                                            <td>{{$pBuyerOrder['quantity']}}</td>
                                            <td class="localePrice">{{$pBuyerOrder['total_price']}}</td>
                                            <td>{{$pBuyerOrder['buyer']}}</td>
                                            <td>{{$pBuyerOrder['date']}}</td>
                                            <td>{{$pBuyerOrder['wefarm_tx_ref']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.farmer.orders.buyer.show', ['id' => $pBuyerOrder['wefarm_tx_ref'], 'slug' => $pBuyerOrder['slug']])}}">
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
                        <h3 class="card-title">Paid Income <sup><span class="badge bg-success">{{$paidIncomeOrder}}</span></sup></h3>
                        
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
                        <table id="paidIncome" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
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
                                // paid income S/N
                                    $paisn = 0;
                                @endphp

                                @foreach ($buyerOrders as $dBuyerOrder)
                                    @if ($dBuyerOrder['status'] === 'delivered')
                                        <tr>
                                            <td>{{++$paisn}}</td>
                                            <td>{{$dBuyerOrder['name']}}</td>
                                            <td>{{$dBuyerOrder['quantity']}}</td>
                                            <td class="localePrice">{{$dBuyerOrder['total_price']}}</td>
                                            <td>{{$dBuyerOrder['buyer']}}</td>
                                            <td>{{$dBuyerOrder['date']}}</td>
                                            <td>{{$dBuyerOrder['wefarm_tx_ref']}}</td>
                                            <td>
                                                <a title="View" class="btn btn-primary" href="{{route('users.farmer.orders.buyer.show', ['id' => $dBuyerOrder['wefarm_tx_ref'], 'slug' => $dBuyerOrder['slug']])}}">
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
        $("#processingIncome").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#processingIncome_wrapper .col-md-6:eq(0)');

        $("#paidIncome").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#paidIncome_wrapper .col-md-6:eq(0)');

    });

</script>
@endsection
