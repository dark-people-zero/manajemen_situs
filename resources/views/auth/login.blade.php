@extends('layouts.custom-app')

@section('content')
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-45 justify-content-center">
                    <div class="card-sigin mt-5 mt-md-0">
                        <div class="main-card-signin d-md-flex">
                            <div class="wd-100p">
                                <div class="d-flex mb-4">
                                    <a href="#">
                                        <img src="{{ asset('assets/img/brand/favicon.png') }}" class="sign-favicon ht-40" alt="logo">
                                    </a>
                                </div>
                                <div class="">
                                    <div class="main-signup-header">
                                        <h2>Welcome back!</h2>
                                        <h6 class="font-weight-semibold mb-4">Please sign in to continue.</h6>
                                        @error('error')
                                            <div class="alert alert-danger mg-b-0 alert-dismissible fade show mb-3" role="alert">
                                                <span style="margin-right: 10px">{{ $message }}</span>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @enderror
                                        <div class="panel panel-primary">
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input class="form-control @error('username') is-invalid @enderror" placeholder="Enter your username" type="text" name="username" value="{{ old('username') }}" autofocus>

                                                        @error('username')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" type="password" name="password" autocomplete="current-password">

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                            </form>
                                        </div>

                                        <div class="main-signin-footer text-center mt-3">
                                            <p>Forgot password?</p>
                                            <p>Silakan hubungi administrator Anda.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

