@extends('layouts.default-layout')

@section('title', 'Nuevo Usuario')

@section('content')

	<div class="section">
		<div class="row form title">
			Nuevo Usuario
		</div>
	
		<div class="row form default">
			<form method="post" action="">

				{{ csrf_field() }}

				<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
					<div class="col-xs-12 col-md-4 subtitle">
						Datos Personales
					</div>
					<div class="col-xs-12 col-md-8">
						@php 
							$options = ['Sr.', 'Srita.', 'Sra.', 'Dr.', 'Dra.'];
							sort($options);
						@endphp

						{{ place_dropdown('title', 'Titulo', $options, old('title')) }}
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								{{ place_input('fname', 'Nombre', old('fname')) }}
							</div>
							<div class="col-xs-12 col-sm-6">
								{{ place_input('lname', 'Apellido', old('lname')) }}
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-xs-12 col-md-10 col-md-offset-1">
					<div class="divider gray"></div>
				</div>

				<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
					<div class="col-xs-12 col-md-4 subtitle">
						Correo Eléctronico
					</div>
					<div class="col-xs-12 col-md-8">
						{{ place_input('email', 'Correo Electrónico', old('email'), ['type' => 'email']) }}
					</div>
				</div>

				<div class="col-xs-12 col-md-10 col-md-offset-1">
					<div class="divider gray"></div>
				</div>

				<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
					<div class="col-sm-4 subtitle">
						Contraseña
					</div>
					<div class="col-sm-8">
						{{ place_input('password', 'Contraseña', old('password'), ['type' => 'password']) }}

						{{ place_input('password_confirmation', 'Confirmar Contraseña', old('password_confirmation'), ['type' => 'password']) }}

						<div class="col-sm-12 pad-0">
							<p class="small">* La contraseña debe ser entre 6 y 30 caracteres.<br />
							 				 * La contraseña debe tener al menos un número.</p>
						</div>
					</div>
				</div>

				@if($errors->all())
					<div class="col-xs-12 col-md-10 col-md-ofset-1 pad-0 marBot-1">
						<div class="col-xs-12 col-md-8">
							<ul class="error_message">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
								<li>Intenta nuevamente.</li>
							</ul>
						</div>

						<div class="col-xs-12 col-md-4 button_container">
							<button class="button green" type="submit">Agregar</button>
						</div>
					</div>
				@else
					<div class="col-xs-12 col-md-10 col-md-offset-1 button_container">
						<button class="button green" type="submit">Agregar</button>
					</div>
				@endif

				</div>
			</form>
		</div>
	</div>

@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js')}}"></script>
@endsection