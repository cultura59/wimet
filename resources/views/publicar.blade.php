@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
<section class="section-publica">
	<div class="container-left">
		<index-publica 
			step="{{$step}}" 
			espacio-id="{{$espacioId}}" 
			enviar-validacion="{{$enviarValidacion}}">
		</index-publica>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection