@extends('layouts.app')

@section('title', $espacio->name)

@push('scripts')
	
	<script>
		// Script Slider
		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
		  showSlides(slideIndex += n);
		}

		function showSlides(n) {
	  		var i;
			var slides = document.getElementsByClassName("mySlides");
			
			if (n > slides.length) {slideIndex = 1} 
			
			if (n < 1) {slideIndex = slides.length}
			
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none"; 
			}
			
			slides[slideIndex-1].style.display = "block"; 
		}
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
				position: new google.maps.LatLng({{$espacio->long}}, {{$espacio->lat}}),
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
			<img src="http://www.w3schools.com/howto/img_nature_wide.jpg" style="width:100%">
		</div>

		<div class="mySlides slide-fade">
			<img src="http://www.w3schools.com/howto/img_fjords_wide.jpg" style="width:100%">
		</div>

		<div class="mySlides slide-fade">
			<img src="http://www.w3schools.com/howto/img_mountains_wide.jpg" style="width:100%">
		</div>

		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>
	</div>
	<!-- Detalle espacio -->
	<div class="detail-space container">
		<div class="row">
			<div class="col-sm-7">
				<div class="detalle">
					<h2>{{$espacio->name}}</h2>
					<p>{{$espacio->city}} / {{$espacio->state}}</p>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="box-reserva" ng-app="appEspacio">
					<div class="box-reserva__header">
						<div class="header__encabezados">
							<span>Desde</span>
							<span>I.V.A incluido</span>
						</div>
						<div class="header__precio">
							<p>AR$ {{$price->price}} <span>por hora (mímino {{$price->minhours}} hr)</span></p>
						</div>
					</div>
					<div class="box-reserva__body" ng-controller="espacioCtrl" data-ng-init="setPrice({{$price->price}})">
						<div class="box-reserva__fechas">
							<input type="hidden" ng-model="priceHs" ng-value="{{$price->price}}">
							<div>
								<label for="fecha">Fecha reserva</label>
								<input type="date" name="fecha" ng-model="date" class="wt-input">
							</div>
							<div>
								<label for="fecha">Inicio reserva</label>
								{!! Form::selectRange('inicio', 1, 24, null, ['class' => 'wt-select', 'ng-model' => 'inicio', 'placeholder' => 'Ingrese hora']) !!}
							</div>
							<div>
								<label for="fin">Fin reserva</label>
								{!! Form::selectRange('fin', 1, 24, null, ['class' => 'wt-select', 'ng-model' => 'fin', 'placeholder' => 'Ingrese hora']) !!}
							</div>
						</div>
						<span class="body__add-date-time" ng-click="addDateTimes()">Agregar otra fecha</span>
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
							<a href="{{ route('reserva', 1) }}" class="wt-btn-principal wt-m-top-2 text-white">Reservar</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="detail-space__info">
		<div class="container">
			<!-- Descripcion -->
			<div class="wt-content-grid">
				<div class="wt-content-grid__left">
					<p>Descripción</p>
				</div>
				<div class="wt-content-grid__right">
					<p>{{$espacio->description}}</p>
				</div>
			</div>
			<!-- Amenities -->
			<div class="wt-content-grid">
				<div class="wt-content-grid__left">
					<p>Amenities</p>
				</div>
				<div class="wt-content-grid__right">
					<ul>
						@forelse($espacio->servicios as $ameniti)
						<li>{{$ameniti->nombre}}</li>
						@empty
						<li>No posee servicios</li>
						@endforelse
					</ul>
				</div>
			</div>
			<!-- Precio -->
			<div class="wt-content-grid">
				<div class="wt-content-grid__left">
					<p>Precio</p>
				</div>
				<div class="wt-content-grid__right">
					<p>ARS Moneda</p>
					<p>${{$price->price}} Precio por hora</p>
					<p>{{$price->minhours}} Mìnimo de horas</p>
				</div>
			</div>
			<!-- Reserva -->
			<div class="wt-content-grid">
				<div class="wt-content-grid__left">
					<p>Reserva</p>
				</div>
				<div class="wt-content-grid__right">
					<p><b>Reglas</b></p>
					<p>{{$espacio->rule}}</p>
					<p><b>Pilítica de cancelación</b></p>
					<p>{{$espacio->politcancel}}</p>
				</div>
			</div>
			<!-- Anfitrion -->
			<div class="anfitrion">
				<p class="anfitrion__title">Anfitrión</p>
				<hr>
				<div class="row">
					<div class="col-sm-2">
						<img class="img-responsive img-circle" src="http://m.alo.co/sites/default/files/imagecache/Main_Galeria_Vertical_433_570/jason-statham-2012-2.jpg" alt="Anfitrion" width="140" height="140">
					</div>
					<div class="col-sm-10">
						<p>{{ $espacio->user->personaldescription}}</p>
						<a href="#" class="wt-btn-principal">Contactame</a>
					</div>
				</div>
			</div>
			<!-- Mapa -->
			<div class="anfitrion">
				<p class="anfitrion__title wt-m-top-2">Ubicación</p>
				<hr>
				<div id="map-espacio"></div>
			</div>
		</div>
	</div>
</section>
@endsection