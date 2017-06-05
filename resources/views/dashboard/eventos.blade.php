@extends('layouts.notfix')

@section('title', 'Reservas')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h2>PIPELINE</h2>
		</div>
		<dasboard-eventos></dasboard-eventos>
	</section>

@endsection