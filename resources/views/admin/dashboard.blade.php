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

		<title>{{ config('app.name', 'Laravel') }} - Admin</title>

		<!-- Styles -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<div id="adminApp">
			<!-- Header Home -->
			<nav class="nav-extended">
				<div class="nav-wrapper">
					<a href="/" class="brand-logo right">
						<img class="responsive-img" src="https://res.cloudinary.com/wimet/image/upload/wimet-logo-white_z3tlgh.svg" alt="Wimet" style="margin: 1em;width: 250px;"/>
					</a>
				</div>
				<div class="nav-content">
					<ul class="tabs tabs-transparent">
						<li class="tab"><router-link to="/admin/">Usuarios</router-link></li>
						<li class="tab"><router-link to="/admin/espacios">Espacios</router-link></li>
						<li class="tab"><router-link to="/admin/eventos">Eventos</router-link></li>
					</ul>
				</div>
			</nav>
			<!-- main -->
			<main class="container">
				<router-view></router-view>
			</main>
		</div>
		<script src="{{url('/js/app.js')}}"></script>
	</body>
</html>