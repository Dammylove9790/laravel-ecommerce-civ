@extends('users.admin.layout.app')
@section('title', 'Income Charges')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Income Charges</li>
@endsection

@section('content') 
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $processingCharges = 0;
                $receivedCharges = 0;

                $processingChargesOrder = 0;
                $receivedChargesOrder = 0;

                foreach($charges as $charge){
                    if($charge['status'] === 'processing' || $charge['status'] === 'shipped'){
                        $processingCharges += $charge['total_charges'];
                        $processingChargesOrder += 1;
                    }
                    if($charge['status'] === 'delivered'){
                        $receivedCharges += $charge['total_charges'];
                        $receivedChargesOrder += 1;
                    }
                }
            @endphp

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3 class="localePrice">{{$receivedCharges}}</h3>

                    <h6>Received Charges - {{$receivedChargesOrder}} order(s)</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#receivedCharges" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3 class="localePrice">{{$processingCharges}}</h3>

                    <h6>Processing Charges - {{$processingChargesOrder}} order(s)</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#processingCharges" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Processing Charges <sup><span class="badge bg-warning">{{$processingChargesOrder}}</span></sup></h3>
                        
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
                        <table id="processingCharges" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Charges</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // processing charges S/N
                                    $pcsn = 0;
                                @endphp

                                @foreach ($charges as $pcharge)
                                    @if ($pcharge['status'] === 'processing' || $pcharge['status'] === 'shipped')
                                        <tr>
                                            <td>{{++$pcsn}}</td>
                                            <td>{{$pcharge['name']}}</td>
                                            <td>{{$pcharge['quantity']}}</td>
                                            <td class="localePrice">{{$pcharge['total_charges']}}</td>
                                            <td>{{$pcharge['date']}}</td>
                                            <td>{{$pcharge['wefarm_tx_ref']}}</td>
                                            <td>
                                                <button class="btn btn-warning">{{$pcharge['status']}}</button>
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
                                    <th>Total Charges</th>
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
                        <h3 class="card-title">Received Charges <sup><span class="badge bg-success">{{$receivedChargesOrder}}</span></sup></h3>
                        
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
                        <table id="receivedCharges" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Total Charges</th>
                                    <th>Date Ordered</th>
                                    <th>Transaction Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // received charges S/N
                                    $rcsn = 0;
                                @endphp

                                @foreach ($charges as $dcharge)
                                    @if ($dcharge['status'] === 'delivered')
                                        <tr>
                                            <td>{{++$rcsn}}</td>
                                            <td>{{$dcharge['name']}}</td>
                                            <td>{{$dcharge['quantity']}}</td>
                                            <td class="localePrice">{{$dcharge['total_charges']}}</td>
                                            <td>{{$dcharge['date']}}</td>
                                            <td>{{$dcharge['wefarm_tx_ref']}}</td>
                                            <td>
                                                <button class="btn btn-success">{{$dcharge['status']}}</button>
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
                                    <th>Total Charges</th>
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
        $("#processingCharges").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#processingCharges_wrapper .col-md-6:eq(0)');

        $("#receivedCharges").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "print", "colvis"]
        }).buttons().container().appendTo('#receivedCharges_wrapper .col-md-6:eq(0)');

    });

</script>
@endsection
