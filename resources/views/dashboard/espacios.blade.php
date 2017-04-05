@extends('layouts.app')

@section('title', 'Mis espacios')

@section('content')

	@include('dashboard.menue')

	<section class="dashboard-container">
		<div class="main-container">
			<h3>PUBLICADOS</h3>
			<div class="container-espacios">
			@foreach($espacios as $espacio)
				<div class="box-expacio">
					<div class="image-espacio">
						@if(!$espacio->images->isEmpty())
						<img src="{{url($espacio->images[0]->name)}}" alt="" class="img-responsive">
						@endif
					</div>
					<div class="detalle-espacio">
						<div class="detalle-espacio__title">
							<h3>{{$espacio->name}}</h3>
							<div>
								<a href="{{route('publica-steps', array('espacioId' => $espacio->id, 'step' => 4))}}">
									<i class="fa fa-pencil fa-2x" aria-hidden="true"></i>
								</a>
								<i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
							</div>
						</div>
						<ul class="list-inline">
						@foreach($espacio->categorias as $cat)
							<li>{{$cat->name}}</li>
						@endforeach
						</ul>
					</div>
				</div>
			@endforeach
			</div>
		</div>
		<div class="main-container">
			<h3>BORRADOR</h3>
			<div class="container-espacios">
			@foreach($borradores as $borrador)
				<div class="box-expacio">
					<div class="image-espacio">
						@if(!$borrador->images->isEmpty())
						<img src="{{url($borrador->images[0]->name)}}" alt="" class="img-responsive">
						@endif
					</div>
					<div class="detalle-espacio">
						<div class="detalle-espacio__title">
							<h3>{{$borrador->name}}</h3>
							<div>
								<a href="{{route('publica-steps', array('espacioId' => $borrador->id, 'step' => 4))}}">
									<i class="fa fa-pencil fa-2x" aria-hidden="true"></i>
								</a>
								<i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
							</div>
						</div>
						<ul class="list-inline">
						@foreach($espacio->categorias as $cat)
							<li>{{$cat->name}}</li>
						@endforeach
						</ul>
					</div>
				</div>
			@endforeach
			</div>
		</div>
	</section>

@endsection