@extends('layouts.app')

@section('title', 'reserva')

@section('content')
<input type="hidden" id="clientId" value="{{Auth::user()->id}}">
<section class="reserva wt-m-3" id="home-espacio">
	<confirm-reserva client-id="{{Auth::user()->id}}"></confirm-reserva>
</section>
@endsection