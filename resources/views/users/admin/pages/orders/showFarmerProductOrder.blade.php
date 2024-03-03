@extends('users.admin.layout.app')
@section('title', "$buyerOrder[wefarm_tx_ref] / $buyerOrder[name]")
@section('breadcrumb-link')
    <li class="breadcrumb-item"><a href="{{route('users.admin.orders.farmer_product')}}">Farmer Product Orders</a></li>
    <li class="breadcrumb-item active">{{$buyerOrder['wefarm_tx_ref']}} / {{$buyerOrder['name']}}</li>
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
                        Farmer:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$buyerOrder['farmer']}}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Buyer:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$buyerOrder['buyer']}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Product Ordered:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$buyerOrder['name']}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Quantity:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$buyerOrder['quantity']}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Total Price:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        <span>&#8358 </span>{{$buyerOrder['total_price']}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Status:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{ucfirst($buyerOrder['status'])}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Order Date:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$buyerOrder['date']}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 col-md-4">
                        Transaction Ref:
                    </div>
                    <div class="col-sm-7 col-md-8">
                        {{$buyerOrder['wefarm_tx_ref']}}
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-12 mb-2">
                        <img class="img-fluid" src="{{asset('pictures/'.$buyerOrder['picture'])}}" alt="{{$buyerOrder['name']}}">
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection