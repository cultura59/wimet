<template>
	<aside>
		<ul>
			<li class="title">RESERVAS</li>
			<li :class="{active: (selected == 'consultas')}">
				<a :href="`/dashboard/user/${user.id}/consultas`">Mensajes</a></a>
			</li>
			<li :class="{active: (selected == 'reservas')}">
				<a :href="`/dashboard/user/${user.id}/consultas`">Reservas</a>
			</li>
			<li :class="{active: (selected == 'evaluaciones')}">
				<a :href="`/dashboard/user/${user.id}/consultas`">Evaluaciones</a>
			</li>
			<li :class="{active: (selected == 'favoritos')}">
				<a :href="`/dashboard/user/${user.id}/consultas`">Favoritos</a>
			</li>
			<li :class="{active: (selected == 'misespacios')}">
				<a :href="`/dashboard/user/${user.id}/misespacios`">Mis espacios</a>
			</li>
			<li class="title">DATOS PERSONALES</li>
			<li :class="{active: (selected == 'datos')}">
				<a :href="`/dashboard/user/${user.id}/datos`">Mi perfil</a>
			</li>
			<li>
				<a :href="`/dashboard/user/${user.id}/consultas`">Cuenta</a>
			</li>
		</ul>
	</aside>
</template>
<script>
	export default {
		props: [
			'selected'
		],
		data() {
			return {
				user: {}
			}
		},
		mounted() {
            this.getUserAuthenticated();
        },
		methods: {
			getUserAuthenticated() {
				let vm = this;
				if(this.$auth.isAuthenticated()) {
					vm.$http.get('api/usersession')
					.then(res => {
						this.user = res.body;
					});
				}
			}
		}
	}
</script>