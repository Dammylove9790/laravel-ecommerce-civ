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
                                    <th>Action</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                @php
                                    $sn = 0;
                                @endphp

                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{++$sn}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            <button type="button" class="btn" data-toggle="modal" data-target="#edit" onclick="editCat('{{ $category->id }}', '{{ $category->name }}')">
                                                <i class="fa fa-edit text-primary px-2" aria-hidden="true"></i>
                                            </button>                                                                                           
                                            <button type="button" class="btn" data-toggle="modal" data-target="#delete" onclick="deleteCat('{{ $category->id }}')">
                                                <i class="fa fa-trash text-danger px-2" aria-hidden="true"></i>
                                            </button>        
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Category Name</th>
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

        <div class="modal fade" id="edit">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="" name="edit_form" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mt-2">
                                    <label for="new_name">Category Name</label>
                                    <input type="text" name="new_name" placeholder="Enter Category Name" value="{{ old('new_name') }}" class="form-control @error('new_name') is-invalid @enderror" id="new_name">
                                </div>
                                @error('new_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
    
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Category</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Category?
                    </div>
                    <div class="modal-footer">
                        <form name="delete_form" action="" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-success">Yes</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>       

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

        let editBaseUrl = "{{ route('users.admin.category.update', ['id' => '__id__']) }}"
        let deleteBaseUrl = "{{ route('users.admin.category.delete', ['id' => '__id__']) }}"
    
        function editCat(id, name){
            let editUrl = editBaseUrl.replace('__id__', '') + id;
    
            let edit_form = document.forms['edit_form'];
            edit_form['new_name'].value = name;            
            edit_form.action = editUrl;
        }
    
        function deleteCat(id){
            let deleteUrl = deleteBaseUrl.replace('__id__', '') + id;
    
            let delete_form = document.forms['delete_form'];        
            delete_form.action = deleteUrl;
        }

    </script>

@endsection