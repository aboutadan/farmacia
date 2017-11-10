@extends('layouts.default-layout')

@section('title', 'Editar Perfil')

@section('content')
	<div class="section">
		<div class="row form title">
			Actualizar Perfil
		</div>
		<div class="row form default">
        	<form action="{{ asset('patient/edit/'.Request::segment(3) ) }}" method="post">

        		{{ csrf_field() }}

        		<div class="col-sm-12 col-md-10 col-md-offset-1 pad-0">
        			<div class="row mar-0">
		    			<div class="col-md-4 subtitle">
							Datos Personales
		    			</div>

		    			<div class="col-md-8">
		    				<div class="row">
					            <div class="col-md-6">
					                {{ place_input ('nombre', 'Nombre *', old('nombre', $details->nombre), array('autofocus' => 'true')) }}
					            </div>

					            <div class="col-md-6">
					                {{ place_input('apellido', 'Apellido *', old('apellido', $details->apellido)) }}
					            </div>
				        	</div>

							@php 
								if($details->fecha_nacimiento === '0000-00-00') $age = '';
								else $age = format_date($details->fecha_nacimiento, 'form');
							@endphp

							{{ place_input('dob', 'Fecha de Nacimiento *', old('dob', $age), array('data-toggle' => 'datepicker', 'readonly' => true)) }}

			            	@php
			            		switch($details->sexo) {
			            			case '1': 
			            				$sexo = 'Masculino'; 
			            				break; 
			            			case '2': 
			            				$sexo = 'Femenino'; 
			            				break; 
			            			default: 
			            				$sexo = '-'; 
			            				break;
			            		}
			            	@endphp
			            	{{ place_dropdown('sexo', 'Sexo *', array('Masculino', 'Femenino'), old('sexo', $sexo)) }}

			        	</div>
		        	</div> {{-- End of first row --}}
	        		
	        		<div class="col-sm-12">
	        			<div class="divider gray"></div>
	        		</div>

		            <div class="row mar-0">
		            	<div class="col-md-4 subtitle">
		            		Información de Contacto
		            	</div>
		            	<div class="col-md-8">
				            {{ place_input('telefono1', 'No. Fijo', old('telefono1', $details->telefono1)) }}
				            
				            {{ place_input('telefono2', 'No. Móvil', old('telefono2', $details->telefono2)) }}

				            {{ place_input('email', 'Correo Electrónico', old('email', $details->email), array('type' => 'email')) }}

				            <div class="col-xs-12 padTop-1">
				                <p class="small">* En caso de no contar con alguno de estos datos, deje el campo <strong>vacio</strong>. 
				                Como buena práctica, es sugerible obtener algun número de contacto en caso de ser necesario 
				                comunicarse con el paciente.</p>
				            </div>
				        </div>
		            </div>
	            
	            
	            	<div class="col-sm-12">
	            		<div class="divider gray"></div>
	            	</div>
		            
		            <div class="row mar-0">
		            	<div class="col-md-4 subtitle">
		            		Campos Adicionales
		            	</div>
						
						<div class="col-md-8"> 
				            {{ place_textarea('notas', 'Notas', old('notas', $details->notas)) }}

				            {{ place_textarea('alertas', 'Alertas', old('alertas', $details->alertas)) }}

				            <div class="col-xs-12 pad-1">
				                <p class="small">* El campos 'Alertas' estará disponible en al imprimir la receta médica. Debido a esto, el campo esta limitado a 100 caracteres.<br />
				                * Este dato estará disponibles al crear la receta médica.</p>
				            </div>
			        	</div>
		        	</div>
	            
	                @if($errors->any())
						<div class="col-xs-12 notes">
							<ul class="error_message">
								@foreach($errors->all() as $error)
									<li>* {{ $error }} </li>
								@endforeach
							</ul>
						</div>
	                @endif
	        
		            <div class="col-xs-12 marTop-1 marBot-2 button_container">
		                <button id="submit" type="submit" class="button green">Actualizar</button> <br />
		                <a class="link red" href="{{ asset('patient/deactivate/'.Request::segment(3)) }}">Desactivar Perfil</a>
		            </div>
		        </div>{{-- End of col-sm-10 --}}
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
				autoHide: true, 
				format: 'dd/mm/yyyy'
			});
		});
	</script>
@endsection