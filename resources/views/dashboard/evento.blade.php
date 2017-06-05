@extends('layouts.notfix')

@section('title', 'Evento')

@section('content')

	<aside-dashboard selected="eventos"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h2>Evento</h2>
		</div>
		<dasboard-evento evento-id="{{$eventoId}}"></dasboard-evento>
	</section>

@endsection