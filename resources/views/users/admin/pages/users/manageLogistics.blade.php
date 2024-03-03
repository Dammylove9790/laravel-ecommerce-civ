@extends('users.admin.layout.app')
@section('title', 'Manage Logistics')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Manage Logistics</li>
@endsection

@section('content')    
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $pendingLogistics = 0;
                $approvedLogistics = 0;

                foreach($logistics as $logistic){
                    if($logistic['status'] === 'pending'){
                        $pendingLogistics += 1;
                    }
                    if($logistic['status'] === 'successful'){
                        $approvedLogistics += 1;
                    }
                }
            @endphp
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$pendingLogistics}}</h3>

                    <h6>Pending Logistic</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#pendingLogistics" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$approvedLogistics}}</h3>

                    <h6>Approved Logistic</h5>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#approvedLogistics" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending Logistic <sup><span class="badge bg-danger">{{$pendingLogistics}}</span></sup></h3>
                        
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
                        <table id="pendingLogistics" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Names</th>
                                    <th>Email</th>
                                    <th>Email verified</th>
                                    <th>Registration date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                    $plsn = 0;
                                @endphp

                                @foreach ($logistics as $plogistic)
                                    @if ($plogistic->status === 'pending')
                                        <tr>
                                            <td>{{++$plsn}}</td>
                                            <td>{{$plogistic->name}}</td>
                                            <td>{{$plogistic->email}}</td>
                                            <td>{{$plogistic->email_verified_at ? "Yes" : "No"}}</td>
                                            <td>{{$plogistic->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.showUser', $plogistic->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.pendinguser.accept', $plogistic->slug)}}" method="POST">
                                                            @method('put')
                                                            @csrf
                                                            <button title="Accept" type="submit" class="btn btn-success mx-lg-2">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.deleteUser', $plogistic->slug)}}" method="POST">
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
                                                                    <input type="hidden" name="picture_id" value="{{$logistic->slug}}">
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


        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Approved Logistic <sup><span class="badge bg-success">{{$approvedLogistics}}</span></sup></h3>
                        
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
                        <table id="approvedLogistics" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Names</th>
                                    <th>Email</th>
                                    <th>Email verified</th>
                                    <th>Registration date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                // alsn is approved logistic s/n
                                    $alsn = 0;
                                @endphp

                                @foreach ($logistics as $alogistic)
                                    @if ($alogistic->status === 'successful')
                                        <tr>
                                            <td>{{++$alsn}}</td>
                                            <td>{{$alogistic->name}}</td>
                                            <td>{{$alogistic->email}}</td>
                                            <td>{{$alogistic->email_verified_at ? "Yes" : "No"}}</td>
                                            <td>{{$alogistic->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.showUser', $alogistic->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.deleteUser', $alogistic->slug)}}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button title="Delete" type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
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
                                                                    <input type="hidden" name="picture_id" value="{{$logistic->slug}}">
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
    $("#pendingLogistics").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#pendingLogistics_wrapper .col-md-6:eq(0)');

    $("#approvedLogistics").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#approvedLogistics_wrapper .col-md-6:eq(0)');

  });
</script>

@endsection
