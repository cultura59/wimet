<aside>
	<ul>
		<li class="title">RESERVAS</li>
		<li @if($selected == "consultas") class="active" @endif>
			<a href="{{url('/dashboard/user/'. $id .'/consultas')}}">Mensajes</a></a>
		</li>
		<li @if($selected == "reservas") class="active" @endif>
			<a href="{{url('/dashboard/user/'. $id .'/consultas')}}">Reservas</a>
		</li>
		<li @if($selected == "evaluaciones") class="active" @endif>
			<a href="{{url('/dashboard/user/'. $id .'/consultas')}}">Evaluaciones</a>
		</li>
		<li @if($selected == "favoritos") class="active" @endif>
			<a href="{{url('/dashboard/user/'. $id .'/consultas')}}">Favoritos</a>
		</li>
		<li @if($selected == "misespacios") class="active" @endif>
			<a href="{{url('/dashboard/user/'. $id .'/misespacios')}}">Mis espacios</a>
		</li>
		<li class="title">DATOS PERSONALES</li>
		<li @if($selected == "datos") class="active" @endif>
			<a href="{{url('/dashboard/user/'. $id .'/datos')}}">Mi perfil</a>
		</li>
		<li>
			<a href="{{url('/dashboard/user/'. $id .'/consultas')}}">Cuenta</a>
		</li>
	</ul>
</aside>