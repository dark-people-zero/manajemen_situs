<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Manajemen Situs SMB">
		<meta name="Author" content="Dark People Zero">
		<!-- Title -->
		<title> Manajemen Situs SMB </title>

        @include('layouts.components.styles')
	</head>

	<body class="ltr main-body app sidebar-mini fixed-layout layout-fullwidth ltr sidebar-gone closed-menu sidenav-toggled dark-theme">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">
			{{-- <div>
                @include('layouts.components.app-header')
			</div>
			<div class="main-content app-content">
				<div class="main-container container-fluid p-0">

                    @yield('content')

				</div>
			</div> --}}

            @yield('content')

            {{-- @include('layouts.components.sidebar-right') --}}

            {{-- @include('layouts.components.modal') --}}

            @yield('modal')
		</div>
		<!-- End Page -->

        @include('layouts.components.scripts')

    </body>
</html>
