@extends('layouts.dashboard')

@section('title', 'Nueva propuesta')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>PROPUESTA</h4>
		</div>
		<div class="dashboard-body">
			<dasboard-nueva-propuesta 
				evento-id="{{$evento->id}}"
				securitydeposit="{{$espacio->securitydeposit}}"
				cancellationflexibility="{{$espacio->cancellationflexibility}}">
			</dasboard-nueva-propuesta>
		</div>
		<div class="aside-propuesta">
			<div>
				<img src="/{{$espacio->images[0]->name}}" alt="{{$espacio->name}}" class="img-responsive">
			</div>
			<div class="propuesta-datos">
				<h3>{{$espacio->name}}</h3>
				<span>Desde {{$evento->reserva_desde}} hasta {{$evento->reserva_hasta}}</span>
				<div>
					<div class="wt-space-block">
						<label>Espacio (por {{$evento->total_horas}}hs)</label>
						<span>${{number_format($evento->sub_total, 2, '.', ',')}}.-</span>
					</div>
					<div class="propuesta-datos__total">
						<label>Total</label>
						<h3>${{number_format($evento->sub_total, 2, '.', ',')}}.-</h3>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection