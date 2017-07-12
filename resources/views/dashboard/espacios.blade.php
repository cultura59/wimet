@extends('layouts.dashboard')

@section('title', 'Mis espacios')

@section('content')

	<aside-dashboard selected="misespacios"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>ESPACIOS</h4>
		</div>
		<div class="dashboard-body-fluid">
			<div>
				<h4>PUBLICADOS</h4>
				@include('errors/error-notification')
				<div class="container-espacios">
				@foreach($espacios as $espacio)
					<div class="box-expacio">
						<div class="image-espacio">
							@if(!$espacio->images->isEmpty())
							<img src="https://res.cloudinary.com/wimet/image/upload/q_60/{{$espacio->images[0]->name}}" alt="" class="img-responsive">
							@endif
						</div>
						<div class="detalle-espacio">
							<div class="detalle-espacio__title">
								<h3>{{$espacio->name}}</h3>
								<ul class="list-inline">
								@foreach($espacio->categorias as $cat)
									<li>{{$cat->name}}</li>
								@endforeach
								</ul>
							</div>
							<div class="wt-center-column">
								<a href="{{route('publica-steps', array('espacioId' => $espacio->id))}}">
									<button class="btn-primary-pig">MODIFICAR</button>
								</a>
								@if(!$espacio->categorias->isEmpty())
								<a href="{{url('/categoria/'. $espacio->categorias[0]->id .'/espacio/'. $espacio->id)}}" target="_blank" class="wt-m-top-1">
									<button class="btn-primary-transparent">VER ESPACIO</button>
								</a>
								@endif
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>
			<div class="wt-m-top-4">
				<h4>BORRADOR</h4>
				<div class="container-espacios">
				@foreach($borradores as $borrador)
					<div class="box-expacio">
						<div class="image-espacio">
							@if(!$borrador->images->isEmpty())
							<img src="https://res.cloudinary.com/wimet/image/upload/q_60/{{$borrador->images[0]->name}}" alt="" class="img-responsive">
							@endif
						</div>
						<div class="detalle-espacio">
							<div class="detalle-espacio__title">
								<h3>{{$borrador->name}}</h3>
								<ul class="list-inline">
								@foreach($borrador->categorias as $cat)
									<li>{{$cat->name}}</li>
								@endforeach
								</ul>
							</div>
							<div class="wt-center-column">
								<a href="{{route('publica-steps', array('espacioId' => $borrador->id))}}">
									<button class="btn-primary-pig">FINALIZAR</button>
								</a>
								@if(!$borrador->categorias->isEmpty())
								<a href="{{url('/categoria/'. $borrador->categorias[0]->id .'/espacio/'. $borrador->id)}}" target="_blank" class="wt-m-top-1">
									<button class="btn-primary-transparent">VISTA PREVIA</button>
								</a>
								@endif
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>
		</div>
	</section>

@endsection