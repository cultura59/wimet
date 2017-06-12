@extends('layouts.notfix')

@section('title', 'Mensajes')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>MENSAJES</h4>
		</div>
		<dasboard-mensajes></dasboard-mensajes>
	</section>

@endsection