@extends('layouts.app')

@section('title', 'Reservas')

@section('content')

	@include('dashboard.menue')

	<section class="container">
		<h1 class="wt-m-bot-4"><b>Reservas</b> a mis espacios</h1>
		<!-- Tabla de ultimas reservas -->
		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th class="text-center">Orden Id</th>
					<th class="text-center">Espacio</th>
					<th class="text-center">Solicitante</th>
					<th class="text-center">Total</th>
					<th class="text-center">Estado</th>
					<th class="text-center">Acción</th>
				</tr>
				<tr>
					<td class="text-center">123456</td>
					<td class="text-center">Area 3</td>
					<td class="text-center">Adrián Rojas</td>
					<td class="text-center">$13670</td>
					<td class="text-center"><span class="label label-info">Pendiente</span></td>
					<td class="text-center">
						<a href="{{url('/dashboard/user/1/reserva/1')}}" title="ver">
							<i class="fa fa-external-link" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td class="text-center">123456</td>
					<td class="text-center">Area 3</td>
					<td class="text-center">Adrián Rojas</td>
					<td class="text-center">$13670</td>
					<td class="text-center"><span class="label label-success">Aprobada</span></td>
					<td class="text-center">
						<a href="{{url('/dashboard/user/1/reserva/1')}}" title="ver">
							<i class="fa fa-external-link" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td class="text-center">123456</td>
					<td class="text-center">Area 3</td>
					<td class="text-center">Adrián Rojas</td>
					<td class="text-center">$13670</td>
					<td class="text-center"><span class="label label-danger">Cancelada</span></td>
					<td class="text-center">
						<a href="{{url('/dashboard/user/1/reserva/1')}}" title="ver">
							<i class="fa fa-external-link" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
			</table>
		</div>
	</section>

@endsection