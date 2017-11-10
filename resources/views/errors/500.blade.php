@extends('layouts.simple-layout')

@section('title', 'Error 500')

@section('content')
<div class="container errors">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3 banner center">
			<span>500</span>
			<p>
				Error del servidor: Se produjo un error y la solicitud no pudo completarse. Intente nuevamente.
				<br /><br />
				<a id="back" href="javascript:void(0);"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
				| <a href="{{ asset('/') }}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
			</p>
		</div>
	</div>
</div>
@endsection

@section('custom_script')
	<script type="text/javascript">
		$(function() {
			$('#back').on('click', function() {
				parent.history.back();
			});
		});
	</script>
@endsection