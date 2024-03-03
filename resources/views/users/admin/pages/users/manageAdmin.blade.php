@extends('users.admin.layout.app')
@section('title', 'Manage Admin')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Manage Admin</li>
@endsection

@section('content')    
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{count($admins)}}</h3>

                    <h6>Approved Admin</h5>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#approvedAdmin" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Approved Admin <sup><span class="badge bg-success">{{count($admins)}}</span></sup></h3>
                        
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
                        <table id="approvedAdmin" class="table table-bordered table-striped text-center">
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
                                // aasn is approved admin s/n
                                    $aasn = 0;
                                @endphp

                                @foreach ($admins as $aadmin)
                                    @if ($aadmin->status === 'successful')
                                        <tr>
                                            <td>{{++$aasn}}</td>
                                            <td>{{$aadmin->name}}</td>
                                            <td>{{$aadmin->email}}</td>
                                            <td>{{$aadmin->email_verified_at ? "Yes" : "No"}}</td>
                                            <td>{{$aadmin->created_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <a title="View" class="btn btn-primary" href="{{route('users.admin.showUser', $aadmin->slug)}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.deleteUser', $aadmin->slug)}}" method="POST">
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
    $("#approvedAdmin").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#approvedAdmin_wrapper .col-md-6:eq(0)');

});
</script>

@endsection
