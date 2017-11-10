@extends('layouts.default-layout')

@section('title', 'Nueva Receta Médica')

@section('content')
	<div class="section">
		<div class="row form title">
			<div class="col-sm-12 details">
				<span class="small">Nueva Receta Médica</span>
				{{ $patient->nombre.' '.$patient->apellido }}
			</div>
		</div>
		<div class="row form default">
			<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
				<form method="post" action="{{ Request::fullUrl() }}">
					{{ csrf_field() }}
					<div class="row mar-0">
						<div class="col-sm-4 subtitle">
							Impresión Diagnostica
						</div>

						<div class="col-sm-8"> 
							{{ place_input('idx', 'IDX', old('idx'), ['autofocus' => true]) }}
						</div>
					</div>

					<div class="col-sm-12">
						<div class="divider gray"></div>
					</div>

					<div class="row mar-0">
						<div class="col-sm-4 subtitle">
							Tratamiento(s)
						</div>
						<div id="treatments" class="col-sm-8">
							{{ place_textarea('1_tratamiento', 'Tratamiento 1', old('1_tratamiento')) }}
							{{ place_textarea('2_tratamiento', 'Tratamiento 2', old('2_tratamiento')) }}
							<div class="col-sm-12 pad-0 right marTop-1">
								<a href="javascript:void(0);" id="remove" class="button red short">-</a>
								<a id="add_more" href="javascript:void(0);" class="button blue short">+</a>
							</div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="divider gray"></div>
					</div>

					<div class="row mar-0">
						<div class="col-sm-4 subtitle">
							Campos Adicionales
						</div>

						<div class="col-sm-8">
							@php
								$options = array(
									'talla' => 'm', 
									'peso' 	=> 'kg', 
									'imc'	=> '', 
									'ta'	=> 'mmhg', 
									'fc'	=> 'x\'', 
									'fr' 	=> 'x\'', 
									'temp'	=> 'gc', 
									'glc' 	=> 'mg/dl'
								);
							@endphp
							<div class="col-sm-3 pad-0">
								@foreach($options as $option => $val)
									@php
										if($val !== '') $end = ' ('.$val.')'; 
										else $end = null;
									@endphp
									{{ place_input($option, ucfirst($option.$end), old($option)) }}
								@endforeach
							</div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="divider gray"></div>
					</div>

					<div class="row mar-0">
						<div class="col-sm-4 subtitle">
							Programar Cita
						</div>
						<div class="col-sm-8">
							{{ place_input('revision', 'Cita', old('revision'), ['data-toggle' => 'datepicker'])}}
						</div>
					</div>
					<div class="row mar-0">
						<div class="col-xs-12 col-sm-8 marTop-2">
							@if($errors->all())
								<ul class="error_message"> 
									@foreach($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
									<li> Intente nuevamente. </li>
								</ul>
							@endif
						</div>
						<div class="col-xs-12 col-sm-4 button_container">
							<button type="submit" class="button green">Guardar</button>
						</div>
					</div>
				</form>	
			</div> {{-- end of col-sm-10 --}}
		</div> {{-- end of form--}}
	</div> {{-- end of section --}}
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
			var count = 3;

			$('#add_more').on('click', function() {
				var name = count + '_tratamiento';
				var place = 'Tratamiento ' + count;

				var html = '<div class=\"field-container\"><textarea id=\"fl_' + name + '\" placeholder=\"' + place + '\" data-place=\"' + place + '\" name=\"' + name + '\"></textarea></div>';
				if(count < 6) {
					$('#remove').fadeIn(200).css("display","inline-block");
					$('#treatments').find('.field-container').last().after(html);
					count++;
				}
			});

			$('#remove').on('click', function() {
				if(count > 3){ 
					$('#treatments').find('.field-container').last().remove();
					count--;
				}

				if(count === 3) {
					$(this).fadeOut(200);
				}

			});

			$.fn.datepicker;
			
			{{-- This helps trigger the the datepicker. Seems to run slow without it. --}}

			$('#fl_revision').on('click', function() {
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