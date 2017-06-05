@extends('layouts.notfix')

@section('title', 'Nueva propuesta')

@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h2>Propuesta</h2>
		</div>
		<dasboard-nueva-propuesta 
			evento-id="{{$eventoId}}"
			securitydeposit="{{$securitydeposit}}"
			cancellationflexibility="{{$cancellationflexibility}}">
		</dasboard-nueva-propuesta>
	</section>

@endsection