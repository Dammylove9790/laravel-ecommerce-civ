@extends('users.admin.layout.app')
@section('title', 'Edit Product')

@section('breadcrumb-link')
    <li class="breadcrumb-item"><a href="{{route('users.admin.products')}}">Products</a></li>
    <li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(12, 169, 12); 
            color: white;
        }

    </style>
@endsection


@section('content')
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <form name="editProductForm" action="{{route('users.admin.products.update', $product->slug)}}" method="POST" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row">
                <div class="my-3 col-12">
                    <label for='productName' class='form-label'>Name</label>
                    <input type='text' class='form-control p-3' id='productName'
                        placeholder='' name='productName' value="{{$product->name}}">
                    <small id='productNameErr' class='text-danger'></small>
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for="productCategory" class="form-label">Product Category</label>
                    <select name="productCategory" id="productCategory" class="form-control">
                        <option value="">Select Product Category...</option>
                         @foreach ($categories as $category)
                            @if ($category->name === 'Others')
                                @continue
                            @endif
                            <option value="{{$category->slug}}" @php echo $category->slug === $prodCatSlug ? "selected" : ""  @endphp>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                    <small id='productCategoryErr' class='text-danger'></small>                    
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for='productPrice' class='form-label'>Price</label>
                    <div class="input-group">
                        <h5 class="input-group-text">&#8358</h5>
                        <input type='number' class='form-control p-3' id='productPrice'
                        placeholder='' name='productPrice' value="{{$product->price}}">
                    </div>
                    
                    <small id='productPriceErr' class='text-danger'></small>
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for='productQuantity' class='form-label'>Quantity</label>
                    <div class="input-group">
                        <button class="btn btn-success" type="button">-</button>
                        <input type='number' class='form-control p-3' id='productQuantity'
                        placeholder='' name='productQuantity' value="{{$product->quantity}}">
                        <button class="btn btn-success" type="button">+</button>
                    </div>
                    <small id='productQuantityErr' class='text-danger'></small>
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for='productMeasurement' class='form-label'>Measurement</label>
                    <input type='text' class='form-control p-3' id='productMeasurement'
                        placeholder='' name='productMeasurement' value="{{$product->measurement}}">
                    <small id='productMeasurementErr' class='text-danger'></small>
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for="productSize" class="form-label">Product Size</label>
                    <select name="productSize[]" id="productSize" class="form-control select2" multiple>
                        @forelse ($sizes as $size)
                            <option value="{{$size->id}}" {{ in_array($size->id, $product->size) ? "selected" : "" }}>{{$size->name}}</option>
                        @empty
                        <option disabled>No options available</option>
                        @endforelse
                    </select>
                    <small id='productSizeErr' class='text-danger'></small>                    
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for="productColor" class="form-label">Product Color</label>
                    <select name="productColor[]" id="productColor" class="form-control select2" multiple>
                        @forelse ($colors as $color)
                            <option value="{{$color->id}}" {{ in_array($color->id, $product->color) ? "selected" : "" }}>{{$color->name}}</option>
                        @empty
                        <option disabled>No options available</option>
                        @endforelse
                    </select>
                    <small id='productColorErr' class='text-danger'></small>                    
                </div>
                <div class="my-3 col-12">
                    <label for="productDescription" class="form-label"><b>Description</b></label>
                    <textarea class="form-control mb-3" name="productDescription" id="productDescription"
                        placeholder="Description of your product" rows="10">{{$product->description}}</textarea>
                    <small id="productDescriptionErr" class="text-danger"></small>
                </div>

                {{-- <h6 class="col-12">Product Address</h6>

                <div class="my-3 col-12 col-sm-12 col-lg-3">
                    <label for='productAddress' class='form-label'>Product Address</label>
                    <input type='text' class='form-control p-3' id='productAddress'
                        placeholder='' name='productAddress' value="{{$product->address}}">
                    <small id='productAddressErr' class='text-danger'></small>
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for='productCity' class='form-label'>Product City / Town / Village</label>
                    <input type='text' class='form-control p-3' id='productCity'
                        placeholder='' name='productCity' value="{{$product->city}}">
                    <small id='productCityErr' class='text-danger'></small>
                </div>
                <div class="my-3 col-6 col-sm-4 col-lg-3">
                    <label for='productState' class='form-label'>Product State</label>
                    <input type='text' class='form-control p-3' id='productState'
                        placeholder='' name='productState' value="{{$product->state}}">
                    <small id='productStateErr' class='text-danger'></small>
                </div> --}}

                <h5>Kindly note that you must upload Front view of your product. Other views are optional. Acceptable dimension is 300px by 250px</h5>
                <div class="my-3 col-sm-6">
                    <label for="productFrontView" class="form-label"><b>Front view</b></label>
                    <input type="file" class="form-control" id="productFrontView" name="productFrontView">
                    <small id="productFrontViewErr" class="text-danger"></small>
                </div>
                <div class="my-3 col-sm-6">
                    <label for="productBackView" class="form-label"><b>Back view</b></label>
                    <input type="file" class="form-control" id="productBackView" name="productBackView">
                    <small id="productBackViewErr" class="text-danger"></small>
                </div>
                <div class="my-3 col-sm-6">
                    <label for="productLeftView" class="form-label"><b>Left view</b></label>
                    <input type="file" class="form-control" id="productLeftView" name="productLeftView">
                    <small id="productLeftViewErr" class="text-danger"></small>
                </div>
                <div class="my-3 col-sm-6">
                    <label for="productRightView" class="form-label"><b>Right view</b></label>
                    <input type="file" class="form-control" id="productRightView" name="productRightView">
                    <small id="productRightViewErr" class="text-danger"></small>
                </div>
            </div>
            <div id="validity"></div>
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> --}}
            <input type="submit" name="productUpload" class="btn btn-success mx-3 my-2" value="Upload product">
        </form>
    @endif
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @include('users.admin.pages.product.jsEditProduct')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select...",
                allowClear: true
            });
        });
    </script>
@endsection
