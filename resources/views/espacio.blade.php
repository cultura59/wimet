@extends('layouts.app')

@section('title', $espacio->name)

@push('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		var map;
		function initMap() {
			map = new google.maps.Map(document.getElementById('map-espacio'), {
				center: new google.maps.LatLng({{$espacio->lat}}, {{$espacio->long}}),
				zoom: 14,
				disableDefaultUI: false,
				scrollwheel: false,
			    navigationControl: false,
			    mapTypeControl: true,
			    scaleControl: false,
			    draggable: false,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng({{$espacio->lat}}, {{$espacio->long}}),
				icon: "{{url('/wimet-ic-espacio-marker.png')}}",
				map: map
			});
		}
		
		(function(){
			$(window).scroll(function(){
				if ($(this).scrollTop() > 560) {
					$('#aside-reserva').removeClass('box-reserva');
					$('#aside-reserva').addClass('box-reserva--active');
				} else {
					$('#aside-reserva').removeClass('box-reserva--active');
					$('#aside-reserva').addClass('box-reserva');
				}
			});	
		})();
	</script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArSoMrIsnDeERvlCOGJ2WVd36zO2SBTMo&callback=initMap" async defer></script>
@endpush

@section('content')

	<div id="home-espacio">
		<aside-reserva 
			espacio-id="{{$espacio->id}}"
			client-id="{{Auth::user()->id}}"
			avatar-url="{{$espacio->user->imagesource}}"
			price="{{$price->price}}"
			minhours="{{$price->minhours}}"
			category-id="{{$categoryId}}">
		</aside-reserva>

		<header-espacio espacio-id="{{$espacio->id}}"></header-espacio>
	
		<main class="home-espacio-body">
			<div class="center-title">
				<h2 class="title">{{$espacio->name}}</h2>
				@if($espacio->status == 1)
					<i class="fa fa-check-circle fa-2x verified" aria-hidden="true" title="Espacio verificado"></i>
				@else
					<i class="fa fa-check-circle fa-2x noverified" aria-hidden="true" title="Espacio no verificado"></i>
				@endif
			</div>
			<div class="direccion">
				<span>{{$espacio->city}}, {{$espacio->state}}</span>
				<span></span>
			</div>
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Espacio</span>
				</div>
				<div class="box-descripcion__contenido">
					<p>{{$espacio->description}}</p>
				</div>
			</div>
			@if($espacio->user->personaldescription != "")
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Anfitrión</span>
				</div>
				<div class="box-descripcion__contenido">
					<p>{{$espacio->user->personaldescription}}</p>
				</div>
			</div>
			@endif
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Precio</span>
				</div>
				<div class="box-descripcion__contenido">
					<div class="wt-center-column">
						<span><b><i class="fa fa-clock-o" aria-hidden="true"></i></b> ${{$price->price}}.-</span>
						<span>mínimo {{$price->minhours}} horas</span>
					</div>
				</div>
			</div>
			<div class="box-amenities wt-m-top-2 wt-m-bot-2">
				<p class="box-amenities__title">Amenities</p>
				<div class="wt-space-block">
					@foreach($espacio->servicios as $servicio)
						<div>
							<i class="fa fa-check" aria-hidden="true"></i>
							<span>{{$servicio->nombre}}</span>
						</div>
					@endforeach
				</div>
			</div>
			<div class="wt-m-top-2 wt-m-bot-2 box-access">
				<div class="row">
					<div class="col-md-6">
						<p class="box-access__title">Acceso</p>
						@foreach($espacio->access as $access)
						<div>
							<i class="fa fa-check" aria-hidden="true"></i>
							<span>{{$access->nombre}}</span>
						</div>
						@endforeach
					</div>
					<div class="col-md-6">
						<p class="box-access__title">Normas del espacio</p>
						@foreach($espacio->rules as $rules)
						<div>
							<i class="fa fa-ban" aria-hidden="true"></i>
							<span>{{$rules->nombre}}</span>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<div id="map-espacio" class="wt-m-top-2"></div>
			<div class="box-descripcion">
				<div class="box-descripcion__titulo">
					<span>Cancelación y depósito de garantía</span>
				</div>
				<div class="box-descripcion__contenido">
					<div class="wt-center-column">
						<span>Cancelación: {{$espacio->cancellationflexibility}}</span>
						<span>Depósito de garantia: ${{$espacio->securitydeposit}}.-</span>
					</div>
				</div>
			</div>
		</main>
	</div>

@endsection