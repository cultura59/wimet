@extends('layouts.dashboard')

@section('title', 'Mensajes')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>MENSAJES</h4>
		</div>
		<div class="dashboard-body">
			<dasboard-chats evento-id="{{$evento->id}}"></dasboard-chats>
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
				<h4>Propuestas recibidas</h4>
				<table class="table">
					<tr>
						<th>Número</th>
						<th>Creación</th>
						<th>Enviada</th>
						<th colspan="2">Importe</th>
					</tr>
					@foreach($propuestas as $propuesta)
					<tr>
						<td>{{$propuesta->id}}</td>
						<td>{{$propuesta->reserva_desde}}</td>
						<td>{{$propuesta->created_at}}</td>
						<td>${{$propuesta->sub_total}}</td>
						<td>
							<a href="{{url('/dashboard/user/'.$userId.'/evento/'.$evento->id.'/propuesta/'.$propuesta->id.'')}}">
								<i class="fa fa-check-square-o" aria-hidden="true"></i>
							</a>
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</section>

@endsection