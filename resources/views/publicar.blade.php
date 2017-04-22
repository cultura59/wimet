@extends('layouts.app')

@section('title', 'Publicar')

@section('content')
<section class="section-publica">
	<div class="container-left">
		<div class="content-publica">
			@if($step == 2)
				<h1>¡Lo estas haciendo muy bien {{ Auth::user()->firstname }}!</h1>
				<p class="sub-title-info">
					Es momento de añadir algo de información sobre tu espacio para que puedas publicarlo.
				</p>
			@endif
			@if($step == 3)
				<h1>¡Excelente trabajo!</h1>
				<p class="sub-title-info">
					Sólo deberás definir tu política de precios para comenzar operar.
				</p>
			@endif
			@if($step == 4)
				<h1>¡Felicitaciones {{ Auth::user()->firstname }}!</h1>
				<p class="sub-title-info">
					Tu espacio será publicado en Wimet.co una vez aprobado por nuestro equipo. Este proceso puede demorar hasta 48 hs.
				</p>
				@if($enviarValidacion)
					<a href="{{url('/dashboard/user/'.Auth::user()->id.'/misespacios')}}">
						<button class="wt-btn-aqua">ENVIAR PARA APROBACIÓN</button>
					</a>
				@else
					<p class="sub-title-info">Para que el espacio sea revisado debe completar Superficie, Accesos, Asistentes de pie, Asistentes sentados, reglas y precio.</p>
				@endif
			@endif
			
			<div class="box-step">
				@if($step >= 1)<i class="fa fa-check fa-4x pull-right" aria-hidden="true"></i>@endif
				<h2 class="Sub-title">Paso 1: Lo escencial</h2>
				<p class="sub-title-info">Tipo de espacio, dirección, etc.</p>
				<a href="{{route('publica-categoria', array('id' => $espacioId))}}" class="link">EDITAR</a>
			</div>
			
			<div class="box-step">
				@if($step > 2)<i class="fa fa-check fa-4x pull-right" aria-hidden="true"></i>@endif
				<h2 class="Sub-title">Paso 2: Muestra tu lugar</h2>
				<p class="sub-title-info">Fotos, descripción, título, etc.</p>
				@if($step == 2)
				<a href="{{route('publica-images', array('id' => $espacioId))}}"><button class="wt-btn-aqua">CONTINUAR</button></a>
				@elseif($step > 2)
				<a href="{{route('publica-images', array('id' => $espacioId))}}" class="link">EDITAR</a>
				@endif
			</div>
			
			<div class="box-step">
				@if($step > 3)<i class="fa fa-check fa-4x pull-right" aria-hidden="true"></i>@endif
				<h2 class="Sub-title">Paso 3: Prepárate para alquilar</h2>
				<p class="sub-title-info">Disponibilidad, reglas del lugar, precio.</p>
				@if($step == 3)
				<a href="{{route('publica-rules', array('id' => $espacioId))}}"><button class="wt-btn-aqua">CONTINUAR</button></a>
				@elseif($step > 3)
				<a href="{{route('publica-rules', array('id' => $espacioId))}}" class="link">EDITAR</a>
				@endif
			</div>
		</div>
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection