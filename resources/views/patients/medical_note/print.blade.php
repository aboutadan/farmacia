<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Receta Médica</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" href="css/print.css">

</head>
<body>
	<div class="table banner" style="margin-top: 1cm;">
		<div class="table-row">
			<div class="table-cell image">
				<img src="{{ realpath(__DIR__.'/../../..').'\public\images\IPN.png' }}" height="100%">
			</div>
			<div class="table-cell bottom">
				<span class="title">Dra. Elizabeth Vargas Moreno</span><br />
				<strong>Médico Cirujano y Partero</strong><br />
			    Ce. Prof. 6902322
			</div>
			<div class="table-cell bottom" style="text-align: right;">
				<span class="title">Dr. Jacob Esaú Ávila Garcia</span><br />
				<strong>Médico Cirujano y Partero</strong><br />
				Ce. Prof. 6687783
			</div>
			<div class="table-cell image">
				<img src="{{ realpath(__DIR__.'/../../..'.'\public\images\esm.png') }}" height="100%">
			</div>
		</div>
	</div>

	<div class="table" style="margin-bottom: 5px;">
		<div class="table-row">
			<div class="table-cell field" style="width: 60%;">
				<strong>Nombre:</strong>
				<span class="upper">{{ $patient->nombre.' '.$patient->apellido }}</span>				
			</div>
			<div class="table-cell field" style="width: 20%;">
				<strong>Edad:</strong>
				<span class="upper">{{ get_age($patient->fecha_nacimiento)}}</span>
			</div>
			<div class="table-cell field" style="text-align: right !important;">
				<strong>Fecha:</strong>
				<span class="upper">{{ format_date($note->created_at, 'short2') }}</span>
			</div>
		</div>
	</div>

	<div class="table" style="margin-bottom: 15px;">
		<div class="table-row">
			<div class="table-cell field">
				<strong>IDX: </strong>
				<span class="upper">{{ $note->idx }}</span>
			</div>
		</div>
	</div>

	<div class="table">
		<div class="table-row">
			<div class="table-cell" style="width: 75%">
				<strong>TRATAMIENTOS</strong>
				<div class="table" style="padding-left: 10px; padding-right: 30px; margin-top: 3px;">
					@for($x=1;$x<6;$x++)
						
						@php 
							$treatment = $x.'_tratamiento';
							if($x < 5) $border = 'border'; 
							else $border = '';
						@endphp

						@if($note->$treatment != '')
							<div class="table-row">
								<div class="table-cell treatment {{ $border }}" style="width: 10%;">{{ $x }}</div>
								<div class="table-cell treatment {{ $border }} upper">{{ $note->$treatment }}</div>
							</div>
						@else
							<div class="table-row">
								<div class="table-cell treatment {{ $border }}" style="width: 10%;">{{ $x }}</div> 
								<div class="table-cell treatment {{ $border }}">--</div>
							</div>
						@endif
					@endfor
				</div>
			</div>

			<div class="table-cell">
				<strong>CAMPOS ADICIONALES</strong>
				<div class="table" style="padding-left: 10px; margin-top: 10px;">
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
			                'glc'   => 'mg/dl',
			                'revision' => null
			            );
			        @endphp

			        @foreach($options as $option => $ending)
			        	@php
		            		$value = $note->$option;

		                	switch($option) {
		                		case 'talla': 
		                		case 'peso': 
		                			$class = 'caps'; 
		                			break;
		                		case 'ta':
		                			$class = 'upper'; 
		                			$value = $note->ta;
		                			break; 
		                		case 'revision':
		                			$class = 'caps';
		                			$value = format_date($note->revision, 'short');
		                			break;
		                		default: 
		                			$class = 'upper';
		                			break;
		                	}
		                @endphp
			            @if($note->$option != null || $note->$option != '')
			            	
			                <div class="table-row">
			                	<div class="table-cell other {{ $class }}" style="width:40px;">{{ $option }}</div>
			                	<div class="table-cell other">{{ $value.' '.$ending}}</div>
							</div>
			            @else
			            	<div class="table-row">
			            		<div class="table-cell other {{ $class}}" style="width: 40px;">{{ $option }}</div>
			            		<div class="table-cell other">--</div>
				            </div>
				        @endif
			        @endforeach
				</div>
			</div>
		</div>
	</div>

	<div class="table footer">
		<div class="table-row">
			<div class="table-cell">
				@if(session('branch') === 'Tierra Arbolada')
					Calle Tierra Arbolada S/N, Colonia Sección Parques, Cuautitlan Izcalli, MEX - A un costado de Domino's Pizza | Tel: (55) 6546 - 1494
				@elseif(session('branch') === 'Séptimo Sol')
					Calle Séptimo Sol, esquina Dios Pájaro, S/N, Sección Parques, Cuautitlan Izcalli, EDO | Tel: (55) 7160-3184
				@endif
			</div>
		</div>
	</div>

	<div class="divider"></div>


	<div class="table banner" style="margin-top: 2.8cm; position: relative;">

		<div class="copy">COPIA</div>			
		<div class="table-row">
			<div class="table-cell image">
				<img src="{{ realpath(__DIR__.'/../../..').'\public\images\IPN.png' }}" height="100%">
			</div>
			<div class="table-cell bottom">
				<span class="title">Dra. Elizabeth Vargas Moreno</span><br />
				<strong>Médico Cirujano y Partero</strong><br />
			    Ce. Prof. 6902322
			</div>
			<div class="table-cell bottom" style="text-align: right;">
				<span class="title">Dr. Jacob Esaú Ávila Garcia</span><br />
				<strong>Médico Cirujano y Partero</strong><br />
				Ce. Prof. 6687783
			</div>
			<div class="table-cell image">
				<img src="{{ realpath(__DIR__.'/../../..'.'\public\images\esm.png') }}" height="100%">
			</div>
		</div>
	</div>

	<div class="table" style="margin-bottom: 5px;">
		<div class="table-row">
			<div class="table-cell field" style="width: 60%;">
				<strong>Nombre:</strong>
				<span class="upper">{{ $patient->nombre.' '.$patient->apellido }}</span>				
			</div>
			<div class="table-cell field" style="width: 20%;">
				<strong>Edad:</strong>
				<span class="upper">{{ get_age($patient->fecha_nacimiento)}}</span>
			</div>
			<div class="table-cell field" style="text-align: right !important;">
				<strong>Fecha:</strong>
				<span class="upper">{{ format_date($note->created_at, 'short2') }}</span>
			</div>
		</div>
	</div>

	<div class="table" style="margin-bottom: 15px;">
		<div class="table-row">
			<div class="table-cell field">
				<strong>IDX: </strong>
				<span class="upper">{{ $note->idx }}</span>
			</div>
		</div>
	</div>

	<div class="table">
		<div class="table-row">
			<div class="table-cell" style="width: 75%">
				<strong>TRATAMIENTOS</strong>
				<div class="table" style="padding-left: 10px; padding-right: 30px; margin-top: 3px;">
					@for($x=1;$x<6;$x++)
						
						@php 
							$treatment = $x.'_tratamiento';
							if($x < 5) $border = 'border'; 
							else $border = '';
						@endphp

						@if($note->$treatment != '')
							<div class="table-row">
								<div class="table-cell treatment {{ $border }}" style="width: 10%;">{{ $x }}</div>
								<div class="table-cell treatment {{ $border }} upper">{{ $note->$treatment }}</div>
							</div>
						@else
							<div class="table-row">
								<div class="table-cell treatment {{ $border }}" style="width: 10%;">{{ $x }}</div> 
								<div class="table-cell treatment {{ $border }}">--</div>
							</div>
						@endif
					@endfor
				</div>
			</div>

			<div class="table-cell">
				<strong>CAMPOS ADICIONALES</strong>
				<div class="table" style="padding-left: 10px; margin-top: 10px;">
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
			                'glc'   => 'mg/dl',
			                'revision' => null
			            );
			        @endphp

			        @foreach($options as $option => $ending)
			        	@php
		            		$value = $note->$option;

		                	switch($option) {
		                		case 'talla': 
		                		case 'peso': 
		                			$class = 'caps'; 
		                			break;
		                		case 'ta':
		                			$class = 'upper'; 
		                			$value = $note->ta;
		                			break; 
		                		case 'revision':
		                			$class = 'caps';
		                			$value = format_date($note->revision, 'short');
		                			break;
		                		default: 
		                			$class = 'upper';
		                			break;
		                	}
		                @endphp
			            @if($note->$option != null || $note->$option != '')
			            	
			                <div class="table-row">
			                	<div class="table-cell other {{ $class }}" style="width:40px;">{{ $option }}</div>
			                	<div class="table-cell other">{{ $value.' '.$ending}}</div>
							</div>
			            @else
			            	<div class="table-row">
			            		<div class="table-cell other {{ $class}}" style="width: 40px;">{{ $option }}</div>
			            		<div class="table-cell other">--</div>
				            </div>
				        @endif
			        @endforeach
				</div>
			</div>
		</div>
	</div>

	<div class="table footer">
		<div class="table-row">
			<div class="table-cell">
				@if(session('branch') === 'Tierra Arbolada')
					Calle Tierra Arbolada S/N, Colonia Sección Parques, Cuautitlan Izcalli, MEX - A un costado de Domino's Pizza | Tel: (55) 6546 - 1494
				@elseif(session('branch') === 'Séptimo Sol')
					Calle Séptimo Sol, esquina Dios Pájaro, S/N, Sección Parques, Cuautitlan Izcalli, EDO | Tel: (55) 7160-3184
				@endif
			</div>
		</div>
	</div>













</body>
</html>