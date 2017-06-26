<template>
	<div class="navbar-pasos">
		<button 
			:class="(url == 'categorias') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-first'" 
			@click="changeUrl('categorias')">
			Actividades
		</button>
		<button 
			:class="(url == 'detalles') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-first'" 
			@click="changeUrl('detalles')">
			Accesibilidad
		</button>
		<button 
			:class="(url == 'invitados') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn'" 
			@click="changeUrl('invitados')">
			Capacidad
		</button>
		<button 
			:class="(url == 'maps') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-last'" 
			@click="changeUrl('maps')">
			Dirección
		</button>
	</div>
</template>
<script>
	export default {
		props: ['espacioId' ,'url'],
		methods: {
			changeUrl(url) {
				window.location.href = `/publicar/primer-paso/espacio/${this.espacioId}/${url}`;
			}
		}
	}
</script>