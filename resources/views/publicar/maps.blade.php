@extends('layouts.notfix')

@section('title', 'Publicar mapa')

@push('scripts')
	<script>
		var placeSearch, autocomplete;
		var componentForm = {
			street_number: 'short_name',
			route: 'long_name',
			locality: 'long_name',
			administrative_area_level_1: 'short_name',
			country: 'long_name',
			postal_code: 'short_name'
		};

		function initAutocomplete() {
			autocomplete = new google.maps.places.Autocomplete(
				(document.getElementById('direccion')),
				{types: ['geocode']}
			);
			autocomplete.addListener('place_changed', fillInAddress);
		}

		function fillInAddress() {
			var place = autocomplete.getPlace();
			console.log(place);
			for (var component in componentForm) {
				document.getElementById(component).value = '';
				document.getElementById(component).disabled = false;
			}

			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					if(val === "CABA") {
						document.getElementById(addressType).value = val;
						document.getElementById("locality").value = place.address_components[i]["long_name"];
					}else {
						document.getElementById(addressType).value = val;
					}
				}
			}
			getLatAndLong(document.getElementById('direccion').value);
		}

		function geolocate() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var geolocation = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					var circle = new google.maps.Circle({
						center: geolocation,
						radius: position.coords.accuracy
					});
					autocomplete.setBounds(circle.getBounds());
				});
			}
		}

		function getLatAndLong(adress) {
			var URL = "http://maps.google.com/maps/api/geocode/json?address=$" + adress + "&sensor=false";
			var xhr = new XMLHttpRequest();
			xhr.onload = function() {
				var res = JSON.parse(xhr.responseText);
				var lat = res.results[0].geometry.location.lat;
				var lng = res.results[0].geometry.location.lng;
				document.getElementById("lat").value = lat;
				document.getElementById("long").value = lng;
				
				var mapOptions = {
					center: new google.maps.LatLng(lat, lng),
					zoom: 14,
					disableDefaultUI: true,
					scrollwheel: false,
				    navigationControl: false,
				    mapTypeControl: true,
				    scaleControl: false,
				    draggable: false,
				    mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(lat, lng),
					icon: 'http://www.wimet.co/img/favicon.ico',
					map: map
				});
			};
			xhr.open('GET', URL);
			xhr.send();
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUp-A4EcLNbPonxHhbySVWpP9kzZQQUw&libraries=places&callback=initAutocomplete"></script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="wt-progress">
		<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
		aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		</div>
	</div>
	<div class="container-left">
		<navbar-primero espacio-id="{{$espacio->id}}" url="maps"></navbar-primero>
		{!! Form::open(array('url' => 'saveadress', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{{$espacio->id}}">
		<input type="hidden" id="lat" name="lat" value="{{$espacio->lat}}">
		<input type="hidden" id="long" name="long" value="{{$espacio->long}}">

		<div class="container-center">
			<div class="detalles-espacios">
				<h3>¿Cuál es la dirección exacta?</h3>
				<div class="row wt-m-top-2">
					<div class="col-md-12">
						<input 
							type="text" 
							id="direccion" 
							class="wt-publica-input"
							value="{{$espacio->adress}}, {{$espacio->city}}, {{$espacio->state}}" 
							placeholder="Ej.: El Salvador 5218, Palermo" 
							onFocus="geolocate()" />
					</div>
				</div>
				<div style="display: none;">
					<div class="row wt-m-top-2">
						<div class="col-md-6">
							<input type="text" id="street_number" name="street_number" class="wt-publica-input" placeholder="Ingrese número" value="{{isset($street_number)?$street_number: ''}}">
						</div>
						<div class="col-md-6">
							<input type="text" id="route" name="route" class="wt-publica-input" placeholder="Ingrese calle" value="{{isset($route)?$route: ''}}">
						</div>
					</div>
					<div class="row wt-m-top-2">
						<div class="col-md-6">
							<input type="text" id="locality" name="locality" class="wt-publica-input" placeholder="Ingrese localidad" value="{{$espacio->state}}">
						</div>
						<div class="col-md-6">
							<input type="text" id="administrative_area_level_1" name="administrative_area_level_1" class="wt-publica-input" placeholder="Ingrese provincia/estado" value="{{$espacio->city}}">
						</div>
					</div>
					<div class="row wt-m-top-2">
						<div class="col-md-6">
							<input type="text" id="country" name="country" class="wt-publica-input" placeholder="Ingrese país" value="{{$espacio->country}}">
						</div>
						<div class="col-md-6">
							<input type="text" id="postal_code" name="postal_code" class="wt-publica-input" placeholder="Ingrese código postal">
						</div>
					</div>
				</div>
				<div id="map-canvas" style="height: 350px; width: 100%; background: #dadada" class="wt-m-top-2"></div>
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<a href="{{ url()->previous() }}" class="btn-volver">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
				<span>ATRÁS</span>
			</a>
			<input class="btn-primary-pig" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<div class="container-right__dialog-box">
			<div>
				<p>No te preocupes. Tu dirección exacta sólo se mostrará a los usuarios que cuenten con una reserva confirmada.</p>
			</div>
		</div>
	</div>
</section>
@endsection