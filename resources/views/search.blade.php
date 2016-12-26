@extends('layouts.app')

@section('title', 'Buscador')

@section('content')
    <div class="search">
		<div class="container-fuild">
			<div class="row">
				<div class="col-sm-7">
					<div class="search-form">
						<form action="{{url('search')}}" class="wt-center-block-left">
	                        
	                        <select name="ubicacion" class="wt-custom-select">
	                            <option value="">Ubicación</option>
	                        </select>

	                        <select name="categories" class="wt-custom-select">
	                            <option value="">Tipo de actividad</option>
	                        </select>

	                        <button class="btn btn-danger">Buscar</button>

	                    </form>
					</div>
					
					<p class="search-result">Se encontraron {{$espacios->total()}} resultados con los filtros utilizados</p>
					
					<div class="search-data">
						<div class="row">

							<div class="col-sm-6">
								<a href="#">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<button class="btn wt-btn-principal search-espacio">$1000 / hora</button>
									<p>Espacio numero 1</p>
									<span>hasta 50 personas</span>
								</a>
							</div>

							<div class="col-sm-6">
								<a href="#">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<button class="btn wt-btn-principal search-espacio">$1000 / hora</button>
									<p>Espacio numero 1</p>
									<span>hasta 50 personas</span>
								</a>
							</div>

							<div class="col-sm-6">
								<a href="#">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<button class="btn wt-btn-principal search-espacio">$1000 / hora</button>
									<p>Espacio numero 1</p>
									<span>hasta 50 personas</span>
								</a>
							</div>

							<div class="col-sm-6">
								<a href="#">
									<img src="http://www.wimet.co/img/feature-2.jpg" alt="espacio 1" class="img-responsive">
									<button class="btn wt-btn-principal search-espacio">$1000 / hora</button>
									<p>Espacio numero 1</p>
									<span>hasta 50 personas</span>
								</a>
							</div>

						</div>
					</div>
				</div>
				<div class="col-sm-5" style="padding: 10px">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3284.720861430317!2d-58.434494285252306!3d-34.58592898046406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb58ed9532093%3A0x357a9ecb56bdbfc9!2sAreaTres!5e0!3m2!1ses-419!2sar!4v1482716021229" width="100%" height="700" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
@endsection