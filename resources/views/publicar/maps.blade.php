@extends('layouts.app')

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

			for (var component in componentForm) {
				document.getElementById(component).value = '';
				document.getElementById(component).disabled = false;
			}

			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					document.getElementById(addressType).value = val;
				}
			}
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
					console.log(geolocation);
				});
			}
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArSoMrIsnDeERvlCOGJ2WVd36zO2SBTMo&libraries=places&callback=initAutocomplete"
        async defer></script>
@endpush

@section('content')
	
<section class="section-publica">
	<div class="container-left">
		{!! Form::open(array('url' => 'api/espacio', 'method' => 'POST')) !!}
		<input type="hidden" name="id" value="{$id}}">
		<div class="wt-progress">
			<div id="progress" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
			aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			</div>
		</div>

		<div class="container-center">
			<div class="detalles-espacios">
				<h2>¿Cuál es la dirección exacta?</h2>
				<div class="row wt-m-top-2">
					<div class="col-md-12">
						<input 
							type="text" 
							id="direccion" 
							class="wt-publica-input"
							placeholder="Ingrese la dirección" 
							onFocus="geolocate()" />
					</div>
				</div>
				<div class="row wt-m-top-2">
					<div class="col-md-6">
						<input type="text" id="street_number" name="street_number" class="wt-publica-input" placeholder="Ingrese número">
					</div>
					<div class="col-md-6">
						<input type="text" id="route" name="route" class="wt-publica-input" placeholder="Ingrese calle">
					</div>
				</div>
				<div class="row wt-m-top-2">
					<div class="col-md-6">
						<input type="text" id="locality" name="locality" class="wt-publica-input" placeholder="Ingrese localidad">
					</div>
					<div class="col-md-6">
						<input type="text" id="administrative_area_level_1" name="administrative_area_level_1" class="wt-publica-input" placeholder="Ingrese provincia/estado">
					</div>
				</div>
				<div class="row wt-m-top-2">
					<div class="col-md-6">
						<input type="text" id="country" name="country" class="wt-publica-input" placeholder="Ingrese país">
					</div>
					<div class="col-md-6">
						<input type="text" id="postal_code" name="postal_code" class="wt-publica-input" placeholder="Ingrese código postal">
					</div>
				</div>
				<input type="hidden" id="lat" name="lat" value="">
				<input type="hidden" id="long" name="lat" value="">
			</div>
		</div>

		<div class="buttons" id="second-buttons">
			<button class="btn">ATRÁS</button>
			<input class="btn wt-btn-primary" type="submit" value="CONTINUAR"/>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="container-right">
		<img class="img-responsive" src="http://lorempixel.com/people/400/500/" alt="">
	</div>
</section>
@endsection