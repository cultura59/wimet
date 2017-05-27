<template>
    <div class="wt-m-top-1">
        <h3>Imagenes cargadas</h3>
    	<div class="row wt-m-bot-4">
    		<div class="col-md-3" v-for="img in images">
    			<i class="fa fa-trash-o fa-2x remove-img" aria-hidden="true"></i>
                <img v-bind:src="'/' + img.name" class="img-responsive img-rounded" @click="deleteImage(img)">
    		</div>
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
	.remove-img {
        position: absolute;
        top: 0;
        color: #fff;
    }
    .img-rounded:hover {
        opacity: 0.5;
        cursor: pointer;
    }
</style>