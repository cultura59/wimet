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
			<!-- Template login -->
			<template v-if="!logued">
				<div class="container">
					<div>
						<img src="https://res.cloudinary.com/wimet/image/upload/v1503064340/wimet-logo_frbya5.svg" alt="Wimet">
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input id="user" type="text" v-model="u">
							<label for="user">Usuario</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input id="password" type="password" v-model="p">
							<label for="password">Password</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<button class="waves-effect btn" @click="l()">Login</button>
						</div>
					</div>
				</div>
			</template>
			<!-- Template de vistas -->
			<template v-if="logued">
				<!-- Header Home -->
				<nav class="nav-extended">
					<div class="nav-wrapper">
						<a href="/" class="brand-logo right">
							<img class="responsive-img" src="https://res.cloudinary.com/wimet/image/upload/wimet-logo-white_z3tlgh.svg" alt="Wimet" style="margin: 1em;width: 250px;"/>
						</a>
					</div>
					<div class="nav-content">
						<ul class="tabs tabs-transparent">
							<li class="tab"><router-link to="/">Home</router-link></li>
							<li class="tab"><router-link to="/usuarios">Usuarios</router-link></li>
							<li class="tab"><router-link to="/espacios">Espacios</router-link></li>
							<li class="tab"><router-link to="/eventos">Eventos</router-link></li>
							<li class="tab"><router-link to="/eventos2">Eventos Trello</router-link></li>
						</ul>
					</div>
				</nav>
				<!-- main -->
				<main style="margin:1em;">
					<router-view></router-view>
				</main>
			</template>
		</div>
		<script src="{{url('/js/admin.js')}}"></script>
		<!-- Compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
	</body>
</html>