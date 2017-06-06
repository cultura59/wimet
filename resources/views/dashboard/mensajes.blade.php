@extends('layouts.notfix')

@section('title', 'Mensajes')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h2>Mensajes</h2>
		</div>
		<div class="dashboard-body">
			<dasboard-chats evento-id="{{$eventoId}}"></dasboard-chats>
		</div>
	</section>

@endsection