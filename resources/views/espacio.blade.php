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
								<label for="fecha">Tipo de actividad</label>
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
				<p>Amenities</p>
				<div class="col-md-8">
					<div class="row">
						@foreach($espacio->servicios as $servicio)
							<div class="col-md-4">
								<img src="{{url('img/ic_done_black_16dp_1x.png')}}"> {{$servicio->nombre}}
							</div>
						@endforeach
					</div>
				</div>
			</div><br>
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