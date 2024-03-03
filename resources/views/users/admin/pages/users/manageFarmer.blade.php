@extends('users.admin.layout.app')
@section('title', 'Manage Farmer')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Manage Farmer</li>
@endsection

@section('content')    
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            @php
                $pendingFarmer = 0;
                $approvedFarmer = 0;

                foreach($farmers as $farmer){
                    if($farmer['status'] === 'pending'){
                        $pendingFarmer += 1;
                    }
                    if($farmer['status'] === 'successful'){
                        $approvedFarmer += 1;
                    }
                }
            @endphp
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$pendingFarmer}}</h3>

                    <h6>Pending Farmer</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#pendingFarmer" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$approvedFarmer}}</h3>

                    <h6>Approved Farmer</h5>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#approvedFarmer" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending Farmer <sup><span class="badge bg-danger">{{$pendingFarmer}}</span></sup></h3>
                        
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
                        <table id="pendingFarmer" class="table table-bordered table-striped text-center">
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
                                    $pfsn = 0;
                                @endphp

                                @foreach ($farmers as $pfarmer)
                                    @if ($pfarmer->status === 'pending')
                                        <tr>
                                            <td>{{++$pfsn}}</td>
                                            <td>{{$pfarmer->name}}</td>
                                            <td>{{$pfarmer->email}}</td>
                                            <td>{{$pfarmer->email_verified_at ? "Yes" : "No"}}</td>
                                            <td>{{$pfarmer->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.showUser', $pfarmer->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.pendinguser.accept', $pfarmer->slug)}}" method="POST">
                                                            @method('put')
                                                            @csrf
                                                            <button title="Accept" type="submit" class="btn btn-success mx-lg-2">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.deleteUser', $pfarmer->slug)}}" method="POST">
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
                                                                    <input type="hidden" name="picture_id" value="{{$admin->slug}}">
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
                        <h3 class="card-title">Approved Farmer <sup><span class="badge bg-success">{{$approvedFarmer}}</span></sup></h3>
                        
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
                        <table id="approvedFarmer" class="table table-bordered table-striped text-center">
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
                                // afsn is approved farner s/n
                                    $afsn = 0;
                                @endphp

                                @foreach ($farmers as $afarmer)
                                    @if ($afarmer->status === 'successful')
                                        <tr>
                                            <td>{{++$afsn}}</td>
                                            <td>{{$afarmer->name}}</td>
                                            <td>{{$afarmer->email}}</td>
                                            <td>{{$afarmer->email_verified_at ? "Yes" : "No"}}</td>
                                            <td>{{$afarmer->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.showUser', $afarmer->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.deleteUser', $afarmer->slug)}}" method="POST">
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
                                                                    <input type="hidden" name="picture_id" value="{{$admin->slug}}">
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
    $("#pendingFarmer").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#pendingFarmer_wrapper .col-md-6:eq(0)');

    $("#approvedFarmer").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#approvedFarmer_wrapper .col-md-6:eq(0)');

  });
</script>

@endsection
