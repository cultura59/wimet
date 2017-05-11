<template>
	<div class="gallery">
		<div class="gallery__item" v-for="img in images">
			<img v-bind:src="'/' + img.name" class="img-responsive" @click="deleteImage(img)">
			<i class="fa fa-trash-o" aria-hidden="true"></i>
		</div>
	</div>
</template>
<script>
	export default {
		props: [
            'espacioId'
        ],
        data() {
            return {
              images: []
            }
        },
        mounted() {
            this.getImagenesEspacio();
        },
        methods: {
            getImagenesEspacio() {
                this.$http.get(`/api/espacio/${this.espacioId}`)
                .then(res => {
                    this.images = res.body.images;
                }, err => {
                    console.log(err);
                });
            },
            deleteImage(img) {
            	this.$http.delete(`/api/image/${img.id}`)
                .then(res => {
                    let aux = this.images.indexOf(img);
                    this.images.splice(aux, 1);
                }, err => {
                    console.log(err);
                });
            }
        }
	}
</script>
<style lang="sass">
	.gallery {
	    display: flex;
	    justify-content: space-around;
	    &__item {
		    position: relative;
		    &:hover {
		    	opacity: 0.5;
		    	cursor: pointer;
		    }
		}
	}
</style>