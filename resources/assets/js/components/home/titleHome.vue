<template>
	<span>
		<span v-if="(title == 1)" class="elementToFadeInAndOut">WORKSHOP</span>
		<span v-if="(title == 2)" class="elementToFadeInAndOut">COCKTAIL</span>
		<span v-if="(title == 3)" class="elementToFadeInAndOut">POP-UP</span>
		<span v-if="(title == 4)" class="elementToFadeInAndOut">ENCUENTRO</span>
	</span>
</template>
<script>
	export default {
		data() {
			return {
				title: 1
			}
		},
		mounted() {
			this.timerTitle();
		},
		methods: {
			timerTitle() {
				var self = this;
				setInterval(()=> {
					console.log("Entro aca");
					self.changeTitle();
				}, 3000);
			},				
			changeTitle() {
				if(this.title >= 4) {
					this.title = 1;
				}else {
					this.title++;
				}
			}

		}
	}
</script>
<style>
	.elementToFadeInAndOut {
	    -webkit-animation: fadeinout 3s linear forwards;
	    animation: fadeinout 3s linear forwards;
	}

	@-webkit-keyframes fadeinout {
		0%,100% { opacity: 0; }
		50% { opacity: 1; }
	}

	@keyframes fadeinout {
		0%,100% { opacity: 0; }
		50% { opacity: 1; }
	}
</style>