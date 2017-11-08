@extends('layouts.dark-layout')

@section('title', 'Inicio')

@section('content')
	<div class="container">
		<div class="col-xs-12 pad-0 login-container">
			<div class="col-xs-12 col-sm-6 right welcome">
				<h3 class="green">Farmacia Bienstar</h3>
				<h4>¡Bienvenido!</h4>
			</div>	
			<div class="col-xs-12 col-sm-6 form clear">
				<div class="col-xs-12 col-md-10 col-lg-8" style="display: inline-block;">
					
					<form method="post" accept="{{ asset('login') }}">

					{{ csrf_field() }}
					
					{{ place_dropdown('branch', 'Sucursal', array('Tierra Arbolada', 'Séptimo Sol'), old('branch'), ['required' => true]) }}

					{{ place_input('email', 'Email', old('email'), ['required' => true]) }}

					{{ place_input('password', 'Contraseña', '', array('type' => 'password', 'required' => true)) }}
					
					@if ($errors->any())
					    <div class="col-xs-12 pad-0 marTop-1">
					        <ul class="error_message">
					            @foreach ($errors->all() as $error)
					                <li>* {{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif

					<div class="button_container">
						<button type="submit" class="button green">Ingresar</button> <br />
						<a class="link green small" href="{{ asset('password/reset') }}">¿Olvidaste tu contraseña?</a>
					</div>
					
					</form>
				</div>
			</div> {{-- End of Form --}}
		</div> {{-- End of Login Container --}}
	</div>

@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
@endsection

<!--  -->