@extends('layouts.app')

@section('title', $espacio->name)

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUp-A4EcLNbPonxHhbySVWpP9kzZQQUw&callback"></script>

@section('content')
    <home-espacio
        espacio-id="{{$espacio->id}}"
        categoria-id="{{$categoryId}}">
    </home-espacio>
@endsection