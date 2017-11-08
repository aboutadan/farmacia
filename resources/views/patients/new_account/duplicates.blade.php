<div class="col-xs-12 subtitle l">
	Resultado(s) encontrados por: <strong class="upper">{{ $sectionTitle }}</strong>
</div>

<div class="col-sm-12 result_titles hidden-xs hidden-sm">
	<span class="col-sm-2">No. de Perfil</span>
    <span class="col-sm-6">Nombre de Paciente</span>
    <span class="col-sm-2 center">Edad</span>
    <span class="col-sm-2"></span>
</div>

@foreach($results as $result) 
	<div class="col-xs-12 results">
        <div class="inner">
    		<div class="col-xs-2 count"> {{ $result->id }}</div>
            <div class="col-xs-10 col-sm-6 name">{{ $result->nombre.' '.$result->apellido  }}</div>
            @php
            	if($result->fecha_nacimiento === '0000-00-00') {
    				$age = age($result->tipo_edad, $result->edad);
            	} else {
    				$age = get_age($result->fecha_nacimiento);
            	}
            @endphp
            <div class="col-xs-10 col-xs-offset-2 col-md-2 col-md-offset-0 age center">
                <span class="inner_title">Edad: </span>{{ $age }}
            </div>
            <div class="col-xs-10 col-xs-offset-2 col-md-2 col-md-offset-0">
                <a class="inner_button" href="{{ asset('/patient/details/'.$result->id.'?status=1') }}" target="_blank">
                    <i class="fa fa-eye" aria-hidden="true"></i> Ver Perfil
                </a>
            </div>
        </div>
	</div>
@endforeach


		

