@extends('layouts.dashboard')

@section('title', 'Confirmación')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>CONFIRMACIÓN RESERVA</h4>
		</div>
		<div class="dashboard-body">
			<h3>1. Datos de contacto</h3>
			<a href="{{ $preference['response']['init_point'] }}">Pay</a>

			<!-- Aquí debes insertar la URL que corresponde al "init_point" -->
			<a href="{{ $preference['response']['sandbox_init_point'] }}" mp-mode="popup">Pagar Sandbox</a>

			<!-- Pega este código antes de cerrar la etiqueta </body> -->
			<script type="text/javascript">
			(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
			</script>
		</div>
	</section>

@endsection