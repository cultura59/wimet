@extends('layouts.dashboard')

@section('title', 'Confirmación')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>CONFIRMACIÓN RESERVA</h4>
		</div>
		<div class="dashboard-body">
			<!-- Para hacer las pruebas en produccion reemplazar "sandbox_init_point" por "init_point" -->
			<dasboard-confirmar url="{{ $preference['response']['init_point'] }}"></dasboard-confirmar>
		</div>
	</section>

@endsection