<template>
	<a :href="url" target="_blank">
		<img :src="urlImagen(espacio.image)" :tile="espacio.name" class="img-responsive img-espacio">
		<div class="search-espacio">
			<span>$ {{espacio.price}}</span>
			<span class="left-hr">/hr</span>
		</div>
		<div class="card-footer-search">
			<div>
				<p>{{espacio.name}}</p>
				<span>
					<img class="icon-people" src="/img/wimet_ic_group_black_24px.svg" alt=""> {{espacio.quanty}}
				</span>
			</div>
			<div>
				<img :src="espacio.imagesource" class="card-avatar-search"/>
				<div class="star-row">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</div>										
			</div>
		</div>
	</a>
</template>
<script>
	export default {
		props: [
			'espacioId',
			'categoryId'
		],
		data() {
			return {
				espacio: {},
				url: `/categoria/${this.categoryId}/espacio/${this.espacioId}`
			}
		},
		mounted() {
			this.getEspacio();
		},
		methods: {
			getEspacio() {
				this.$http.get(`/api/getespacio/categoria/${this.categoryId}/espacio/${this.espacioId}`)
	            .then(res => {
	            	this.espacio = res.body[0];
	            }, err => {
	                console.log(err);
	            });
	        },
	        urlImagen(url) {
	        	return `https://res.cloudinary.com/wimet/image/upload/q_60/${url}`;
	        }
		}
	}
</script>