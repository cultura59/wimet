<template>
	<div>
		<ul class="list-images">
			<li v-for="img in images">
				<span> {{img.name}} </span>
				<span class="cursor-pointer" @click="deleteImage(img)">X</span>
			</li>
		</ul>
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