@extends('layouts.notfix')

@section('title', 'Publicar')

@section('content')
<section class="section-publica">
	<index-publica 
		step="{{$step}}" 
		espacio-id="{{$espacioId}}" 
		enviar-validacion="{{$enviarValidacion}}">
	</index-publica>
</section>
@endsection