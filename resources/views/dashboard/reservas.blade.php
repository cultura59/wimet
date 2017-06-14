@extends('layouts.dashboard')

@section('title', 'Reservas')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>RESERVAS</h4>
		</div>
		<div class="dashboard-body-fluid">
			<dasboard-eventos></dasboard-eventos>
		</div>
	</section>

@endsection