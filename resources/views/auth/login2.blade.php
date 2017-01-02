<div class="wt-m-3">
	<h2 class="text-center">Bienvenido!</h2>
	<div class="row">
		<div class="col-sm-6 wt-m-top-1">
			<h3>Crea tu cuenta</h3>
			<p>Estas a un paso de ser parte de la comunidad donde puedes reservar y proponer espacios creativos y acceder a beneficios únicos para tu próxima actividad.</p>
			<div class="wt-m-top-5"><a href="{{url('/register')}}" class="wt-btn-principal">Registrar</a></div>
		</div>
		<div class="col-sm-6">
			<h3>Si ya tienes tu usuario</h3>
			<form method="POST" action="{{ url('/login') }}">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="text" class="form-control" placeholder="Ingrese email">
				</div>
				<div class="form-group">
					<label for="password">Contraseña</label>
					<input type="password" class="form-control" placeholder="Ingrese contraseña">
				</div>
				<input type="submit" class="btn btn-primary" value="Ingresar">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                    Forgot Your Password?
                </a>
			</form>
		</div>
	</div>
</div>