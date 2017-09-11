<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
		<meta name="google-site-verification" content="A6bEbj0anLR76S8r9y2oG_7UMuN6YUn4-hYL-ZZFLvs" />

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

		<title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

		<!-- Styles -->
		<link href="/css/app.css" rel="stylesheet">
	</head>
	<body>
		<div id="adminApp">
			<!-- Header Home -->
			<header class="header-with-not-fix">
				<nav class="header-navbar container-fluid">
					<a href="/">
						<img class="img-responsive" src="http://res.cloudinary.com/wimet/image/upload/v1503064340/wimet-logo_frbya5.svg" alt="Wimet" width="158" />
					</a>
					<wimet-login type-login="btn-login link-hov" type-svg="dark" userloged="link-user-dark"></wimet-login>
				</nav>
			</header>
			<!-- main -->
			<main>
				<router-view></router-view>
			</main>
		</div>
		<script src="{{url('/js/app.js')}}"></script>
	</body>
</html>