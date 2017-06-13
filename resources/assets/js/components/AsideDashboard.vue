<template>
	<aside>
		<div class="header-aside">
			<span>MENU</span>
			<span class="cursor-pointer"><i class="fa fa-bars" aria-hidden="true"></i></span>
		</div>
		<div class="user-aside">
			<div class="user-aside__image">
				<img :src="user.imagesource" :alt="user.firstname" class="img-responsive img-circle" />
			</div>
			<span class="user-aside__name">{{user.firstname}} {{user.lastname}}</span>
		</div>
		<ul>
			<li class="title">RESERVAS</li>
			<li :class="{active: (selected == 'consultas')}">
				<span><i class="fa fa-comments" aria-hidden="true"></i></span>
				<a :href="`/dashboard/user/${user.id}/mensajes`">Mensajes</a>
			</li>
			<li v-if="user.tipo_clientes_id == 2" :class="{active: (selected == 'eventos')}">
				<span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
				<a :href="`/dashboard/user/${user.id}/eventos`">Reservas</a>
			</li>
			<li :class="{active: (selected == 'evaluaciones')}">
				<span><i class="fa fa-star" aria-hidden="true"></i></span>
				<a :href="`/dashboard/user/${user.id}/consultas`">Evaluaciones</a>
			</li>
			<li :class="{active: (selected == 'favoritos')}">
				<span><i class="fa fa-heart" aria-hidden="true"></i></span>
				<a :href="`/dashboard/user/${user.id}/consultas`">Favoritos</a>
			</li>
			<li :class="{active: (selected == 'misespacios')}">
				<span><i class="fa fa-industry" aria-hidden="true"></i></span>
				<a :href="`/dashboard/user/${user.id}/misespacios`">Mis espacios</a>
			</li>
			<li class="title wt-m-top-2">PERFIL</li>
			<li :class="{active: (selected == 'datos')}">
				<span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
				<a :href="`/dashboard/user/${user.id}/datos`">Mi perfil</a>
			</li>
			<li>
				<span><i class="fa fa-briefcase" aria-hidden="true"></i></span>
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