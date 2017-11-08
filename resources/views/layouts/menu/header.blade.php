 <nav class="navbar col-sm-3 col-md-2 affix">
	 
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{ asset('/') }}">Farmacia <strong>Bienstar</strong></a>
		<span class="branch"><strong>Sucursal: </strong> {{ session('branch') }}</span>

	</div>
	
	<div class="welcome">
		<span>Bienvenido {{ Auth::user()->title}}</span>
		<p class="name">{{ Auth::user()->fname.' '.Auth::user()->lname }} </p>
	</div>
	
	<div id="navbar-collapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			{{-- This indicates which menu option has the active class --}}
			@php

				$search = null;
				$patient = null;

				switch(Request::segment(1)) {
					case 'patient':
						if(Request::segment(2) === 'new') $patient = 'active';
						break; 
					case 'search': 
						$search = 'active';
						break;
					default: 
						null;
						break;
				}

			@endphp
			<li class="{{ $search }}">
				<a href="{{ asset('search') }}"><i class="fa fa-search" aria-hidden="true"></i> Inicio</a>
			</li>
			<li class="{{ $patient }}">
				<a href="{{ asset('patient/new') }}"><i class="fa fa-plus" aria-hidden="true"></i> Añadir Paciente</a>
			</li>
			@if(Request::segment(1) === 'patient')
				@php 
					$submenu = false;
					switch(Request::segment(2)){
						case 'details': 
						case 'medical_note': 
						case 'edit':
						case 'new_medical_note':
						case 'edit_medical_note':
							$submenu = true;
							break;
						default: 
							null;
							break;
					}
				@endphp
				@if($submenu === true)
					@php
						$profile = ''; 
						$edit = '';
						$new_note = '';
						switch(Request::segment(2)) {
							case'details': 
								$profile = 'active';
								break; 
							case 'edit': 
								$edit = 'active'; 
								break;
							case 'new_medical_note': 
								$new_note = 'active';
								break;
							default: 
								null; 
								break;
						}
					@endphp
					<li class="active">
						<a href="{{ asset('patient/details/'.Request::segment(3).'?status=1') }}"><i class="fa fa-user" aria-hidden="true"></i> Perfil de Paciente</a>
							<ul> 
								<li>
									<a class="{{ $profile }}" href="{{ asset('patient/details/'.Request::segment(3).'?status=1') }}">
										<i class="fa fa-user" aria-hidden="true"></i> Perfil
									</a>
								</li>
								<li>
									<a class="{{ $new_note }}" href="{{ asset('patient/new_medical_note/'.Request::segment(3)) }}">
										<i class="fa fa-plus" aria-hidden="true"></i> Nueva Consulta
									</a>
								</li>
								<li>
									<a class="{{ $edit }}" href="{{ asset('patient/edit/'.Request::segment(3)) }}">
										<i class="fa fa-pencil" aria-hidden="true"></i> Editar
									</a>
								</li>
								@if(Request::segment(2) === 'medical_note')
									<li>
										<a href="{{ asset('patient/print_medical_note/'.Request::segment(3).'/'.Request::segment(4)) }} " target="_blank">
											<i class="fa fa-download" aria-hidden="true"></i> Descargar PDF 
										</a>
									</li>
								@endif
							</ul>
					</li>
				@endif
			@endif

			@if(Auth::user()->is_admin)
				<li class="{{ Request::segment(1) === 'users' ? 'active' : '' }}">
					<a href="{{ asset('users') }}">
						<i class="fa fa-users" aria-hidden="true"></i>
						Usuarios
					</a>
					@if(Request::segment(1) === 'users')
						<ul>
							<li>
								<a class="{{ Request::segment(2) === 'new' ? 'active' : null }}" href="{{ asset('users/new') }}">
									<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Usuario
								</a>
							</li>
						</ul>
					@endif
				</li>
			@endif

			{{-- Still need to define the sub url --}}

			<li class="last"><a href="{{ url('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sessión</a></li>

		</ul>
	</div>
</nav>