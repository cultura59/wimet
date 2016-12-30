@extends('layouts.app')

@section('title', 'Buscador')

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
				center: new google.maps.LatLng(-33.91722, 151.23064),
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
				position: new google.maps.LatLng(-33.91721, 151.22630),
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
					<h2>Loft canchero en Soho</h2>
					<p>Palermo / Buenos Aires</p>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="box-reserva">
					<div class="box-reserva__header">
						<div class="header__encabezados">
							<span>Desde</span>
							<span>I.V.A incluido</span>
						</div>
						<div class="header__precio">
							<p>AR$ 143 <span>por hora (mímino 4 hr)</span></p>
						</div>
					</div>
					<div class="box-reserva__body">
						<div class="box-reserva__fechas">
							<div>
								<label for="fecha">Fecha reserva</label>
								<input type="date" name="fecha" >
							</div>
							<div>
								<label for="fecha">Inicio reserva</label>
								<input type="time" name="inicio" >
							</div>
							<div>
								<label for="fin">Fin reserva</label>
								<input type="time" name="fin" >
							</div>
						</div>
						<a href="#">Agregar otra fecha</a>
						<div class="box-reserva__totales">
							<p class="wt-m-top-2">PRECIO</p>
							<div class="wt-space-block">
								<span>$143 X 11hs</span>
								<span>$1573.-</span>
							</div>
							<div class="wt-space-block">
								<span>Fee de administración (5%)</span>
								<span>$78,65.-</span>
							</div>
							<hr>
							<div class="wt-space-block">
								<strong>Total</strong>
								<strong>$1651,65.-</strong>
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
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus officiis autem quas maiores voluptatum nihil voluptatem ducimus sit, culpa alias tempora quod necessitatibus provident ipsum corporis esse, a neque sunt.</p>
				</div>
			</div>
			<!-- Amenities -->
			<div class="wt-content-grid">
				<div class="wt-content-grid__left">
					<p>Amenities</p>
				</div>
				<div class="wt-content-grid__right">
					<ul>
						<li>Mesas</li>
						<li>Sillas</li>
						<li>Proyector</li>
						<li>Pantalla</li>
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
					<p>$500 Precio por hora</p>
					<p>5 Mìnimo de horas</p>
				</div>
			</div>
			<!-- Reserva -->
			<div class="wt-content-grid">
				<div class="wt-content-grid__left">
					<p>Reserva</p>
				</div>
				<div class="wt-content-grid__right">
					<p><b>Reglas</b></p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam mollitia aliquid molestias, iste, necessitatibus ab quam omnis a, atque eius suscipit? Illo voluptate, corporis labore architecto quisquam totam velit sit.</p>
					<p><b>Pilítica de cancelación</b></p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non asperiores amet veritatis odit dolore recusandae rem. Nesciunt optio tempora quisquam nobis blanditiis excepturi sunt alias rerum, aliquid eaque eum, saepe?</p>
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
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet id, mollitia nihil aliquam quia assumenda ea ab nostrum suscipit cupiditate perspiciatis vel iste recusandae facere earum repellat saepe architecto illum!</p>
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