@extends('layouts.app')

@section('title', 'Buscador')

@section('content')
    <div class="search">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div class="search-form">
						<form action="{{url('search')}}" class="wt-center-block">
	                        
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
				<div class="col-sm-4">
					
				</div>
			</div>
		</div>
	</div>
@endsection