@extends('layouts.dashboard')

@section('title', 'Nueva propuesta')

@push('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/js/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
	<script type="text/javascript">
	    $('#comienza').datetimepicker({
	        language:  'es',
	        format: "dd MM yyyy - HH:ii P",
	        showMeridian: 1,
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	        minuteStep: 30,
	        showMeridian: 1
	    });
	    $('#finaliza').datetimepicker({
	        language:  'es',
	        format: "dd MM yyyy - HH:ii P",
	        showMeridian: 1,
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	        minuteStep: 30
	    });
	</script>
@endpush
@section('content')

	<aside-dashboard selected="reservas"></aside-dashboard>

	<section class="dashboard-container">
		<div class="dashboard-header">
			<h4>PROPUESTA</h4>
		</div>
		<div class="dashboard-body">
			<dasboard-nueva-propuesta 
				evento-id="{{$evento->id}}"
				securitydeposit="{{$espacio->securitydeposit}}"
				cancellationflexibility="{{$espacio->cancellationflexibility}}">
			</dasboard-nueva-propuesta>
		</div>
		<div class="aside-propuesta">
			<div>
				<img src="/{{$espacio->images[0]->name}}" alt="{{$espacio->name}}" class="img-responsive">
			</div>
			<div class="propuesta-datos">
				<h3>{{$espacio->name}}</h3>
				<span>Desde {{$evento->reserva_desde}} hasta {{$evento->reserva_hasta}}</span>
				<div>
					<div class="wt-space-block">
						<label>Espacio (por {{$evento->total_horas}}hs)</label>
						<span>${{number_format($evento->sub_total, 2, '.', ',')}}.-</span>
					</div>
					<div class="propuesta-datos__total">
						<label>Total</label>
						<h3>${{number_format($evento->sub_total, 2, '.', ',')}}.-</h3>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection