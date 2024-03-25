@extends('users.admin.layout.app')
@section('title', 'My Account')

@section('breadcrumb-link')
    <li class="breadcrumb-item active">My Account</li>
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
        <div class="row mb-1">
            <p class="col-sm-4 col-lg-2 fw-bold">Name:</p>
            <p class="col-sm-8 col-lg-10">{{ $user->name }}</p>
        </div>
        
        <div class="row mb-1">
            <p class="col-sm-4 col-lg-2 fw-bold">Email:</p>
            <p class="col-sm-8 col-lg-10">{{ $user->email }}</p>
        </div>
        
        <div class="row mb-1">
            <p class="col-sm-4 col-lg-2 fw-bold">Phone Number:</p>
            <p class="col-sm-8 col-lg-10">{{ $user->phone_number }}</p>
        </div>

        <div class="row mb-1">
            <p class="col-sm-4 col-lg-2 fw-bold">Role:</p>
            <p class="col-sm-8 col-lg-10">{{ ucwords($user->role) }}</p>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mt-4">
            <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
        </div>    
        <form action="{{ route('users.admin.password') }}" method="POST" class="row">
            @method('put')
            @csrf
            <div class="col-md-6">
                <div class="row mt-3">
                    <label for="current_password">Current password <span class="text-danger">*</span></label>
                    <input type="password" name="current_password" placeholder="Enter current password" value="{{ old('current_password') }}" class="form-control @error('current_password') is-invalid @enderror" id="current_password">
                    @error('current_password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="row mt-3">
                    <label for="new_password">New Password <span class="text-danger">*</span></label>
                    <input type="password" name="new_password" placeholder="Enter new password" class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                    @error('new_password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="row mt-3">
                    <label for="new_password_confirmation">Confirm New password <span class="text-danger">*</span></label>
                    <input type="password" name="new_password_confirmation" placeholder="Confirm new password" class="form-control" id="new_password_confirmation">
                </div>
                
                <button type="submit" class="btn btn-success btn-md d-block my-3 mx-auto">Update Password</button>
            </div>
        </form>    
        
    </div>
    <!-- /.container-fluid -->
  
@endsection
