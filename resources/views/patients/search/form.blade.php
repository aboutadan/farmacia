@extends('layouts.default-layout')

@section('title', 'Busqueda')

@section('content')
	<div class="section">
		<div class="row form title">
			Busqueda
		</div>
		
		<div class="row form default">
			<form action="{{ asset('search/results') }}" method="POST">
				{{ csrf_field() }}
				<div class="col-xs-12 col-sm-7">
					{{ place_input('buscar', 'Buscar', old('buscar', $search), array('autofocus' => true)) }}
				</div>

				<div class="col-xs-8 col-sm-3">
					@php 
						$list = ['Nombre', 'Apellido', 'No. de Teléfono', 'Correo Electrónico'];
					@endphp
					{{ place_dropdown('por', 'Por', $list, old('por', ucfirst($searchby))) }}
				</div>

				<div class="col-xs-4 col-sm-2 center">
					<button id="search" type="submit" class="button green auto"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>

				@if ($errors->any())
					<div class="row mar-0 marTop-1">
						<div class="col-sm-12">
							<ul class="error_message">
								@foreach ($errors->all() as $error)
					                <li>* {{ $error }}</li>
					            @endforeach
							</ul>
						</div>
					</div>
				@endif
			</form>

			@if(isset($cliente))
				<div class="col-xs-12 pad-0 marTop-1"> 
					{{ $cliente->appends(['buscar' => $search, 'por' => $searchby])->links('layouts.other.pagination', ['results' => $cliente]) }}
				</div>
				<div class="row mar-0 hidden-xs hidden-sm">
					<div class="col-xs-12 result_titles">
			            <span class="col-xs-1">#</span>
			            <span class="col-xs-7 col-lg-6">Nombre de Paciente</span>
			            <span class="col-xs-2 col-lg-3">Ultima Visita</span>
			            <span class="col-xs-2 center">Edad</span>
			        </div>
			    </div>

				<div class="row mar-0"> 
					@foreach($cliente as $count => $paciente)
						<div class="col-xs-12 results">
							<a href="{{ asset('patient/details/'.$paciente->id.'?status=1') }}">
								@if(!isset($_GET['page']) || $_GET['page'] === 1)
									<div class="col-xs-1 count">{{ ++$count }}</div>
								@else
									<div class="col-xs-1 count">{{ (($_GET['page'] - 1) * 15) + (++$count) }}</div>
								@endif
								@php
									if($paciente->created_at < '2017-10-10') {
										$age = age($paciente->tipo_edad, $paciente->edad);
									} else $age = get_age($paciente->fecha_nacimiento);
								@endphp
								<div class="col-xs-11 col-sm-7 col-lg-6 name">{{ $paciente->nombre.' '.$paciente->apellido }}</div>
								
								<div class="col-xs-11 col-xs-offset-1 col-sm-11 col-sm-offset-1 col-md-2 col-md-offset-0 col-lg-3 date">
									<span class="inner_title">Ultima Visita: </span> {{ format_date($paciente->created_at, 'short') }}
								</div>

								<div class="col-xs-11 col-xs-offset-1 col-sm-11 col-sm-offset-1 col-md-2 col-md-offset-0 age">
									<span class="inner_title">Edad: </span>{{ $age }}
								</div>
							</a>
						</div>
					@endforeach

				</div>
				{{-- This option should only show in small devices --}}
				{{ $cliente->appends(['buscar' => $search, 'por' => $searchby])->links('layouts.other.paginationLinks', ['results' => $cliente]) }}

			@endif
		</div>

	</div>

	@include('patients.search.notesCreated')
	
@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
	<script type="text/javascript">

		$(function() {

			var value = $('#fl_por').val(); 

			console.log(value);

			if(value !== '') {

				switch(value) {
					case 'Nombre':
					case 'Apellido':
						$('#fl_buscar').attr({ type: "text" });
						break; 
					case 'No. de Teléfono':
						$('#fl_buscar').attr({ type: "number" });
						break;
					case 'Correo Electrónico':
						$('#fl_buscar').attr({ type: "email" });
						break;
					default: 
						null; 
						break;
				}
			}
		})

		$('ul#por li').on('click', function() {
			var option = $(this).text();
			switch(option) {
				case 'Nombre':
				case 'Apellido':
					$('#fl_buscar').attr({ type: "text"});
					break; 
				case 'No. de Teléfono':
					$('#fl_buscar').attr({ type: "number"});
					break;
				case 'Correo Electrónico':
					$('#fl_buscar').attr({ type: "email"});
					break;
				default: 
					null; 
					break;
			}


		});
	</script>
@endsection