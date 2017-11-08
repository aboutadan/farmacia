@extends('layouts.default-layout')

@section('title', 'Receta Médica')

@section('content')

	@include('patients.medical_note.confirmChange', ['status' => (int) $note->status])

	<div class="section clear">
		<div class="col-xs-12">
	        <a href="{{ asset('patient/details/'.Request::segment(3)) }}">
	        	<i class="fa fa-angle-double-left" aria-hidden="true"></i> Regresar
	        </a>
	    </div>
	</div>

	<div class="section">
		<div class="row form title">
			<span class="small id">ID: {{ $note->id }}</span>
			Consulta Médica
		</div>

	    <div class="row form default">

			<div class="col-sm-12 pad-0 note_details">
		        <div class="col-sm-5">
		            <span class="name">Paciente</span>
		            <span class="detail">{{ $patient->nombre.' '.$patient->apellido }}</span>
		        </div>
		        
		        <div class="col-sm-5">
		            <span class="name">Atendido(a) Por</span>
		            <span class="detail">{{ $doctor->title.' '.$doctor->fname.' '.$doctor->lname }}</span>
		        </div>  
		        
		        <div class="col-sm-2">
		            <span class="name">Estado</span>
		            @php
		            	$status = (int) $note->status;
		            @endphp
		            @if($status === 1)
		            	<span class="detail act">Activo</span>
		            @else
		            	<span class="detail cxl">Cancelado</span>
		            @endif
		        </div>

				{{-- Date and Diagnosis --}}
				<div class="col-sm-12 pad-0 marTop-1 note_details">
		            <div class="col-sm-8">
		                <span class="name">Impresión Diagnostica</span>
		                <span class="detail">{{ $note->idx}}</span>
		            </div>
		            
		            <div class="col-sm-4">
		                <span class="name">Fecha de Consulta</span>
		                <span class="detail">{{ format_date($note->created_at, 'short') }}</span>
		            </div>
		        </div>
				
				{{-- Treaments and Additional Fields --}}
		        <div class="col-sm-12 pad-0 marTop-1 note_details">
		            <div class="col-sm-8">
		                <span class="name">Tratamiento</span>
		                <div class="col-sm-12 pad-0 padTop-1">
		                    @for($x=1;$x < 6; $x++)

								@php 
									// This will help find the correct column in the database.
									$treatment = $x.'_tratamiento';
								@endphp

	                            @if($note->$treatment != null || $note->$treatment != '')
	                                <div class="col-xs-12 pad-0 padBot-1">
                                        <div class="col-xs-1 pad-0 center count">{{ $x }}</div>
                                        <div class="col-xs-11">
                                            <span class="detail">{{ $note->$treatment }}</span>
                                        </div>
                                    </div>
	                            @endif
		                    @endfor
		                </div>
		            </div>

		    		{{-- Additional Fields --}}
			    	<div class="col-sm-4">
		                <span class="name">Campos Adicionales</span>
		                <div class="col-sm-12 pad-0 padTop-1 other">
		                    @php 
		                        // Only the fields that actually have a value will be displayed.
		                        $options = array(
		                            'talla' => 'm', 
		                            'peso'  => 'kg', 
		                            'imc'   => null,
		                            'ta'    => 'mmhg', 
		                            'fc'    => 'x\'', 
		                            'fr'    => 'x\'', 
		                            'temp'  => 'gc', 
		                            'glc'   =>  'mg/dl'
		                        );
		                    @endphp
		                    @foreach($options as $option => $ending)
		                    	@php
				                	switch($option) {
				                		case 'talla': 
				                		case 'peso': 
				                			$class = 'name caps'; 
				                			break;
				                		case 'ta':
				                			$class = 'name upper'; 
				                			break; 
				                		default: 
				                			$class = 'name upper';
				                			break;
				                	}
				                @endphp
		                        @if($note->$option != null || $note->$option != '')
		                        	<div class="col-sm-12">
										<span class="{{ $class}}">{{ $option }}</span>
										<span class="detail">{{ $note->$option.' '.$ending }}</span>
									</div>
		                        @else
		                        	<div class="col-sm-12">
										<span class="{{ $class }}">{{ $option }}</span>
										<span class="detail">--</span>
						            </div>
						        @endif
		                    @endforeach
		                </div>                
		            </div>
		        </div> {{-- End of Treatments and Additional Fields --}}

		        <div class="col-xs-12 button_container">
		        		@php
		        			$current_time = strtotime(date('Y-m-d H:i:s'));
		        			$created_at = strtotime($note->created_at);
		        			$interval  = abs($created_at - $current_time);
							$minutes   = round($interval / 60);
		        		@endphp
		        		@if($minutes < 61)
		        			<a href="{{ asset('patient/edit_medical_note/'.$patient->id.'/'.$note->id) }}" class="button blue">Editar</a>
		        		@endif
			        	<form id="update_form" action="{{ asset('patient/medical_note/update/'.$note->cliente_id) }}" method="post">
			        		{{ csrf_field() }}
			        		<input type="text" name="id" value="{{ $note->id }}" hidden="true">
			        		@if($note->status === 1)
			        			<input type="text" name="changeTo" value="cancel" hidden="true">
			        			<button type="submit" id="updateButton" class="button red">Cancelar</button>
			        		@else
			        			<input type="text" name="changeTo" value="reactivate" hidden="true">
			        			<button type="submit" id="updateButton" class="button green">Reactivar</button>
			        		@endif
			        	</form>
		        </div>
			</div> {{-- End of note details --}}
			
	    </div> {{-- End of Form Div --}}
	</div> {{-- End of Section Div --}}

	@include('patients.medical_note.comments')

@endsection

{{--
@section('other')
	<div id="print_note">
		 @include('patients.medical_note.print')
		 <div class="col-xs-12 divider gray larger"></div>
		 @include('patients.medical_note.print', ['copy' => true])
	</div>
@endsection
--}}

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			var batch = 1,
            	count = $('#comments_count').text(),
            	totalBatch = Math.ceil(count/8), 
            	find = $('#add_more').data('find');
            
            $('#add_more').click(function() {

            	batch++;

            	console.log(batch); 
            	console.log(totalBatch);

                if(batch <= totalBatch) {

                	$.ajaxSetup({
					    headers: {
					        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					    }
					});

                	$.ajax({
                        url: '{{ asset('patient/medical_note/getAdditionalComments') }}',
                        method: 'POST', 
                        dataType: 'json',
                        data: {
                            batch: batch,
                            id: find,
                        },
                        success: function (data) {

                        	$('.comments_section').append(data);                      	
                            
                            setTimeout(function() {
                                if(batch === totalBatch) {
                                    $('#add_more_button').hide();
                                    $('.comments_section').append('<div class="col-sm-12 pad-0 center marTop-1"><i>No hay mas comentarios.</i></div>');
                                }
                            }, 100);
                            
                        }
                    });
                }
            }); {{-- End of Ajax Request --}}

            $('#updateButton').on('click', function() {
            	event.preventDefault();
            	openOverlay();
            });

            $('#confirmChange').on('click', function() {
            	$('#update_form').unbind().submit();
            });            

        });

		$('#print').click(function() {
        	window.print();
        });

	</script>
@endsection