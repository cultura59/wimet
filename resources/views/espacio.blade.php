@extends('layouts.app')

@section('title', $espacio->name)

@push('scripts')

	<script>
		$(window).scroll(function(){
			if ($(this).scrollTop() > 400) {
				$('.box-reserva').css('position','fixed').css('top','10%').css('right', '10%');
			} else {
				$('.box-reserva').css('position','absolute').css('top', '-4rem').css('right', '0');
			}
		});	
	</script>

	<script>
		var map;
		function initMap() {
			map = new google.maps.Map(document.getElementById('map-espacio'), {
				center: new google.maps.LatLng(-34.5969302, -58.5159385),
				zoom: 12,
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
				icon: 'http://www.wimet.co/img/favicon.ico',
				map: map
			});
		}
	</script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArSoMrIsnDeERvlCOGJ2WVd36zO2SBTMo&callback=initMap" async defer></script>

@endpush

@section('content')

<section class="profile-space">
    <!-- Slider -->
	<div class="slideshow-container">
		<div class="mySlides slide-fade">
			<a rel="gallery-1" href="{{url($espacio->images[0]->name)}}" class="swipebox" tilte="{{$espacio->name}}">
				<img id="single_image" src="{{url($espacio->images[0]->name)}}" style="width:100%;max-height: 34rem;">
			</a>
			<div style="display: none;">
				@foreach($espacio->images as $key => $image)
					@if($key != 0)
					<a rel="gallery-1" href="{{url($image->name)}}" class="swipebox" tilte="{{$espacio->name}}">
						<img id="single_image" src="{{url($image->name)}}" style="width:100%">
					</a>
					@endif
				@endforeach
			</div>
		</div>

		<a rel="gallery-1" class="prev">&#10094;</a>
		<a rel="gallery-1" class="next">&#10095;</a>
	</div>

	<!-- Detalle espacio -->
	<div class="detail-space container">
		<div class="row">
			<div class="col-sm-8">
				<div class="detalle">
					<h2>{{$espacio->name}}</h2>
					<p>{{$espacio->city}} / {{$espacio->state}}</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box-reserva" ng-app="appEspacio">
					<div class="box-reserva__header">
						<div class="header__encabezados">
							<span>Desde</span>
						</div>
						<div class="header__precio">
							<p>$ {{$price->price}}.- ARS <span> por hora (mímino {{$price->minhours}} hr)</span></p>
						</div>
					</div>
					<div class="box-reserva__body" ng-controller="espacioCtrl" data-ng-init="setPrice({{$price->price}}, {{$espacio->id}})">
						<div class="row">
							<div class="col-sm-6 wt-center-column">
								<input type="hidden" ng-model="priceHs" ng-value="{{$price->price}}">
								<label for="fecha">Tipo de actividad</label>
								{!! Form::select('categoria', 
									$categorias, 
									Request::input('categoria'), 
									['class' => 'wt-select', 'placeholder' => 'Selecciona']
								) !!}
							</div>
							<div class="col-sm-6 wt-center-column">
								<input type="hidden" ng-model="priceHs" ng-value="{{$price->price}}">
								<label for="fecha">Cantidad de invitados</label>
								{!! Form::select('categoria', 
									$categorias, 
									NULL, 
									['class' => 'wt-select', 'placeholder' => 'Selecciona']
								) !!}
							</div>
						</div>
						<div class="row wt-m-top-2 wt-m-bot-2">
							<div class="col-sm-6 wt-center-column">
								<label for="fecha">Fecha</label>
								<input type="date" name="fecha" ng-model="date" class="wt-input">
							</div>
							<div class="col-sm-3 wt-center-column">
								<label for="fecha">Inicio</label>
								{!! Form::selectRange('inicio', 1, 24, null, ['class' => 'wt-select', 'ng-model' => 'inicio', 'placeholder' => 'Hr']) !!}
							</div>
							<div class="col-sm-3 wt-center-column">
								<label for="fin">Fin</label>
								{!! Form::selectRange('fin', 1, 24, null, ['class' => 'wt-select', 'ng-model' => 'fin', 'placeholder' => 'Hr']) !!}
							</div>
						</div>
						<span class="body__add-date-time" ng-click="addDateTimes()">Agregar fecha</span>
						<ul>
							<li ng-repeat="fecha in datesTimes">
								@{{convertDate(fecha.date)}}, de @{{fecha.inicio}} a @{{fecha.fin}}hs.
							</li>
						</ul>
						<div class="box-reserva__totales">
							<p class="wt-m-top-2">PRECIO</p>
							<div class="wt-space-block">
								<span>${{$price->price}} X @{{houres}}hs</span>
								<span>$@{{subTotal}}.-</span>
							</div>
							<div class="wt-space-block">
								<span>Fee de administración (5%)</span>
								<span>$@{{fee}}.-</span>
							</div>
							<hr>
							<div class="wt-space-block">
								<strong>Total</strong>
								<strong>$@{{total}}.-</strong>
							</div>
						</div>
						<div class="box-reserva_compartir wt-center-block">
							<input ng-click="reservar()" class="btn wt-btn-primary" value="Reservar">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="detail-space__info">
		<div class="container">
			<!-- Descripcion -->
			<div class="wt-content-grid wt-m-bot-5">
				<div class="wt-content-grid__left">
					<p>Espacio</p>
				</div>
				<div class="wt-content-grid__right">
					<div class="row">
						<div class="col-md-3">
							<p><span class="text-bold">Ambientes:</span> {{$espacio->quantyrooms}}</p>
						</div>
						<div class="col-md-3">
							<p><span class="text-bold">Baños:</span> {{$espacio->quantybathrooms}}</p>
						</div>
						<div class="col-md-3">
							<p><span class="text-bold">Pisos:</span> {{$espacio->floor}}</p>
						</div>
						<div class="col-md-3">
							<p><span class="text-bold">Superficie:</span> {{$espacio->surface}}m2</p>
						</div>
					</div>
					<p>{{$espacio->description}}</p>
				</div>
			</div>
			<!-- Anfitrion -->
			<div class="wt-content-grid wt-m-bot-5">
				<div class="wt-content-grid__left">
					<p>Anfitrión</p>
				</div>
				<div class="wt-content-grid__right">
					<p>{{$espacio->user->personaldescription}}</p>
				</div>
			</div>
			<!-- Precio -->
			<div class="wt-content-grid wt-m-bot-5">
				<div class="wt-content-grid__left">
					<p>Precio</p>
				</div>
				<div class="wt-content-grid__right">
					<img src="{{url('img/ic_query_builder_black_18dp_1x.png')}}">  ${{$price->price}}
					<p>mínimo {{$price->minhours}} horas</p>
				</div>
			</div>
			<!-- Amenities -->
			<div class="wt-m-bot-5">
				<p class="amenities__tilte">Amenities</p>
				<div class="col-md-8">
					<div class="row">
						@foreach($espacio->servicios as $servicio)
							<div class="col-md-4">
								<img src="{{url('img/ic_done_black_16dp_1x.png')}}"> {{$servicio->nombre}}
							</div>
						@endforeach
					</div>
				</div>
			</div><br><br><br><br><br><br>
			<!-- Accesos -->
			<div class="wt-m-bot-5">
				<p class="amenities__tilte">Acceso</p>
				<div class="col-md-8">
					<div class="row">
						@foreach($espacio->access as $access)
							<div class="col-md-4">
								<img src="{{url('img/ic_done_black_16dp_1x.png')}}"> {{$access->nombre}}
							</div>
						@endforeach
					</div>
				</div>
			</div><br><br>
			<!-- Accesos -->
			<div class="wt-m-bot-5">
				<p class="amenities__tilte">Normas de espacio</p>
				<div class="col-md-8">
					<div class="row">
						@foreach($espacio->rules as $rule)
							<div class="col-md-4">
								<img src="{{url('img/ic_not_interested_black_18dp_1x.png')}}"> {{$rule->nombre}}
							</div>
						@endforeach
					</div>
				</div>
			</div><br><br>
			<!-- Mapa -->
			<div class="anfitrion wt-m-bot-5">
				<div id="map-espacio"></div>
			</div>
			<!-- Reserva -->
			<div class="wt-content-grid wt-m-bot-5">
				<div class="wt-content-grid__left">
					<p>Cancelación y depósito de garantía</p>
				</div>
				<div class="wt-content-grid__right">
					<p>Depósito de garantía: {{$espacio->cancellationflexibility}}</p>
					<p>{{$espacio->rule}}</p>
					<p>Pilítica de cancelación: ${{$espacio->securitydeposit}}.-</p>
					<p>{{$espacio->politcancel}}</p>
				</div>
			</div>
		</div>
	</div>

</section>
@endsection