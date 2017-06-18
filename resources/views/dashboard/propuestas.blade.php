@extends('layouts.dashboard')

@section('title', 'Propuestas')

@section('content')

	<aside-dashboard selected="propuestas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>PROPUESTAS</h4>
		</div>
		<div class="dashboard-body-fluid">
			<dasboard-propuestas></dasboard-propuestas>
		</div>
	</section>

@endsection