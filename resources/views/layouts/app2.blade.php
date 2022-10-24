<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Nowa – Laravel Bootstrap 5 Admin & Dashboard Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin dashboard, admin dashboard laravel, admin panel template, blade template, blade template laravel, bootstrap template, dashboard laravel, laravel admin, laravel admin dashboard, laravel admin panel, laravel admin template, laravel bootstrap admin template, laravel bootstrap template, laravel template"/>

		<!-- Title -->
		<title> @yield('title') </title>

        @include('layouts.components.styles')

	</head>

	<body class="ltr main-body app sidebar-mini dark-theme">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div>
                @include('layouts.components.app-header2')

                @include('layouts.components.app-sidebar')
			</div>

			<!-- main-content -->
			<div class="main-content app-content" style="margin-top: 63px;">

				<!-- container -->
				<div class="main-container container-fluid">

                    @yield('content')

				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

            @include('layouts.components.modal')

            @yield('modal')

            @include('layouts.components.footer')

		</div>
		<!-- End Page -->

        @include('layouts.components.scripts')

        @include('layouts.components.toast-notification')

        <script>
            document.addEventListener("swal:confirm", e => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('deleteData', e.detail.id);
                    }
                })
            })

            $(document).ready(function() {
                changeImg();
                $('.layout-setting').click(function() {
                    changeImg();
                })
            });

            function changeImg() {
                var target = $('.profile-user'),
                    nama = target.data("name"),
                    img = $('.img-profile');
                if ($('body').hasClass('dark-theme')) {
                    img.attr("src", `https://ui-avatars.com/api/?name=${nama}&bold=true&background=cdcbcb&color=2b2d3e`);
                }else{
                    img.attr("src", `https://ui-avatars.com/api/?name=${nama}&bold=true&background=00cbb4&color=fff`);
                }
            }
        </script>

        @if (\Session::has('gitsuccess'))
            <script>
                Swal.fire(
                    'Success',
                    "{{Session::get('gitsuccess')}}",
                    'success'
                )
            </script>
        @endif

        @if (\Session::has('giterror'))
            <script>
                Swal.fire(
                    'Error',
                    "{{Session::get('giterror')}}",
                    'error'
                )
            </script>
        @endif


    </body>
</html>
