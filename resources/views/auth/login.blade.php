@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="wt-m-top-5">
                <h1 class="text-center">Bienvenido!</h1>
                <h3 class="text-center">Inicia sesión / registrate con</h3>
                <div class="row wt-m-top-4">
                    <div class="col-xs-12 col-md-6">
                        <a href="redirect" class="btn wt-btn-primary center-block">Iniciar con Facebook</a>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <a href="redirect" class="btn wt-btn-primary center-block">Iniciar con LinkedIn</a>
                    </div>
                </div>
                <div class="row margin-top">
                    <div class="col-xs-12 col-md-6">
                        <h3>Crea tu cuenta</h3>
                        <div class="wt-m-top-5 wt-m-bot-5">
                            <p>Estas a un paso de ser parte de la comunidad donde puedes reservar y proponer espacios creativos y acceder a beneficios únicos para tu próxima actividad</p>
                        </div>
                        <a href="{{url('/register')}}" class="btn wt-btn-primary wt-m-top-5" style="width:100%">
                            Registrar
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h3>Si ya tienes tu usuario</h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="wt-center-column wt-m-top-3">
                                <label for="email">E-mail</label>
                                <input type="text" id="email" name="email" class="wt-input" placeholder="Ingrese email">
                            </div>
                            <div class="wt-center-column wt-m-top-1 wt-m-bot-3">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password" class="wt-input" placeholder="Ingrese contraseña">
                            </div>
                            <input type="submit" value="Ingresar" class="btn wt-btn-primary center-block" style="width: 100%" />
                        </form>
                        <a class="btn btn-link text-center" href="{{ url('/password/reset') }}">
                            Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel panel-default" style="display: none;">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                <a href="redirect">FB Login</a>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
