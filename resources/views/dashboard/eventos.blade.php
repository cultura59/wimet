@extends('layouts.dashboard')

@section('title', 'Embudo de ventas')

@section('content')

	<aside-dashboard selected="eventos"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>EMBUDO DE VENTAS</h4>
		</div>
		<div class="dashboard-body-fluid">
			<table class="table-dashboard-eventos">
				<tr>
					<th class="th-1">
						<div class="wt-space-block">
							<span>Total</span>
							<span>{{$countTotal}}</span>
						</div>
					</th>
					<th class="th-2">
						<div class="wt-space-block">
							<span>Consulta</span>
							<span>{{$countConsultas}}</span>
						</div>
					</th>
					<th class="th-3">
						<div class="wt-space-block">
							<span>Seguimiento</span>
							<span>{{$countSeguimiento}}</span>
						</div>
					</th>
					<th class="th-4">
						<div class="wt-space-block">
							<span>Visita</span>
							<span>{{$countVisita}}</span>
						</div>
					</th>
					<th class="th-5">
						<div class="wt-space-block">
							<span>Presupuesto</span>
							<span>{{$countPresupuesto}}</span>
						</div>
					</th>
					<th class="th-6">
						<div class="wt-space-block">
							<span>Reservado</span>
							<span>{{$countReservado}}</span>
						</div>
					</th>
					<th class="th-7">
						<div class="wt-space-block">
							<span>Realizado</span>
							<span>{{$countRealizado}}</span>
						</div>
					</th>
					<th class="th-8">
						<div class="wt-space-block">
							<span>Perdido</span>
							<span>{{$countPerdido}}</span>
						</div>
					</th>	
				</tr>
				<tr>
					<td class="table-dashboard-eventos__td">Total: ${{$sumTotal}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumConsultas}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumSeguimiento}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumVisita}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumPresupuesto}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumReservado}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumRealizado}}</td>
					<td class="table-dashboard-eventos__td">Total: ${{$sumPerdido}}</td>
				</tr>
			</table>
			<dasboard-eventos></dasboard-eventos>
		</div>
	</section>

@endsection