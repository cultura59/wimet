@extends('layouts.app')

@section('content')
<div class="container">
    <div class="center-block wt-m-4">
        <form class="form" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="personal-data col-xs-12 col-md-6">
                    <h2>Perfil</h2>
                    <div class="form-group">
                        <label for="firstname" class="control-label">Nombre</label>
                        <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="control-label">Apellido</label>
                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="control-label">Teléfono</label>
                        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">E-Mail</label>
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="control-label">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="business-data col-xs-12 col-md-6">
                    <h2>Sobre ti</h2>
                    <div class="form-group">
                        <label for="businessName" class="control-label">Empresa</label>
                        <input id="businessName" type="text" class="form-control" name="businessName" value="{{ old('businessName') }}">
                    </div>
                    <div class="form-group">
                        <label for="industry" class="control-label">Industria</label>
                        <input id="industry" type="text" class="form-control" name="industry" value="{{ old('industry') }}">
                    </div>
                    <div class="form-group">
                        <label for="personaldescription" class="control-label">Descripción personal</label>
                        <textarea name="personaldescription" id="personaldescription" rows="11" class="wt-textarea">{{ old('personaldescription') }}</textarea>
                    </div>
                </div>
            </div>
            <div id="box-registrar" class="form-group pull-right">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</div>
@endsection
