@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		</div>
	</div>
	<div class="container-left">
		<publica-index></publica-index>
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<ul>
					<li>Ingresos adicionales</li>
					<li>Gratis</li>
					<li>Espacios curados</li>
					<li>Libertad</li>
					<li>Transparencia</li>
					<li>Seguridad</li>
				</ul>
				<span>Suma tu espacio, comparte la experiencia</span>
			</div>
		</div>
	</div>
</section>

@endsection