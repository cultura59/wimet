<template>
    <div class="google-map" :id="mapName"></div>
</template>
<script>
    export default {
        name: 'google-map',
        props: ['name', 'icon', 'zoom', 'gwith', 'gheight', 'gespacios'],
        data() {
            return {
                mapName: this.name + "-map",
                map: null,
                bounds: null,
                markers: [],
                styledMapType: new google.maps.StyledMapType(
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
                )
            }
        },
        mounted() {
            this.init();
        },
        methods: {
            init() {
                this.bounds = new google.maps.LatLngBounds();
                const element = document.getElementById(this.mapName);
                element.style.height = this.gheight;
                element.style.width = this.gwith;
                const mapCentre = this.gespacios[0];
                this.map = new google.maps.Map(element, {
                    center: new google.maps.LatLng(mapCentre.lat, mapCentre.long),
                    zoom: parseInt(this.zoom),
                    maxZoom: 15,
                    disableDefaultUI: false,
                    scrollwheel: false,
                    navigationControl: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    draggable: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                this.map.mapTypes.set('sylver', this.styledMapType);
                this.map.setMapTypeId('sylver');
                this.gespacios.forEach((coord) => {
                    const position = new google.maps.LatLng(coord.lat, coord.long);
                    const marker = new google.maps.Marker({
                        position,
                        icon: (this.icon == "radio") ? "/wimet-ic-espacio-marker.png" : "https://res.cloudinary.com/wimet/image/upload/c_scale,w_36/v1501352935/wimet_google_marker__2_ojga13.ico",
                        map: this.map
                    });
                    this.markers.push(marker);
                    this.map.fitBounds(this.bounds.extend(position))
                });
            }
        }
    };
</script>
<style lang="sass" scoped>
    .google-map {
        transition: none;
        margin: 0 auto;
        background: gray;
    }
</style>