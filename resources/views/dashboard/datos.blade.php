@extends('layouts.dashboard')

@section('title', 'Mis espacios')

@section('content')

	<aside-dashboard selected="datos"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>MI PERFIL</h4>
		</div>
		<div class="dashboard-body">
	        {!!Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data'))!!}
	            <div class="row">
	                <div class="personal-data col-xs-12 col-md-6">
	                    <h2>Perfil</h2>
	                    <div class="form-group">
	                        <label for="firstname" class="control-label">Nombre</label>
	                        <input id="firstname" type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" required autofocus>
	                    </div>

	                    <div class="form-group">
	                        <label for="lastname" class="control-label">Apellido</label>
	                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required autofocus>
	                    </div>

	                    <div class="form-group">
	                        <label for="phone" class="control-label">Teléfono</label>
	                        <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}">
	                    </div>

	                    <div class="form-group">
	                        <label for="email" class="control-label">E-Mail</label>
	                        <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" required autofocus>
	                    </div>

	                    <div class="form-group">
	                        <label for="imagesource" class="control-label">Avatar</label>
	                        <input id="imagesource" type="file" class="form-control" name="imagesource"/>
	                    </div>
	                </div>

	                <div class="business-data col-xs-12 col-md-6">
	                    <h2>Sobre ti</h2>
	                    <div class="form-group">
	                        <label for="businessName" class="control-label">Empresa</label>
	                        <input id="businessName" type="text" class="form-control" name="businessName" value="{{ $user->businessName }}">
	                    </div>
	                    <div class="form-group">
	                        <label for="industry" class="control-label">Industria</label>
	                        <input id="industry" type="text" class="form-control" name="industry" value="{{ $user->industry }}">
	                    </div>
	                    <div class="form-group">
	                        <label for="personaldescription" class="control-label">Descripción personal</label>
	                        <textarea name="personaldescription" id="personaldescription" rows="8" class="wt-textarea">{{ $user->personaldescription }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div id="box-registrar" class="form-group pull-right">
	                <button type="submit" class="btn btn-primary">Editar</button>
	            </div>
	        {!! Form::close() !!}
	    </div>
	</section>

@endsection