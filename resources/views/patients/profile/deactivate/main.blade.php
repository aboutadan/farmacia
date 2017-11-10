@extends('layouts.default-layout')

@section('title', 'Desactivar Perfil')

@section ('content')
	<div class="section clear">
		<div class="col-xs-12 nav-links">
	        <a href="{{ asset('patient/edit/'.Request::segment(3)) }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Regresar</a>
	    </div>
	</div>

	<div class="section">
		<div class="row form title">
			Desactivar Perfil
		</div>

		@if($find === true)
			{{-- Document was getting too long, created a seperate file to place warning --}}
			@include('patients.profile.deactivate.warning')
		@else
			<div class="col-xs-12 center">
                <h5>¿Está seguro que quiere desactivar la cuenta de <strong> {{ $patient->nombre.' '.$patient->apellido }}</strong>?</h5>
                <div class="col-xs-12 marTop-2 center">
                	<form method="post" action="{{ Request::fullUrl().'/confirmed' }}">
						{{ csrf_field() }}
						<input type="text" name="type" value="confirmed" hidden="true">
						<input type="text" name="id" value="{{ Request::segment(3) }}" hidden="true">
	                	<button type="submit" class="button green">Continuar</button>
		            </form>
		            <p class="small marTop-2"><i>* Una vez que se realice el cambio no se podrá corregir.</i></p>
	            </div>
	        </div>
		@endif

	</div>

@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
@endsection