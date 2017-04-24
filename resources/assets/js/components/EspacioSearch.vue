<template>
	<a href="#">
		<img src="" tile="" class="img-responsive">
		<div class="search-espacio">
			$ precio ARS
		</div>
		<div class="card-footer-search">
			<div>
				<p>nombre</p>
				<span>
					<img class="icon-people" src="/img/wimet_ic_group_black_24px.svg" alt=""> quanty
				</span>
			</div>
			<div>
				<span class="card-avatar-search"></span>
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
		]
	}
</script>