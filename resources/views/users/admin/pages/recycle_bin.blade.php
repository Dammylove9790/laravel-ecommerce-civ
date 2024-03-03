@extends('users.admin.layout.app')
@section('title', 'Recycle Bin')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Recycle Bin</li>
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
    
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{count($recycle_users)}}</h3>

                    <h6>Users</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#recycle_users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{count($recycle_products)}}</h3>

                    <h6>Products</h6>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#recycle_products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        @if (count($recycle_users) > 0 || count($recycle_products) > 0)
            <div class="row mt-3 mb-5">
                <div class="col-12">
                    <form action="{{route('users.admin.bin.empty.all')}}" method="POST">
                        @method('delete')
                        @csrf
                        <button title="Empty Users Recycle Bin" type="submit" class="btn btn-danger">
                            Empty Recycle Bin
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @if (count($recycle_users) > 0)
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Users <sup><span class="badge bg-danger">{{count($recycle_users)}}</span></sup>
                                <form action="{{route('users.admin.bin.empty.specific', 'Users')}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button title="Empty Users Recycle Bin" type="submit" class="btn btn-danger">
                                        Empty Users Recycle Bin
                                    </button>
                                </form>
                            </h3>
                            
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
                            <table id="recycle_users" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Date Deleted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    @php
                                    // user S/N
                                        $usn = 0;
                                    @endphp

                                    @foreach ($recycle_users as $user)
                                        <tr>
                                            <td>{{++$usn}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->role}}</td>
                                            <td>{{$user->deleted_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.bin.restore.user', $user->slug)}}" method="POST">
                                                            @method('post')
                                                            @csrf
                                                            <button title="Restore User" type="submit" class="btn btn-success mx-lg-2">
                                                                <i class="fas fa-trash-restore"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.bin.delete.user', $user->slug)}}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button title="Delete User Permanently" type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Date Deleted</th>
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
            </div>
            <!-- /.row -->
        @endif


        @if (count($recycle_products) > 0)
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Products <sup><span class="badge bg-danger">{{count($recycle_products)}}</span></sup>
                                <form action="{{route('users.admin.bin.empty.specific', 'Products')}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button title="Empty Products Recycle Bin" type="submit" class="btn btn-danger">
                                        Empty Products Recycle Bin
                                    </button>
                                </form>
                            </h3>
                            
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
                            <table id="recycle_products" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Added By</th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Front View</th>
                                        <th>Date Deleted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    @php
                                    // product S/N
                                        $psn = 0;
                                    @endphp

                                    @foreach ($recycle_products as $product)
                                        @php
                                            $img = $product['picture']['front_view'];
                                        @endphp

                                        <tr>
                                            <td>{{++$psn}}</td>
                                            <td>{{$product->added_by}}</td>
                                            <td>{{ucfirst($product->role)}}</td>
                                            <td>{{$product->name}}</td>
                                            <td><img class="" src="{{asset('pictures/'.$img)}}" style='max-height:100px' alt="{{$product->name}}"></td>
                                            <td>{{$product->deleted_at}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.bin.restore.product', $product->slug)}}" method="POST">
                                                            @method('post')
                                                            @csrf
                                                            <button title="Restore Product" type="submit" class="btn btn-success mx-lg-2">
                                                                <i class="fas fa-trash-restore"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col pb-1">
                                                        <form action="{{route('users.admin.bin.delete.product', $product->slug)}}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button title="Delete Product Permanently" type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Added By</th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Front View</th>
                                        <th>Date Deleted</th>
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
            </div>
            <!-- /.row -->
        @endif


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
    $("#recycle_users").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#recycle_users_wrapper .col-md-6:eq(0)');
    
    $("#recycle_products").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#recycle_products_wrapper .col-md-6:eq(0)');

});
</script>

@endsection
