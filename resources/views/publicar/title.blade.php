@extends('layouts.app')

@section('title', 'Publicar')

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'saveespacio', 'method' => 'POST')) !!}
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		<input type="hidden" name="id" value="{{$espacio->id}}">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
			</div>
		</div>

		<div class="container-center">
			<div>
				<h2>¡Cuéntale al mundo acerca de tu espacio!</h2>
				<div class="wt-m-top-4">
					<p class="text-bold">Título de tu espacio</p>
					<input type="text" class="wt-custom-input" name="name" value="{{$espacio->name}}" placeholder="Ingrese el titulo de su espacio" required>
					<p>50 caracteres</p>
				</div>
				<div class="wt-m-top-4">
					<label class="text-bold">Descripción</label>
					<textarea name="description" name="description" rows="10" class="wt-textarea" value="{{$espacio->description}}" placeholder="Escriba una breve descripción de su espacio, que lo caracteriza y cuales son sus mejores aspectos."></textarea>
				</div>
			</div>
		</div>

		<div class="buttons">
			<a href="{{ url()->previous() }}" class="btn">ATRÁS</a>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection