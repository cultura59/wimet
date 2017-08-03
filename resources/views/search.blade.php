@extends('layouts.app')

@section('title', 'Buscador')

@push('scripts')
<script>
	var isMobile = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i);
	    },
	    any: function() {
	        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	    }
	};
	if(!isMobile.any()) {
		var map;
		function initMap() {
			var styledMapType = new google.maps.StyledMapType(
				[
					{"elementType": "geometry", "stylers": [{"color": "#f5f5f5"}]},
					{"elementType": "labels.icon", "stylers": [{"visibility": "off"}]},
					{"elementType": "labels.text.fill", "stylers": [{"color": "#616161"}]},
					{"elementType": "labels.text.stroke", "stylers": [{"color": "#f5f5f5"}]},
					{"featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [{"color": "#bdbdbd"}]},
					{"featureType": "administrative.locality", "elementType": "labels.text", "stylers": [
					{"color": "#e8536f"},
					{"visibility": "simplified"}, {"weight": 0.5}
					]},
					{"featureType": "administrative.neighborhood", "elementType": "labels.text", "stylers": 
					[{"color": "#e8536f"},{"visibility": "simplified"}, {"weight": 0.5}]},
					{"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#eeeeee"}]},
					{"featureType": "poi", "elementType": "labels.text.fill", "stylers": [{"color": "#757575"}]},
					{"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#e5e5e5"}]},
					{"featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [{"color": "#9e9e9e"}]},
					{"featureType": "road", "elementType": "geometry", "stylers": [{"color": "#ffffff"}]},
					{"featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [{"color": "#757575"}]},
					{"featureType": "road.highway", "elementType": "geometry", "stylers": [{"color": "#dadada"}]},
					{"featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [{"color": "#616161"}]},
					{"featureType": "road.local", "elementType": "labels.text.fill", "stylers": [{"color": "#9e9e9e"}]},
					{"featureType": "transit.line", "elementType": "geometry", "stylers": [{"color": "#e5e5e5"}]},
					{"featureType": "transit.station", "elementType": "geometry", "stylers": [{"color": "#eeeeee"}]},
					{"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#c9c9c9"}]},
					{"featureType": "water", "elementType": "geometry.fill", "stylers": [{"color": "#d5dbdd"}]},
					{"featureType": "water", "elementType": "labels.text.fill", "stylers": [{"color": "#9e9e9e"}]}
				]
			);
			map = new google.maps.Map(document.getElementById('map'), {
				center: new google.maps.LatLng(-34.5705755,-58.443631,12),
				zoom: 12,
				maxZoom: 14,
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
			map.mapTypes.set('sylver', styledMapType);
			map.setMapTypeId('sylver');
			var marker;
			@foreach($espacios as $espacio)
				var infoWindow = new google.maps.InfoWindow();
				var contentInfo = '<div id="content">'+
	            '<div id="siteNotice">'+
	            '</div>'+
	            '<h5 id="firstHeading" class="firstHeading">{{$espacio->name}}</h5>'+
	            '<div id="bodyContent">'+
	            '<a href="/categoria/'+{{Request::input("categoria")}}+'/espacio/{{$espacio->id}}" target="_blank">'+
	            '<img class="img-responsive" src="https://res.cloudinary.com/wimet/image/upload/q_60/{{$espacio->images[0]->name}}" style="width: 100%" />'+
	            '</a> '+
	            '</div>'+
	            '</div>';
				marker = new google.maps.Marker({
					position: new google.maps.LatLng({{$espacio->lat}}, {{$espacio->long}}),
					icon: 'https://res.cloudinary.com/wimet/image/upload/c_scale,w_36/v1501352935/wimet_google_marker__2_ojga13.ico',
					map: map,
					title: '{{$espacio->name}}'
				});
		        //Attach click event to the marker.
	            (function (marker, contentInfo) {
	                google.maps.event.addListener(marker, "click", function (e) {
	                    //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
	                    infoWindow.setContent(contentInfo);
	                    infoWindow.open(map, marker);
	                });
	            })(marker, contentInfo);
			@endforeach
		}
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUp-A4EcLNbPonxHhbySVWpP9kzZQQUw&callback=initMap" async defer></script>
@endpush

@section('content')
    <div class="search">
		<div class="container-fuild">
			<div class="search-form">
				<search-filter></search-filter>
			</div>

			<section class="section-main">
				<div class="section-main__chield-1">					
					<div class="search-data wt-m-top-3">
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
						<div>
							{{ $espacios->links() }}
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