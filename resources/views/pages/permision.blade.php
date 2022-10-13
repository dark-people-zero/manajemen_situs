@extends('layouts.custom-app')

    @section('styles')

    @endsection

    @section('class')

        <div class="bg-primary">

    @endsection

    @section('content')

				<!-- Main-error-wrapper -->
				<div class="main-error-wrapper page page-h">
					<h1 class="text-white">500<span class="tx-20">error</span></h1>
					<h2 class="text-white">Oops. The page you are looking for doesn't exist.</h2>
					<h6 class="tx-white-6">You may have mistyped the address or the page may have moved.</h6>
                    @if ($data)
                        @php
                            $url = '/';
                            if (strtolower($data->name) == 'user') $url = '/user';
                            if (strtolower($data->name) == 'site') $url = '/';
                            if (strtolower($data->name) == 'site data') $url = '/data-situs';
                        @endphp
                        <a class="btn btn-light" href="{{$url}}">Back to Home</a>
                    @else
                        <form action="/logout" method="post" id="logoutPermision">@csrf</form>
                        <a class="btn btn-light" href="javascript:void(0);" onclick="$('#logoutPermision').submit();">Back to Home</a>
                    @endif
				</div>
				<!-- /Main-error-wrapper -->


    @endsection

    @section('scripts')

    @endsection
