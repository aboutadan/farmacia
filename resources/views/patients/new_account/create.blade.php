@extends('layouts.default-layout')

@section('title', 'Nueva Cuenta')

@section('content')
	
	{{-- After user submits form, any duplicate profiles will be displayed below. --}}

	@php 
		$options = [
			'byName' 	=> 'Nombre y Apellido', 
			'byPhone1'	=> 'No. Fijo', 
			'byPhone2'	=> 'No. Móvil', 
			'email'		=> 'Correo Electrónico'
		];
	@endphp
	
	@if(session('insertDuplicates') && session('insertDuplicates') === true)
		<div class="section">
			<div class="row form title">Nuevo Paciente</div>
			<div class="row form default"> 
				@foreach($options as $option => $name)
					@if(session($option))		
						@include('patients.new_account.duplicates', ['results' => session($option), 'sectionTitle' => $name])
					@endif
				@endforeach
				<div class="col-xs-12 marTop-1">
					<p>* Si los resultados no están relacionados, da clic en 'Continuar' para crear la nueva cuenta.</p>
				</div>				
				<div class="col-xs-12 marTop-1 right">
					<a id="add_account" href="javascript:void(0);" class="button green">Continuar</a>
				</div>
			</div>
		</div>
	@endif

	<div id="new_patient" class="section {{ session('insertDuplicates') && session('insertDuplicates') === true ? 'hidden' : '' }}">
		<div class="row form title">Nuevo Paciente</div>
		<div class="row form default">
        	<form action="{{ asset('patient/new/insert') }}" method="post">
        		{{ csrf_field() }}
        		@if(session('insertDuplicates') && session('insertDuplicates') === true)
        			{{-- This input is only displayed if any duplicate accounts are found. --}}
        			<input type="text" name="confirmed_insert" value="2" hidden="true">
        		@endif
        		<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
        			<div class="row mar-0">
        				<div class="col-md-4 subtitle">
        					Datos Personales
        				</div>
        				<div class="col-md-8">
        					<div class="row">
        						<div class="col-md-6">
					                {{ place_input ('nombre', 'Nombre *', old('nombre'), array('autofocus' => 'true')) }}
					            </div>

					            <div class="col-md-6">
					                {{ place_input('apellido', 'Apellido *', old('apellido')) }}
					            </div>
        					</div>
							
							{{ place_input('dob', 'Fecha de Nacimiento *', old('dob'), array('data-toggle' => 'datepicker', 'readonly' => true)) }}

							{{ place_dropdown('sexo', 'Sexo *', array('Masculino', 'Femenino'), old('sexo')) }}	

        				</div>
					</div>{{-- End of first row --}}

    				<div class="col-sm-12">
    					<div class="divider gray"></div>
    				</div>

					<div class="row mar-0">
						<div class="col-md-4 subtitle">
							Información de Contacto
						</div>

						<div class="col-md-8">
							
							{{ place_input('telefono1', 'No. Fijo', old('telefono1')) }}

							{{ place_input('telefono2', 'No. Móvil', old('telefono2')) }}

							{{ place_input('email', 'Correo Electrónico', old('email'), array('type' => 'email')) }}

			                <p class="small justify marTop-1">* En caso de no contar con alguno de estos datos, solo dejar el campo <strong>vacio</strong>. 
			                Como buena practica, es sugerible obtener algun número de contact por si es necesario 
			                comunicarse con el paciente.</p>
						</div>
					</div> {{-- End of Info de Contacto --}}

					<div class="col-sm-12">
						<div class="divider gray"></div>
					</div>

					<div class="row mar-0">
						<div class="col-md-4 subtitle">
							Campos Adicionales
						</div>

						<div class="col-md-8">

							{{ place_textarea('notas', 'Notas', old('notas')) }}

							{{ place_textarea('alertas', 'Alertas', old('alertas')) }}

			                <p class="small justify marTop-1">* El campos 'Alertas' estara disponible en al imprimir la receta medica. Debido a esto, el campo esta limitado a 100 caracteres.<br />
			                * Datos estaran disponibles al crear receta medica.</p>
						</div>
					</div> {{-- End of Campos Adicionales --}}
					
					<div class="row mar-0"> 
						@if($errors->any())
							<div class="col-xs-12">
								<ul class="error_message">
									@foreach($errors->all() as $error)
										<li>* {{ $error }} </li>
									@endforeach
									<li>Intenta nuevamente.</li>
								</ul>
							</div>
		                @endif

						<div class="col-xs-12 submit_container">
			                <button id="submit" type="submit" class="button green">Añadir Paciente</button>
			            </div>
		        	</div>

	        	</div>{{-- End of Col 10 --}}	            
        	</form>
		</div> {{-- End of Form --}}
	</div> {{-- End of Section --}}

@endsection

@section('custom_css')
	<link rel="stylesheet" href="{{ asset('/css/datepicker/datepicker.css') }}">
@endsection

@section('custom_script')
	<script src="{{ asset('/js/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/forms.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/datepicker/datepicker.js') }}"></script>
	<script type="text/javascript">
		$(function() {
			$.fn.datepicker;
			
			{{-- This helps trigger the the datepicker. Seems to run slow without it. --}}
			$('#fl_dob').on('click', function() {
				$('[data-toggle="datepicker"]').datepicker('show');
			});

			$('[data-toggle="datepicker"]').datepicker({
				language: 'es-ES',
				autoHide: true
			});

			$('#add_account').on('click', function() {
				$('#submit').trigger('click');
			});

		});
	</script>
	<script type="text/javascript" src="{{ asset('/js/datepicker/datepicker.es-ES.js') }}"></script>
@endsection