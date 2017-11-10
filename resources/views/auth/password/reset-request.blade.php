@extends('layouts.simple-layout')

@section('title', 'Cambiar Contraseña')

@section('content')
	<div class="container marTop-3">
		@if(session('status'))
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 alert-success">
                {{ session('status') }}
            </div>
        @endif

		<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 section_container">
			<div class="row form title">
				Restablecer Contraseña
			</div>

			<div class="row form default">
				<div class="col-sm-12">					
					<form method="post" action="{{ asset('password/email')}}">
						{{ csrf_field() }}
						
						{{ place_input('email', 'Correo Eléctronico', old('email'), ['required' => true, 'autofocus' => true, 'type' => 'email']) }}

						{{-- This displays any errors found. --}}
						@if($errors->any())
							@foreach($errors->all() as $error)
							<div class="col-xs-12 pad-0 marTop-1">
								<ul class="error_message">
									<li>{{ $error }}</li>
								</ul>
							</div>
							@endforeach
						@else
							<div class="col-xs-12 pad-0 marTop-1">
								Ingrese su correo electrónico para reestablecer su contraseña.
							</div>
						@endif

						<div class="col-xs-12 pad-0 center">
							<button type="submit" class="button green">Continuar</button>
						</div>
						<div class="col-xs-12 pad-0 marTop-1 marBot-1 center">
							<a href="{{ asset('/login') }}">Regresar</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		
	</div>
@endsection

@section('custom_script')
	<script type="text/javascript" src="{{ asset('js/forms.js') }}"></script>
@endsection