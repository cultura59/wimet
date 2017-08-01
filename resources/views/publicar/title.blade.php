@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
		</div>
	</div>
	<div class="container-left">
		<navbar-segundo espacio-id="{{$espacioId}}" url="titulo"></navbar-segundo>
		<publica-title espacio-id="{{$espacioId}}"></publica-title>
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<p>El título de una publicación debe concentrar en una frase el diferencial de tu espacio o lo que te hace sentir. Recuerda no poner nombres comerciales ni direcciones. En el campo de descripción, explaya tu espacio a grandes rasgos para que los organizadores puedan hacerse una idea general antes de entrar en detalles contigo. Además, puedes utilizar la descripción para resaltar las cualidades que tiene el mismo en las diversas actividades en que lo inscribas.</p>
				<p>Una vez que hayas terminado escribe la zona en la que se encuentra tu espacio.</p>
				<p>Ejemplo:</p>
				<p>Zona: Palermo</p>
				<p>*Si tienes dudas de cómo escribir, busca otros perfiles en la plataforma e inspírate.</p>
			</div>
		</div>
	</div>
</section>
@endsection