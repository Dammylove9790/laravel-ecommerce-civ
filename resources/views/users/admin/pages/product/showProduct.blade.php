@extends('users.admin.layout.app')
@section('title', $product->name)
@section('breadcrumb-link')
    <li class="breadcrumb-item"><a href="{{route('users.admin.products')}}">Products</a></li>
    <li class="breadcrumb-item active">{{$product->name}}</li>
@endsection
@section('content')
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <div class="row">
            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Product Name:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{strtoupper($product->name)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Product Category:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{strtoupper($productCategory)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Added By:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{strtoupper($product->added_by)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Role:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{ucfirst($product->role)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Price:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        <span>&#8358 </span>{{$product->price}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Quantity:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{strtoupper($product->quantity)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Measurement:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{ucfirst($product->measurement)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Size:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        @foreach ($product->size as $index => $size)
                        {{ $size }}{{ $index == count($product->size) - 1 ? "." : ", " }}
                        @endforeach
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Color:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        @foreach ($product->color as $index => $col)
                            {{ $col }}{{ $index == count($product->color) - 1 ? "." : ", " }}
                        @endforeach
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Description:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{ucfirst($product->description)}}
                    </div>
                </div>
                {{-- <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Address:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$product->address}}, {{$product->city}}, {{$product->state}}.
                    </div>
                </div> --}}
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Status:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{ucfirst($product->status)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Date Uploaded:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{strtoupper($product->created_at)}}
                    </div>
                </div>

                @if ($product->updated_at > $product->created_at)
                    <div class="row mb-2">
                        <div class="col-sm-5 col-md-4">
                            <label for="">Date Updated:</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            {{strtoupper($product->updated_at)}}
                        </div>
                    </div>
                @endif

                @if ($product->updated_by)
                    <div class="row mb-2">
                        <div class="col-sm-5 col-md-4">
                            <label for="">Last Updated By:</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            {{strtoupper($product->updated_by)}}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-6">
                        <h5>Front view</h5>
                        <img class="img-fluid" src="{{asset('pictures/'.$product->picture->front_view)}}" alt="{{$product->name}}">
                    </div>
                    @if ($product->picture->back_view)
                        <div class="col-6">
                            <h5>Back view</h5>
                            <img class="img-fluid" src="{{asset('pictures/'.$product->picture->back_view)}}" alt="{{$product->name}}">
                        </div>
                    @endif
                    @if ($product->picture->left_view)
                        <div class="col-6">
                            <h5>Left view</h5>
                            <img class="img-fluid" src="{{asset('pictures/'.$product->picture->left_view)}}" alt="{{$product->name}}">
                        </div>
                    @endif
                    @if ($product->picture->right_view)
                        <div class="col-6">
                            <h5>Right view</h5>
                            <img class="img-fluid" src="{{asset('pictures/'.$product->picture->right_view)}}" alt="{{$product->name}}">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="row mb-2">
                    @if ($product->status === 'pending')
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-1">
                            <form action="{{route('users.admin.products.accept', $product->slug)}}" method="POST">
                                @method('put')
                                @csrf
                                <button title="Accept" type="submit" class="btn btn-success mx-lg-2">
                                    Accept <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($product->role === "admin")
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-1">
                        <a title="Edit" class="btn btn-success" href="{{route('users.admin.products.edit', $product->slug)}}">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </a> 
                    </div>  
                    @endif

                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-1">
                        <form action="{{route('users.admin.products.delete', $product->slug)}}" method="POST">
                            @method('delete')
                            @csrf
                            <button title="Reject and Delete" type="submit" class="btn btn-danger">
                                Reject and Delete <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection