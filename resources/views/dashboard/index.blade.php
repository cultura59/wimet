@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

	@include('dashboard.menue')

	<section class="container">
		<h1 class="wt-m-bot-4"><b>Dashboard</b> panel de control</h1>
		<div class="row">
			<div class="col-xs-12 col-md-4">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>150</h3>
						<p>Reservas</p>
					</div>
					<div class="icon">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					</div>
					<a href="{{url('/dashboard/user/1/reservas')}}" class="small-box-footer">
						<span>Más información</span>
						<i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>65</h3>
						<p>Consultas</p>
					</div>
					<div class="icon">
						<i class="fa fa-question" aria-hidden="true"></i>
					</div>
					<a href="{{url('/dashboard/user/1/consultas')}}" class="small-box-footer">
						<span>Más información</span>
						<i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>165</h3>
						<p>Favoritos</p>
					</div>
					<div class="icon">
						<i class="fa fa-star" aria-hidden="true"></i>
					</div>
					<a href="{{url('/dashboard/user/1/favoritos')}}" class="small-box-footer">
						<span>Más información</span>
						<i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- Tabla de ultimas consultas -->
		<div class="table-responsive">
			<h3>Últimas Consultas</h3>
			<table class="table table-striped">
				<tr>
					<th class="text-center">Espacio</th>
					<th class="text-center">E-mail</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Apellido</th>
					<th class="text-center">Fecha</th>
					<th class="text-center">Total</th>
					<th class="text-center">Acción</th>
				</tr>
				<tr>
					<td class="text-center">Area 3</td>
					<td class="text-center">rojasadrian.e@gmail.com</td>
					<td class="text-center">Adrián</td>
					<td class="text-center">Rojas</td>
					<td class="text-center">14/02/2017</td>
					<td class="text-center">$13670</td>
					<td class="text-center">
						<a href="{{url('/dashboard/user/1/consulta/1')}}" title="ver">
							<i class="fa fa-external-link" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<!-- Tabla de ultimas reservas -->
		<div class="table-responsive">
			<h3>Últimas reservas</h3>
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