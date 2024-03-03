@extends('layouts.app')
@section('title', 'Login')
@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/signIn.css')}}">
@endsection
@section('content')
    <section class="loginForm container-fluid d-flex justify-content-center align-items-center py-5  ">
        <div class="col-md-10 col-sm-11 col-12 ">
            <div class="row no-gutters">
                <div class="col-lg-5 col-md-5 ">
                    <img src="{{asset('img/login-image.avif')}}" class="img-fluid long" alt="">
                </div>
                <div class="col-lg-7 col-md-7 px-sm-5 px-4 pt-5">
                    <h1 class="font-weight-bold py-lg-3 py-md-1">Sign In</h1>
                    <h4>Sign into your account</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Invalid email or password</strong>
                        </div>   
                    @endif
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-lg-8">
                                <input type="email" name="email" value="{{old('email')}}" class="form-control my-3 p-4" placeholder="Enter Your Email Address">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-8">
                                <input type="password" name="password" class="form-control my-3 p-4" placeholder="Enter Your Password">
                            </div>
                        </div>
                        <div class="form-check form-row">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <button class="btn1 mt-3 mb-2" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                    <div class="py-3 d-block d-lg-flex justify-content-lg-between  ">
                        @if (Route::has('password.request'))
                            <div class="">
                                <a class="text-primary" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            </div>
                        @endif
                        <div>
                            New user?
                            <a class="text-primary" href="{{route('register')}}">
                                Register here
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
