@extends('users.admin.layout.app')
@section('title', $user->name)
@section('breadcrumb-link')
    <li class="breadcrumb-item active">{{$user->name}} - {{$user->email}}</li>
@endsection
@section('content')
    <div class="container-fluid">
        @if (Auth::user()->status === 'pending')
            <div>Your account status is pending verification. Kindly contact the admin for further assistance</div>
        @else        

        <div class="row">
            <div class="col ml-sm-2 ml-md-5">
                <div class="row mb-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <label for="">Full Name:</label>
                    </div>
                    <div class="col-6 col-sm-8 col-md-9 col-lg-10">
                        {{strtoupper($user->name)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <label for="">Email:</label>
                    </div>
                    <div class="col-6 col-sm-8 col-md-9 col-lg-10">
                        {{strtoupper($user->email)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <label for="">Email verified:</label>
                    </div>
                    <div class="col-6 col-sm-8 col-md-9 col-lg-10">
                        {{$user->email_verified_at ? "YES" : "NO"}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <label for="">Phone Number:</label>
                    </div>
                    <div class="col-6 col-sm-8 col-md-9 col-lg-10">
                        {{strtoupper($user->phone_number)}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <label for="">Role:</label>
                    </div>
                    <div class="col-6 col-sm-8 col-md-9 col-lg-10">
                        {{strtoupper($user->role)}}
                    </div>
                </div>
                @if ($user->status === "pending")
                    <div class="row mb-2">
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-1">
                            <form action="{{route('users.admin.pendinguser.accept', $user->slug)}}" method="POST">
                                @method('put')
                                @csrf
                                <button title="Accept" type="submit" class="btn btn-success mx-lg-2">
                                    Accept <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-1">
                            <form action="{{route('users.admin.deleteUser', $user->slug)}}" method="POST">
                                @method('delete')
                                @csrf
                                <button title="Reject and Delete" type="submit" class="btn btn-danger">
                                    Reject and Delete <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection