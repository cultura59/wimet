@extends('layouts.app')

@section('title', 'Consultas')

@section('content')

	@include('dashboard.menue')

	<section class="container">
		<h1 class="wt-m-bot-4"><b>Consultas</b> a mis espacios</h1>
		<!-- Tabla de ultimas consultas -->
		<div class="table-responsive">
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
	</section>

@endsection