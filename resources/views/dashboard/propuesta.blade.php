@extends('layouts.dashboard')

@section('title', 'Propuesta')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>PROPUESTA</h4>
		</div>
		<div class="dashboard-body">
			<h4>ID: propuesta: {{$propuesta->id}}</h4>

			<h3 class="wt-m-top-5">Detalles del evento</h3>
			<div>
				<div class="wt-space-block">
					<label>Espacio:</label>
					<span>{{$espacio->name}}.</span>
				</div>
				<div class="wt-space-block">
					<label>Anfitrión:</label>
					<span>{{$espacio->user->firstname}}.</span>
				</div>
				<div class="wt-space-block">
					<label>Tipo actividad:</label>
					<span>{{$propuesta->catname}} ({{$propuesta->invitados}} invitados).</span>
				</div>
				<div class="wt-space-block">
					<label>Fecha del evento:</label>
					<span>Desde {{$propuesta->reserva_desde}} hasta {{$propuesta->reserva_hasta}}.</span>
				</div>
			</div>
			<h3>Detalles del presupuesto</h3>
			<div>
				<div class="wt-space-block">
					<label>Vencimiento propuesta:</label>
					<span>{{$propuesta->vencimiento_propuesta}}.</span>
				</div>
				<div class="wt-space-block">
					<label>Depósito de seguridad:</label>
					<span>${{$propuesta->deposito}}.-</span>
				</div>
				<div class="wt-space-block">
					<label>Política de cancelación:</label>
					<span>{{$propuesta->cancellationflexibility}}.</span>
				</div>
			</div>
			@if($propuesta->condiciones != null)
			<h3>Condiciones generales</h3>
			<p>{{$propuesta->condiciones}}.</p>
			@endif
			@if($userId == $propuesta->cliente_id)
			<div class="wt-m-top-3">
				<a href="{{url('/dashboard/user/'. $userId . '/confirmar/'.$propuesta->id)}}">
					<button class="dashboard-btn-primary">ALQUILAR</button>
				</a>
				<a href="{{url('/api/propuesta/'. $propuesta->id . '/rechazada')}}">
					<button class="dashboard-btn-transparent">Rechazar propuesta</button>
				</a>
			</div>
			@endif
		</div>
		<div class="aside-propuesta">
			<div>
				<img src="/{{$espacio->images[0]->name}}" alt="{{$espacio->name}}" class="img-responsive">
			</div>
			<div class="propuesta-datos">
				<h3>{{$espacio->name}}</h3>
				<span>Desde {{$propuesta->reserva_desde}} hasta {{$propuesta->reserva_hasta}}</span>
				<div>
					<div class="wt-space-block">
						<label>Espacio (por {{$evento->total_horas}}hs)</label>
						<span>${{number_format($propuesta->sub_total, 2, '.', ',')}}.-</span>
					</div>
					<div class="wt-space-block">
						<label>IVA</label>
						<span>${{number_format($propuesta->monto_iva, 2, '.', ',')}}.-</span>
					</div>
					<div class="wt-space-block">
						<label>Subtotal</label>
						<span>${{number_format($propuesta->monto_con_iva, 2, '.', ',')}}.-</span>
					</div>
					<div class="wt-space-block">
						<label>Fee</label>
						<span>${{number_format($propuesta->fee, 2, '.', ',')}}.-</span>
					</div>
					<div class="propuesta-datos__total">
						<label>Total</label>
						<h3>${{number_format($propuesta->total, 2, '.', ',')}}.-</h3>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection