@extends('layouts.default-layout')

@section('title', 'Desactivar Perfil')

@section('content')
	<div class="section clear">
		<div class="col-xs-12">
	        <a href="{{ asset('patient/deactivate/'.Request::segment(3)) }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Regresar</a>
	    </div>
	</div>

	<div class="section">
		<div class="row form title">
			Resultado
			<div class="tool_tip quest">
                <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                <span class="tooltext">A esta cuenta se asociaran las recetas y quedará como la cuenta principal.</span>
            </div>
		</div>
	    <div class="row form default">
	        	<div class="row mar-0">
	        		<div class="col-xs-12 col-sm-4 col-md-6 subtitle">
	        			No. de Perfil
	        		</div>
					<div class="col-xs-12 col-sm-8 col-md-6 results">
						<div class="result green">
							{{ $result->id }}
						</div>
					</div>

	        	</div>
				<div class="row mar-0">
            		<div class="col-xs-12 col-sm-4 col-md-6 subtitle">
            			Datos Personales
            		</div>
            		<div class="col-xs-12 col-sm-8 col-md-6 results">
            			<div class="col-xs-12 col-md-8 inner_row">
	            			<span class="value">{{ $result->nombre.' '.$result->apellido }}</span>
	            			<span class="field">Nombre Completo</span>
	            		</div>

						@php
							$options = array('telefono1' => 'No. Fijo', 'telefono2' => 'No. Móvil', 'email' => 'Correo Eléctronico', 'fecha_nacimiento' => 'Edad');
						@endphp
						
						@foreach($options as $option => $label)
							@if($result->$option != null)
								@if($option !== 'fecha_nacimiento')
								<div class="col-xs-12 col-md-8 inner_row">
			            			<span class="value">{{ $result->$option }}</span>
			            			<span class="field">{{ $label }}</span>
			            		</div>
			            		@else
			            		<div class="col-xs-12 col-md-8 inner_row">
			            			<span class="value">{{ get_age($result->$option) }}</span>
			            			<span class="field">{{ $label }}</span>
			            		</div>
			            		@endif
							@endif
						@endforeach
            			
	            		
            		</div>
            	</div>

	            <div class="col-sm-12 marTop-1 center">
	                <p>Si el perfil seleccionado es correcto, da clic en 'Confirmar y Desactivar'.</p>
	            </div>

	            <div class="col-sm-12 marTop-1 center">
	            	<form method="post" action="{{ route('asociate', Request::segment(3)) }}">
	            		{{ csrf_field() }}
	            		<input type="text" name="type" value="asociate" hidden>
	            		<input type="text" name="profileId" value="{{ $result->id }}" hidden>
	                	<button type="submit" class="button green">Confirmar y Desactivar</button>
	                </form>
	                <p class="small marTop-2">* Este proceso no se podra modificar o corregir una vez que se realice el cambio.</p>
	            </div>
	        </div>                 
	    </div>
	</div>
@endsection
