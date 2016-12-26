@extends('layouts.app')

@section('title', 'Buscador')

@push('scripts')
	
	<script>
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

@endpush

@section('content')
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
	<section class="detail-space container-fluid">
		<h2>Loft canchero en Soho</h2>
		<p>Palermo / Buenos Aires</p>
	</section>
@endsection