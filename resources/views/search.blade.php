@extends('layouts.app')

@section('title', 'Buscador')

@push('scripts')
<script>
	var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: new google.maps.LatLng(-34.5969302, -58.5159385),
			zoom: 11,
		    zoomControl: true,
		    zoomControlOptions: {
		        position: google.maps.ControlPosition.LEFT_TOP
		    },
			disableDefaultUI: false,
			scrollwheel: false,
		    navigationControl: false,
		    mapTypeControl: false,
		    scaleControl: false,
		    draggable: true,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(-34.5860955, -58.4341036),
			icon: 'http://www.wimet.co/img/favicon.ico',
			map: map
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArSoMrIsnDeERvlCOGJ2WVd36zO2SBTMo&callback=initMap" async defer></script>
@endpush

@section('content')
    <div class="search">
		<div class="container-fuild">
			<div class="search-form">
				{!! Form::open(['url' => 'search', 'method' => 'GET', 'class' => 'wt-center-block-left']) !!}
                    
					{!! Form::select('ubicacion', 
						['Buenos aires' => 'Buenos aires'], 
						Request::input('ubicacion'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Ubicación']
					) !!}

					{!! Form::select('categoria', 
						$categorias, 
						Request::input('categoria'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Qué estás planificando?']
					) !!}

					{!! Form::selectRange('quanty', 
						10,
						400, 
						Request::input('quanty'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Invitados', 'required' => 'required']
					) !!}

					{!! Form::selectRange('price', 
						100,
						1000, 
						Request::input('price'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Precio / hr', 'required' => 'required']
					) !!}
		
					{!! Form::submit('BUSCAR', ['class' => 'btn wt-btn-primary']) !!}
				{!! Form::close() !!}
			</div>

			<section class="section-main">
				<div class="section-main__chield-1">
					<p class="search-result">{{$espacios->total()}} espacios encontrados</p>
					
					<div class="search-data">
						<div class="row" id="home-espacio">
							@foreach($espacios as $espacio)
							<div class="col-xs-12 col-sm-6">
								<espacio-search 
									espacio-id="{{$espacio->id}}"
									category-id="{{Request::input('categoria')}}"
								></espacio-search>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="section-main__chield-2">
					<div id="map"></div>
				</div>
			</section>

			</div>
		</div>
	</div>
@endsection