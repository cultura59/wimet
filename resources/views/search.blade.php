@extends('layouts.app')

@section('title', 'Buscador')

@push('scripts')
<link href="http://allfont.es/allfont.css?fonts=roboto-light" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">


<script>
	var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: new google.maps.LatLng(-34.6112745,-58.4930695),
			zoom: 12,
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
		var marker;
		@foreach($espacios as $espacio)
			marker = new google.maps.Marker({
				position: new google.maps.LatLng({{$espacio->lat}}, {{$espacio->long}}),
				icon: 'http://www.wimet.co/img/favicon.ico',
				map: map
			});
		@endforeach
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

					{!! Form::select('quanty', 
						['5' => '5+', '10' => '10+', '25' => '25+', '50' => '50+', '100' => '100+', '200' => '200+'], 
						Request::input('quanty'), 
						['class' => 'wt-custom-select', 'placeholder' => 'Invitados', 'required' => 'required']
					) !!}

					{!! Form::select('price', 
						[
							'0-500' => '$0 - $500', 
							'500-1000' => '$500 - $1000', 
							'1000-1500' => '$1000 - $1500', 
							'1500-2500' => '$1500 - $2500', 
							'2500-3500' => '$2500 - $3500',
							'3500' => '> $3500'
						], 
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
						<div class="row">
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