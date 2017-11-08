@extends('layouts.simple-layout')

@section('title', 'Cambiar Contraseña')

@section('content')
	<div class="container">
		<div class="row">
			<div class="section_container col-md-4 col-md-offset-4 marTop-3">
				<div class="row form title">
					Cambiar Contraseña
				</div>
				<div class="row form default">
					<div class="col-xs-12">
						<p>Ingresa los siguientes datos para cambiar tu contraseña.</p>
						<form method="post" action="{{ asset('password/reset') }}">

							{{ csrf_field() }}

							<input type="text" name="token" value="{{ isset($token) ? $token : null }}" hidden="true"> 

							{{ place_input('email', 'Correo Electrónico \'@\'', old('email', (isset($email) ? $email : null))	, ['required' => true, 'autofocus' => true]) }}

							{{ place_input('password', 'Contraseña', old('password'), ['required' => true, 'type' => 'password']) }}

							{{ place_input('password_confirmation', 'Confirmar Contraseña', old('confirm_password'), ['required' => true, 'type' => 'password']) }}

							@if($errors->any())
								@foreach($errors->all() as $error)
									<div class="col-xs-12 pad-0">
										<ul class="error_message">
											<li>{{ $error }}</li>
										</ul>
									</div>
								@endforeach
							@endif
							<div class="col-sm-12 pad-0">
								<p class="small">* La contraseña debe ser entre 6 y 30 caracteres.<br />
								 				 * La contraseña debe tener al menos un número.</p>
							</div>

							<div class="col-xs-12 button_container">
								<button type="submit" class="button green">Confirmar</button>
							</div>
						</form>
					</div> {{-- End of Col-xs-12 --}}
				</div>{{-- End of Form Default --}}
			</div>{{-- End of Section Container --}}
		</div>
	</div>
@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
@endsection