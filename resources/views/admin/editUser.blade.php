@extends('layouts.default-layout')

@section('title', 'Editar Usuario')

@section('content')

	<div class="section">
		<div class="row form title">
			Editar Usuario
		</div>
		<div class="row form default">
			<form method="post" action="{{ Request::fullUrl() }}">
				{{ csrf_field() }}

				<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
					<div class="col-xs-12 col-md-4 subtitle">
						Datos Personales
					</div>
					<div class="col-ss-12 col-md-8">
						@php 
							$options = ['Sr.', 'Srita.', 'Sra.', 'Dr.', 'Dra.'];
							sort($options);
						@endphp
						{{ place_dropdown('title', 'Titulo', $options, old('title', $user->title)) }}
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								{{ place_input('fname', 'Nombre', old('fname', $user->fname)) }}
							</div>
							<div class="col-xs-12 col-sm-6">
								{{ place_input('lname', 'Apellido', old('lname', $user->lname)) }}
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
						{{ place_input('email', 'Correo Electrónico', old('email', $user->email), ['type' => 'email']) }}
					</div>
				</div>

				<div class="col-xs-12 col-md-10 col-md-offset-1">
					<div class="divider gray"></div>
				</div>

				<div class="col-xs-12 col-md-10 col-md-offset-1 pad-0">
					<div class="col-xs-12 col-md-4 subtitle">
						Contraseña
					</div>
					<div class="col-xs-12 col-md-8">
						<div id="passwordContainer" class="col-sm-12 pad-0">

							{{ place_input('password', 'Contraseña', old('password'), ['type' => 'password', 'readonly' => true]) }}

							{{ place_input('password_confirmation', 'Confirmar Contraseña', old('password_confirmation'), ['type' => 'password', 'readonly' => true]) }}

							<div class="col-sm-12 pad-0">
								<p class="small">* La contraseña debe contener entre 6 y 30 caracteres.<br />
								 				 * La contraseña debe contener al menos un número.</p>
							</div>

						</div>

						<div class="col-xs-12 pad-0">
							<a id="changePassword" class="button blue" href="javascript:void(0);">Cambiar Contraseña</a>
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
								<li>Intente nuevamente.</li>
							</ul>
						</div>

						<div class="col-xs-12 col-md-4 button_container">
							<button class="button green" type="submit">Actualizar</button>
						</div>
					</div>
				@else
					<div class="col-xs-12 col-md-10 col-md-offset-1 button_container padTop-1">
						<button class="button green" type="submit">Actualizar</button>
					</div>
				@endif

				</div>
			</form>
		</div>
	</div>

@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js')}}"></script>
	<script type="text/javascript">
		$(function() {
			$('#changePassword').on('click', function() {
				$('#passwordContainer').slideDown(200);
				$('#fl_password, #fl_password_confirmation').removeAttr('readonly');
				$('#fl_password').focus();
				$(this).slideUp(200);
			});
		});
	</script>
@endsection