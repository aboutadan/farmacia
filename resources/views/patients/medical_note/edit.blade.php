@extends('layouts.default-layout')

@section('title', 'Nueva Receta Médica')

@section('content')
	<div class="section col-sm-6 col-sm-offset-3">
		<div class="col-sm-12 form default">
			<div class="col-sm-12 title details">
				<span>Nueva Receta Médica</span>
				{{ $patient->nombre.' '.$patient->apellido }}
				<ul class="details">
					<li><i>No. de Perfil:</i> {{ $patient->id }}</li>
					<li>
						<i>Fecha:</i> 
						{{ format_date(date('Y-m-d'), 'short') }}
					</li>
				</ul>
			</div>

			<div class="col-sm-10 col-sm-offset-1 marTop-1">
				<form method="post" action="{{ Request::fullUrl() }}">
					{{ csrf_field() }}

					<input type="text" name="cliente_id" value="{{ $note->cliente_id }}" hidden>

					<div class="col-sm-12">
						<div class="col-sm-4 subtitle">
							Impresión Diagnostica
						</div>

						<div class="col-sm-8"> 
							{{ place_input('idx', 'IDX', old('idx', $note->idx), ['autofocus' => true]) }}
						</div>
					</div>

					<div class="col-sm-12 divider gray"></div>

					<div class="col-sm-12">
						<div class="col-sm-4 subtitle">
							Tratamiento(s)
						</div>
						<div id="treatments" class="col-sm-8">
							@for($x=1;$x<6;$x++)
								@php 
									$treatment = $x.'_tratamiento';
								@endphp
								@if($note->$treatment !== null)
									{{ place_textarea($treatment, 'Tratamiento '.$x, old($treatment, $note->$treatment)) }}
								@endif
								
							@endfor

							<div class="col-sm-12 pad-0 right marTop-1">
								<a href="javascript:void(0);" id="remove" class="button red short">-</a>
								<a id="add_more" href="javascript:void(0);" data-count="{{ $x }}" class="button blue short">+</a>
							</div>					
						</div>
					</div>

					<div class="col-sm-12 divider gray"></div>

					<div class="col-sm-12">
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
									{{ place_input($option, ucfirst($option.$end), old($option, $note->$option)) }}
								@endforeach
							</div>
						</div>
					</div>

					<div class="col-sm-12 divider gray"></div>

					<div class="col-sm-12">
						<div class="col-sm-4 subtitle">
							Programar Cita
						</div>
						<div class="col-sm-8">
							@php 
								if($note->revision !== null || $note->revision !== '') {
									switch($note->revision) {
										case null: 
                                		case '1969-12-31': 
                                		case '0000-00-00': 
                                			$revision = false; 
                                			break;
                                		default: 
                                			$revision = date('d/m/Y', strtotime($note->revision));
                                			break; 
									}
								}
							@endphp
							{{ place_input('revision', 'Cita', old('revision', $revision), ['data-toggle' => 'datepicker'])}}
						</div>
					</div>
					<div class="col-sm-12 marTop-2 marBot-2">
						<div class="col-sm-8">
							@if($errors->all())
								<ul class="error_message"> 
									@foreach($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
									<li> Intenta nuevamente. </li>
								</ul>
							@endif
						</div>
						<div class="col-sm-4 right">
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
			
			var count = $('#add_more').data('count');

			if(count === 6) {
				// This will show the remove button, in case they need to remove a treatment.
				$('#remove').fadeIn(200).css("display","inline-block");
			}

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