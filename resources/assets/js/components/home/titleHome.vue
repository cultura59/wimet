<template>
	<span>
		<span v-show="(title == 1)" class="elementToFadeInAndOut">WORKSHOP</span>
		<span v-show="(title == 2)" class="elementToFadeInAndOut">COCKTAIL</span>
		<span v-show="(title == 3)" class="elementToFadeInAndOut">POP-UP</span>
		<span v-show="(title == 4)" class="elementToFadeIn">ENCUENTRO</span>
	</span>
</template>
<script>
	export default {
		data() {
			return {
				title: 1,
				eventInterval: null
			}
		},
		mounted() {
			this.timerTitle();
		},
		methods: {
			timerTitle() {
				var self = this;
				this.eventInterval = setInterval(()=> {
										self.changeTitle();
									}, 2000);
			},				
			changeTitle() {
				if(this.title == 4) {
					clearInterval(this.eventInterval);
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
	
	.elementToFadeIn {
		animation: fadein 3s linear forwards;
	}

	@-webkit-keyframes fadeinout {
		0%,100% { opacity: 0; }
		50% { opacity: 1; }
	}

	@keyframes fadeinout {
		0%,100% { opacity: 0; }
		50% { opacity: 1; }
	}

	@-webkit-keyframes fadein {
		0% { opacity: 0; }
		100% { opacity: 1; }
	}

	@keyframes fadein {
		0% { opacity: 0; }
		100% { opacity: 1; }
	}
</style>