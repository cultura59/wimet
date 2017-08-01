<template>
	<div class="navbar-pasos">
		<button 
			:class="(url == 'images') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-first'" 
			@click="changeUrl('images')">
			Imágenes
		</button>
		<button 
			:class="(url == 'caracteristicas') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-first'" 
			@click="changeUrl('caracteristicas')">
			Características
		</button>
		<button 
			:class="(url == 'amenities') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn'" 
			@click="changeUrl('amenities')">
			Amenities
		</button>
		<button 
			:class="(url == 'titulo') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-last'" 
			@click="changeUrl('titulo')">
			Descripción
		</button>
	</div>
</template>
<script>
	export default {
		props: ['espacioId' ,'url'],
		methods: {
			changeUrl(url) {
				window.location.href = `/publicar/segundo-paso/espacio/${this.espacioId}/${url}`;
			}
		}
	}
</script>