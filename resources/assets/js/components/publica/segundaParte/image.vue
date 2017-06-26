<template>
	<div>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<h3 class="wt-m-bot-2">Carga tus imágenes</h3>
		<dropzone 
			id="myVueDropzone" 
			:url= "url"
			:paramName = "nameInput"
			:maxFileSizeInMB = "maxMB"
			:maxNumberOfFiles = "maxFiles"
			:uploadMultiple = "multipleFile"
			:dropzoneOptions = "customOptions"
			v-on:vdropzone-success="showSuccess"
		>
			<input type="hidden" name="espacio_id" :value="espacioid">
		</dropzone>
	</div>
</template>
<script>
	import Dropzone from 'vue2-dropzone';
	export default {
		props: [
			'espacioId'
		],
		data() {
			return {
				url: `/saveimages/espacioid/${this.espacioId}`,
				maxMB: 3,
				maxFiles: 10,
				multipleFile: true
			}
		},
		components: {
			Dropzone
		},
		methods: {
			showSuccess(file) {
				console.log(file);
			}
		}
	}
</script>