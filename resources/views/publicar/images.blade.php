@extends('layouts.app')

@section('title', 'Agregar imagenes')

@push('scripts')
	<script>

	</script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			</div>
		</div>

		<div class="container-center">
			<h2>Ingrese sus imagenes</h2>
			{!! Form::open(array('url' => 'savecategories', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'wt-custom-input-file')) !!}
				<input type="hidden" name="id" value="{{$id}}">
				<label for="imagenes">Inserte todas sus imagenes</label>
				<input type="file" id="imagenes" multiple>
			{!! Form::close() !!}
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection