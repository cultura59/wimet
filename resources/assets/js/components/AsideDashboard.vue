<template>
	<aside class="aside-dashboard">
		<div class="header-aside">
			<span class="title-aside-dash">MENU</span>
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
			<li v-if="user.tipo_clientes_id == 2" :class="{active: (selected == 'eventos')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">network_wifi</i></span>
					<a :href="`/dashboard/user/${user.id}/eventos`">Embudo de ventas</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/eventos`">
						<span><i class="material-icons">network_wifi</i></span>
					</a>
				</div>
			</li>
			<li :class="{active: (selected == 'consultas')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">comment</i></span>
					<a :href="`/dashboard/user/${user.id}/mensajes`">Mensajes</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/mensajes`">
						<span><i class="material-icons">comment</i></span>
					</a>
				</div>
			</li>
			<li :class="{active: (selected == 'propuestas')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">assignment_turned_in</i></span>
					<a :href="`/dashboard/user/${user.id}/propuestas`">Propuestas</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/propuestas`">
						<span><i class="material-icons">assignment_turned_in</i></span>
					</a>
				</div>
			</li>
			<li :class="{active: (selected == 'evaluaciones')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">star</i></span>
					<a :href="`/dashboard/user/${user.id}/consultas`">Evaluaciones</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/consultas`">
						<span><i class="material-icons">star</i></span>
					</a>
				</div>
			</li>
			<li :class="{active: (selected == 'favoritos')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">favorite</i></span>
					<a :href="`/dashboard/user/${user.id}/consultas`">Favoritos</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/consultas`">
						<span><i class="material-icons">favorite</i></i></span>
					</a>
				</div>
			</li>
			<li :class="{active: (selected == 'misespacios')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">location_city</i></span>
					<a :href="`/dashboard/user/${user.id}/misespacios`">Mis espacios</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/misespacios`">
						<span><i class="material-icons">location_city</i></span>
					</a>
				</div>
			</li>
			<li class="title wt-m-top-2">PERFIL</li>
			<li :class="{active: (selected == 'datos')}">
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">account_circle</i></span>
					<a :href="`/dashboard/user/${user.id}/datos`">Mi perfil</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/datos`">
						<span><i class="material-icons">account_circle</i></span>
					</a>
				</div>
			</li>
			<li>
				<div class="list-dashboard-desktop">
					<span><i class="material-icons">work</i></span>
					<a :href="`/dashboard/user/${user.id}/consultas`">Cuenta</a>
				</div>
				<div class="list-dashboard-mobile">
					<a :href="`/dashboard/user/${user.id}/consultas`">
						<span><i class="material-icons">work</i></span>
					</a>
				</div>
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
					this.user = this.$auth.getUser();
				}
			}
		}
	}
</script>