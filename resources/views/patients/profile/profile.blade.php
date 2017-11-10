@extends('layouts.default-layout')

@section('title', 'Perfil de Paciente')

@section('content')

	<div class="section">
		<div class="row form title">
			<div class="col-xs-12 col-sm-6 details upper">
				<span class="small" style="text-transform: capitalize;">Paciente</span>
				{{ $patient->nombre.' '.$patient->apellido }}
			</div>
			<div class="col-xs-12 col-sm-6 details hidden-xs">
				<ul class="details">
					<li>
						<span class="field">No. de Perfil:</span>
						<span class="value">{{ $patient->id }}</span>
					</li>
					<li>
						<span class="field">Última Actualización:</span> 
						<span class="value">
						{{ $patient->updated_at === '0000-00-00 00:00:00' ? format_date($patient->created_at, 'short') : format_date($patient->updated_at, 'short') }}
						</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="row form default pad">
			<div id="patient_information" class="content visible">
				<div class="col-xs-12 hidden visible-xs patient_info">
					<ul class="contact_info">
						<li class="strong">Acerca de</li>
						<li class="detail">
							<span class="light">No. de Perfil:</span> {{ $patient->id }}
						</li>
						<li class="detail">
							<span class="light">Última Actualización:</span> 
							{{ $patient->updated_at === '0000-00-00 00:00:00' ? format_date($patient->created_at, 'short') : format_date($patient->updated_at, 'short') }}
						</li>
					</ul>					
				</div	>
				<div class="col-sm-4 patient_info">
					<ul class="contact_info"> 
						<li class="strong">Información de Contacto</li>
						@php 
							$empty = true;
							if($patient->telefono1 !== '') {
								echo '<li class="detail"><i title="Número Fijo" class="fa fa-phone" aria-hidden="true"></i>'.format_phone($patient->telefono1).'</li>';
								$empty = false;
							}

							if($patient->telefono2 !== '') {
								echo '<li class="detail"><i title="Número Móvil" class="fa fa-mobile" aria-hidden="true"></i>'.format_phone($patient->telefono2).'</li>';
								$empty = false;
							}

							if($patient->email !== '') {
								echo '<li class="detail"><i title="Correo Electrónico" class="fa fa-envelope-o" aria-hidden="true"></i>'.$patient->email.'</li>';
								$empty = false;
							}

							{{-- This will help set the age of the patient. --}}

							if($patient->fecha_nacimiento === '0000-00-00') $patient_age= age($patient->tipo_edad, $patient->edad);
							else $patient_age = get_age($patient->fecha_nacimiento, 'short');

						@endphp

						@if($empty === true) 
							<li>--</li>
						@endif

					</ul>
				</div> {{-- End of Contact Info--}}

				<div class="col-sm-4 patient_info">
					<ul class="contact_info">
						<li class="strong">Edad y Sexo</li>
						<li>
							<i title="Edad" class="fa fa-birthday-cake" aria-hidden="true"></i>
							{{ format_date($patient->fecha_nacimiento, 'short') }} -  
							<i>{{ $patient_age }}</i>
						</li>
						@php 
							switch($patient->sexo){
								case 1: 
									$sexo = 'Masculino';
									break; 
								case 2:
									$sexo = 'Femenino';
									break; 
								default: 
									$sexo = '--'; 
									break;
							}
						@endphp						
						<li><i class="fa fa-venus-mars" aria-hidden="true"></i> {{ $sexo }}</li>
					</ul>
				</div>

				<div class="col-sm-4 patient_info">
	                <ul class="other_info">
	                	<li class="strong">Alertas</li>
	                	@if($patient->alertas !== '')
	                		<li>{{ $patient->alertas }}</li>
	                	@else
	                		<li>--</li>
	                	@endif
	                </ul>
	            </div> {{-- End of Patient Alerts --}}

			</div> {{-- End of contact information and alerts --}} 

			<div class="row mar-0">
				<div class="col-xs-8 col-xs-offset-2 slide_down">
					<a href="javascript:void(0);" data-open="patient_information" onclick="slideDown(this);">
						Ocultar Detalles <i class="fa fa-angle-double-up" aria-hidden="true"></i>
					</a>
				</div>
			</div>

			<div class="row mar-0">
				<div class="col-sm-12 hidden-xs">
	                <ul class="tab_menu">
	                    <li class="{{ $_GET['status'] === '1' ? 'active' : '' }}"><a id="active" href="{{ Request::url().'?status=1' }}">Consultas Previas</a></li>
	                    <li class="{{ $_GET['status'] === '0' ? 'active' : '' }}"><a id="cancelled" href="{{ Request::url().'?status=0' }}">Cancelaciones</a></li>
	                </ul>
	            </div>

				<div class="col-xs-12 hidden-sm hidden-md hidden-lg">
					@php 
						$status = (int) $_GET['status'];
						if($status === 1) $view_value = 'Consultas Previas'; 
						else $view_value = 'Cancelaciones';
					@endphp
					<div class="col-xs-12 pad-0 marBot-1">
						{{ place_dropdown('view', 'Selecciona el Tipo de Vista', array('Consultas Previas', 'Cancelaciones'), $view_value) }}
					</div>
				</div>

				
				@if($recetas !== null)
					<div class="col-xs-12 pad-0"> 
						{{ $recetas->appends(['status' => $_GET['status']])->links('layouts.other.pagination', ['results' => $recetas]) }}

						<div class="col-sm-12 result_titles hidden-xs hidden-sm">
	                        <span class="col-sm-1">#</span>
	                        <span class="col-sm-5">IDX</span>
	                        <span class="col-sm-3">Fecha Consulta</span>
	                        <span class="col-sm-3">Fecha Revisión</span>
	                    </div>

	                    @php 
	                    	if(!isset($_GET['page'])) $page = 1;
	                    	else $page = $_GET['page'];

	                    @endphp

	                    @foreach($recetas as $position => $receta)
	                    	 @php
	                    	 	$count = (($page - 1) * 10) + (++$position);
	                    	 @endphp
	                    	<div class="col-sm-12 results">
	                            <a href="{{ asset('patient/medical_note/'.Request::segment(3).'/'.$receta->id) }}">
	                                <div class="col-xs-1 count">{{ $count }}</div>
	                                <div class="col-xs-11 col-sm-11 col-md-5 name">{{ $receta->idx }}</div>
	                                <div class="col-xs-11 col-xs-offset-1 col-sm-11 col-sm-offset-1 col-md-3 col-md-offset-0 date">
	                                	<span class="inner_title">Fecha Consulta: </span>{{ format_date($receta->created_at, 'short') }}
	                                </div>
	                                @php 
	                                	switch($receta->revision) {
	                                		case null: 
	                                		case '1969-12-31': 
	                                		case '0000-00-00': 
	                                			$revision = false; 
	                                			break;
	                                		default: 
	                                			$revision = $receta->revision;
	                                			break;
	                                	}
	                                @endphp
	                                @if($revision !== false)
	                                	<div class="col-xs-11 col-xs-offset-1 col-sm-11 col-sm-offset-1 col-md-3 col-md-offset-0 date">
	                                		<span class="inner_title">Fecha Revisión: </span>{{ format_date($revision, 'short') }}
	                                	</div>
	                                @else 
	                                	<div class="col-md-3 date hidden-xs hidden-sm">
	                                		<span class="inner_title">Fecha Revisión: </span> -- 
	                                	</div>
	                                @endif
	                            </a>
	                        </div>	
	                    @endforeach

						{{ $recetas->appends(['status' => $_GET['status']])->links('layouts.other.paginationLinks', ['results' => $recetas]) }}
					</div>

					@else
	                    {{-- Messages in case patient has no previous medical notes (active & cancelled) --}}
	                    <div class="col-xs-12">
	                    	@if($_GET['status'] === '1')
								<div class="col-xs-12 padTop-2 padBot-2 center norm">
									<strong>{{ $patient->nombre }}</strong> aun no cuenta con alguna consulta.<br /><br />
									<a class="button green" href="{{ asset('patient/new_medical_note/'.$patient->id) }}">Nueva Consulta</a>
								</div>
							@else
								<div class="col-xs-12 padTop-2 padBot-2 center norm">
	                                <strong>{{ $patient->nombre }}</strong> aun no cuenta con alguna consulta cancelada.
	                              </div>
							@endif
	                    </div>

					@endif
				
			</div>
		</div>
	</div>
@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
	<script type="text/javascript">

		$(function() {
			$(window).resize(function() {
				$('#patient_information').slideDown(300);
 			});


 			$('#view li').on('click', function() {
 				var value = $(this).text();
 				switch(value) {
 					case 'Cancelaciones':
 						window.location.href = "{{ asset('/patient/details/'.Request::segment(3).'?status=0') }}";
 						break; 
 					case 'Consultas Previas':
 						window.location.href = "{{ asset('/patient/details/'.Request::segment(3).'?status=1') }}";
 						break; 
 					default: 
 						null; 
 						break;
 				}
 			});
		});

		function slideDown(e) {
			var content = '#' + $(e).data('open');
			$(content).slideToggle(300);

			if($(content).hasClass('visible') === true) {
				$(e).html('Ver Detalles <i class="fa fa-angle-double-down" aria-hidden="true"></i>');
				$(content).removeClass('visible');
			} else {
				$(e).html('Ocultar Detalles <i class="fa fa-angle-double-up" aria-hidden="true"></i>');
				$(content).addClass('visible').add;
			}
		}

	</script>
@endsection