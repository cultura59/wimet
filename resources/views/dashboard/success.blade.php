@extends('layouts.dashboard')

@section('title', 'Pago de la propuesta')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>Propuesta aprobada</h4>
		</div>
		<div class="dashboard-body-fluid">
		@if($estado == 'ok')
			<h1>La propuesta número: {{$id}} fue confirmada</h1>
			<h3>El pago ya fue acreditado.</h3>
		@elseif($estado == 'error')
			<h1>La propuesta número: {{$id}} no fue confirmada</h1>
			<h3>El pago fue cancelado o hubo un problema con mercado pago</h3>
			<h4>Pongase en contacto con soporte@wimet.co.</h4>
		@else
			<h1>La propuesta número: {{$id}} fue confirmada</h1>
			<h3>Aguarde a que se acredite el pago.</h3>
		@endif
		</div>
	</section>

@endsection