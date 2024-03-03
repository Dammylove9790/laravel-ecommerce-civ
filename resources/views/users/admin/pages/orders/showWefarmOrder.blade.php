@extends('users.admin.layout.app')
@section('title', $order->wefarm_tx_ref)
@section('breadcrumb-link')
    <li class="breadcrumb-item"><a href="{{route('users.admin.orders.self')}}">Wefarm Orders</a></li>
    <li class="breadcrumb-item active">{{$order->wefarm_tx_ref}}</li>
@endsection
@section('content')
    <div class="container-fluid">
        @if ($order->customer_email !== Auth::user()->email)
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <div class="row">
            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Products Ordered:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{str_replace("****", ", ", $order->order_products)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Quantity:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{str_replace("****", ", ", $order->order_products_quantity)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Total Price:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        <span>&#8358 </span>{{$order->total_price}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Status:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{ucfirst($order->order_status)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Order Date:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$order->created_at}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        <label for="">Transaction Ref:</label>
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$order->wefarm_tx_ref}}
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="row mb-2">
                    @for ($i = 0; $i < count($orderProductsName); $i++)
                        <div class="col-6 mb-2 text-center">
                            <h5>
                                {{$orderProductsName[$i]}}
                                @if (count($orderProductsName) > 1)
                                    ({{explode("****", $order->order_products_quantity)[$i]}})
                                @endif
                            </h5>
                            <img class="img-fluid" src="{{asset('pictures/'.$orderProductsImg[$i])}}" alt="{{$orderProductsName[$i]}}">
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection