@extends('layouts.custom-app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

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
                                        <h2>Change Password</h2>
                                        @error('error')
                                            <div class="alert alert-danger mg-b-0 alert-dismissible fade show mb-3" role="alert">
                                                <span style="margin-right: 10px">{{ $message }}</span>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @enderror
                                        <div class="panel panel-primary mt-4">
                                            <form method="POST" action="{{ route('password.update') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input class="form-control @error('oldpassword') is-invalid @enderror" placeholder="Enter your old password" type="password" name="oldpassword" autofocus required>

                                                        @error('oldpassword')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input class="form-control @error('newpassword') is-invalid @enderror" placeholder="Enter your newpassword" type="password" name="newpassword" required>

                                                    @error('newpassword')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <button type="submit" class="btn btn-primary btn-block me-2">Change Password</button>
                                                    <a href="{{url()->previous()}}" class="btn btn-warning btn-block mt-0">Cancel</a>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="main-signin-footer text-center mt-3">
                                            <p>Forgot old password?</p>
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
