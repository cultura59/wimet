@extends('layouts.notfix')

@section('title', 'Mis espacios')

@section('content')

	@include('dashboard.menue', array("id" => Auth::user()->id, "selected" => "consultas"))

	<section class="dashboard-container">
		<div class="main-container">
			<h3>PRÓXIMAMENTE</h3>
		</div>
	</section>

@endsection