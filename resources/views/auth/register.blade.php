@extends('layouts.app')
@section('title', 'Register')
@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/register.css')}}">
@endsection

    
@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                 @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Something went wrong... Kindly check the error(s) and try again.</strong>
                    </div>                    
                @endif
                <div id="ui">
                    <h1 class="text-center">Register</h1>
                    <form action="{{route('register')}}" class="form-group" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" class="form-control m-0 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Enter your First Name" autofocus>
                                @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" class="form-control m-0 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Enter your Last Name">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" placeholder="Enter your E-mail" class="form-control m-0 @error('email') is-invalid @enderror" value="{{old('email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="phone_num">Phone Number</label>
                                <input type="tel" id="phone_num" name="phone_num" value="{{old('phone_num')}}" placeholder="Enter your Phone Number" class="form-control m-0 @error('phone_num') is-invalid @enderror" pattern="[0-9]{11}">
                                @error('phone_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Role</label>
                                <select name="role" id="role" class="form-control m-0 @error('role') is-invalid @enderror">
                                    <option value="">Choose Role...</option>
                                    {{-- <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : "" }}>Farmer</option> --}}
                                    <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : "" }} selected>Buyer</option>
                                    {{-- <option value="logistics" {{ old('role') == 'logistics' ? 'selected' : '' }}>Logistic Company</option> --}}
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="password">Enter Password</label>
                                <input type="password" class="form-control m-0 @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}" placeholder="Enter your Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             <div class="col-lg-6 mb-3">
                                <label for="password-confirm">Confirm Password</label>
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control m-0" placeholder="Confirm your Password">
                            </div>
                        </div>
                        <input type="submit" name="register" value="Register" class="btn btn-primary btn-block btn-lg mb-3">
                        <p class="text-white">Already have an account? <a class="text-primary" href="{{route('login')}}">Login here</a></p>
                    </form>
                </div>
            </div>
            <div class="col-lg-3"></div>

        </div>
    </div>
@endsection