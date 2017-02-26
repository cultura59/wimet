@extends('layouts.app')

@section('title', 'Agregar imagenes')

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			</div>
		</div>

		<div class="container-center">
			<h2>Ingrese sus imagenes</h2>
			{!! Form::open(array('url' => 'saveimages', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'wt-custom-input-file')) !!}
				<input type="hidden" name="espacio_id" value="{{$id}}">
				<label for="imagenes">Inserte todas sus imagenes</label>
				<input type="file" id="imagenes" name="imagenes[]" multiple required>
				<input type="submit" value="Guardar" class="btn wt-btn-primary"/>
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