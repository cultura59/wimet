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
				<p>El título de una publicación debe concentrar en una frase el diferencial de tu espacio o lo que te hace sentir. Recuerda no poner nombres comerciales ni direcciones.
En el campo de descripción, explaya tu espacio a grandes rasgos para que los organizadores puedan hacerse una idea general antes de entrar en detalles contigo. También puedes utilizar la descripción para resaltar las cualidades que tiene el mismo en las diversas actividades en que lo inscribas.</p>
				<p>No te olvides de agregar la disponibilidad de tu espacio.</p>
				<p>Ejemplo:</p>
				<ul>
					<li>Lunes ....................... 09:00hs - 23:00hs</li>
					<li>Martes ...................... 09:00hs - 23:00hs</li>
					<li>Miércoles .................. 09:00hs - 23:00hs</li>
					<li>Jueves ...................... 09:00hs - 01:00hs</li>
					<li>Viernes ..................... 09:00hs - 02:00hs</li>
					<li>Sábado ..................... 09:00hs - 03:00hs</li>
					<li>Domingo ................... 09:00hs - 23:00hs</li>
				</ul>
			</div>
		</div>
	</div>
</section>
@endsection