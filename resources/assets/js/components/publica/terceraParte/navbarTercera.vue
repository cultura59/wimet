<template>
	<div class="navbar-pasos">
		<button 
			:class="(url == 'reglas') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-first'" 
			@click="changeUrl('reglas')">
			Reglas
		</button>
		<button 
			:class="(url == 'prices') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-first'" 
			@click="changeUrl('prices')">
			Precios
		</button>
		<button 
			:class="(url == 'disponibilidad') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn'" 
			@click="changeUrl('disponibilidad')">
			Disponibilidad
		</button>
		<button 
			:class="(url == 'cancelacion') ? 'navbar-pasos__btm--active' : 'navbar-pasos__btn-last'" 
			@click="changeUrl('cancelacion')">
			Políticas
		</button>
	</div>
</template>
<script>
	export default {
		props: ['espacioId' ,'url'],
		methods: {
			changeUrl(url) {
				window.location.href = `/publicar/tercer-paso/espacio/${this.espacioId}/${url}`;
			}
		}
	}
</script>