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
                                                <span style="margin-right: 10px">{!! $message !!}</span>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @enderror
                                        @if (session('info'))

                                            <div class="alert alert-info mg-b-0 alert-dismissible fade show mb-3" role="alert">
                                                <span style="margin-right: 10px">{{session('info')}}</span>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        <div id="errorlocation" class="d-none"></div>
                                        <div class="panel panel-primary">
                                            <form method="POST" action="{{ route('login') }}" id="formLogin">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input class="form-control @error('username') is-invalid @enderror" placeholder="Enter your username" type="text" name="username" value="{{ old('username') }}" autofocus required>

                                                        @error('username')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" type="password" name="password" autocomplete="current-password" required>

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

@section("scripts")
    <script>

        const cookies = {
            get: (name = null) => {
                var allCookieArray = document.cookie.split(';').reduce((a,b) => {
                    var x = b.split("=");
                    var key = x[0].replaceAll(" ","");
                    a[key] = x[1];
                    return a;
                },{})

                if (name) return allCookieArray[name];

                return allCookieArray;
            },
            remove: (dtName) => {
                dtName.forEach(e => {
                    document.cookie = e+"= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
                });
            }
        }

        const loc = {
            init: (state) => {
                navigator.geolocation.getCurrentPosition(loc.success, loc.error, loc.options);
                if (state == "denied"){
                    cookies.remove([
                        "latitude",
                        "longitude",
                        "accuracy",
                    ])
                }
            },
            tmpErr: () => {
                return `
                    <div class="alert alert-danger mg-b-0 alert-dismissible fade show mb-3" role="alert">
                        <span style="margin-right: 10px">Silahkan aktifkan layanan lokasi, untuk melanjutkan</span>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                `;
            },
            options: {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            },
            success: (pos) => {
                loc.showError(false);
                var expTime = new Date();
                expTime.setHours(expTime.getHours()+5);
                const crd = pos.coords;
                document.cookie = "latitude="+crd.latitude+"; expires="+expTime.toGMTString()+"; path=/";
                document.cookie = "longitude="+crd.longitude+"; expires="+expTime.toGMTString()+"; path=/";
                document.cookie = "accuracy="+crd.accuracy+"; expires="+expTime.toGMTString()+"; path=/";
            },
            error: (err) => {
                loc.showError(true);
                console.warn(`ERROR(${err.code}): ${err.message}`);
            },
            showError: (show) => {
                var target = $("#errorlocation");
                if (target.find(".alert").length == 0) target.append(loc.tmpErr());

                if (show) {
                    target.removeClass("d-none");
                }else{
                    target.addClass("d-none");
                }

            }

        }

        navigator.permissions.query({ name: 'geolocation' }).then((e) => {
            loc.init(e.state);
            e.onchange = () => loc.init(e.state);
        });

        $("#formLogin").submit(function(e) {
            var lati = cookies.get("latitude");
            var long = cookies.get("longitude");
            var accu = cookies.get("accuracy");

            if (lati == undefined && long == undefined && accu == undefined) {
                e.preventDefault();
                loc.showError(true);
            }else{
                loc.showError(false);
            }

        })


    </script>
@endsection

