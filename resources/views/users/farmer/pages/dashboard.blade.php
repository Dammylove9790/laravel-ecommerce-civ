@extends('users.farmer.layout.app')
@section('title', 'Dashboard')

@section('css')
  <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-link')
    <li class="breadcrumb-item active">Dashboard</li>
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
        @if(session('unauthorized'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('unauthorized')}}</strong> 
            </div>
        @endif
        
        <div class="container-fluid">
            @if (Auth::user()->status === 'pending')
                <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
            @else        

            <!-- Small boxes (Stat box) -->
            <div class="row">
                @php
                    $pendingProduct = 0;
                    $successfulProduct = 0;

                    foreach($products as $product){
                        if($product['status'] === 'pending'){
                            $pendingProduct += 1;
                        }
                        if($product['status'] === 'successful'){
                            $successfulProduct += 1;
                        }
                    }
                    $totalProduct = $pendingProduct + $successfulProduct;

        
                    $processingBuyerOrder = 0;
                    $shippedBuyerOrder = 0;
                    
                    $totalBuyerOrder = count($buyerOrders);

                    foreach($buyerOrders as $buyerOrder){
                        if($buyerOrder['status'] === 'processing'){
                            $processingOrder += 1;
                        }
                        if($buyerOrder['status'] === 'shipped'){
                            $shippedBuyerOrder += 1;
                        }
                    }
                
                @endphp
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{$totalProduct}}</h3>

                        <h6>Total Products</h6>
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
                        <h3>{{$successfulProduct}}</h3>

                        <h6>Successful Products</h5>
                        </div>
                        <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('users.farmer.products')}}#successfulProduct" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                        <h3>{{$pendingProduct}}</h3>

                        <h6>Pending Products</h6>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('users.farmer.products')}}#pendingProduct" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                        <h3>{{$totalBuyerOrder}}</h3>

                        <h6>Total Buyer Orders</h6>
                        </div>
                        <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('users.farmer.orders.buyer')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{$processingBuyerOrder}}</h3>

                        <h6>Processing Buyer Orders</h6>
                        </div>
                        <div class="icon">
                        <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('users.farmer.orders.buyer')}}#processingBuyerOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{$shippedBuyerOrder}}</h3>

                        <h6>Shipped Buyer Orders</h6>
                        </div>
                        <div class="icon">
                        <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('users.farmer.orders.buyer')}}#shippedBuyerOrder" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pending products <sup><span class="badge bg-danger">{{$pendingProduct}}</span></sup></h3>
                            
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
                            <table id="pendingProduct" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Quantity</th>
                                        <th>Front view</th>
                                        <th>Date Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    @php
                                    // pending product S/N
                                        $ppsn = 0;
                                    @endphp

                                    @foreach ($products as $product)
                                        @if ($product->status === 'pending')
                                            @php
                                                $img = $product['picture']['front_view'];
                                            @endphp
                                            <tr>
                                                <td>{{++$ppsn}}</td>
                                                <td>{{$product->name}}</td>
                                                <td class="localePrice">{{$product->price}}</td>
                                                <td>{{$product->quantity}}</td>
                                                <td><img class="" src="{{asset('pictures/'.$img)}}" style='max-height:100px' alt="{{$product->name}}"></td>
                                                <td>{{$product->created_at}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col pb-1">
                                                            <a title="View" class="btn btn-primary" href="{{route('users.farmer.products.show', $product->slug)}}">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col pb-1">
                                                            <a title="Edit" class="btn btn-success" href="{{route('users.farmer.products.edit', $product->slug)}}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col pb-1">
                                                            <form action="{{route('users.farmer.products.delete', $product->slug)}}" method="POST">
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
                                                                        <input type="hidden" name="picture_id" value="{{$product->slug}}">
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
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Quantity</th>
                                        <th>Front view</th>
                                        <th>Date Uploaded</th>
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
    $("#pendingProduct").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print", "colvis"]
    }).buttons().container().appendTo('#pendingProduct_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
