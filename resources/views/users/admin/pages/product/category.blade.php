@extends('users.admin.layout.app')
@section('title', 'Product Category')

@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/dropdown.css')}}">
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Product Category</li>
@endsection

@section('content')
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <div class="row">
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{count($categories)}}</h3>
                        <h6>Categories</h6>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#ourCategories" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row mb-5">
            <form name="add_category" class="col-8 col-sm-6" method="POST">
                @method('post')
                @csrf
                <div class="form-floating mt-2">
                    <label for="category">Add New Category</label>
                    <input type="text" name="category" placeholder="Enter Category Name" class="form-control" id="category">
                    <strong class="text-danger" id="category_error"></strong>
                </div>
                <button class=" mt-2 btn btn-success btn-md">Add Category</button>
            </form>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Our Categories <sup><span class="badge bg-success">{{count($categories)}}</span></sup></h3>
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
                        <table id="ourCategories" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Category Name</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                    $sn = 0;
                                @endphp

                                @foreach ($categories as $category)
                                    @if ($category->name === 'Others')
                                        @continue
                                    @endif
                                    <tr>
                                        <td>{{++$sn}}</td>
                                        <td>{{$category->name}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>{{++$sn}}</td>
                                    <td>Others</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Category Name</th>
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
@endsection


@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @include('users.admin.pages.product.jsCategory')

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

    <script>
        $(function () {
            $("#ourCategories").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["excel", "print"]
            }).buttons().container().appendTo('#ourCategories_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection