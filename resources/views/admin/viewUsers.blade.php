@extends('layouts.default-layout')

@section('title', 'View Users')

@section('content')

	<div class="section">
		<div class="row form title">
			Usuarios ({{ $users->count() }})
		</div>

		<div class="row form default">
			<div class="col-sm-12 result_titles hidden-xs">
	            <span class="col-sm-1">#</span>
	           	<span class="col-sm-1">Titulo</span>
	            <span class="col-sm-4">Nombre de Usuario</span>
	            <span class="col-sm-4">Correo Electrónico</span>
	        </div>

	        <div class="col-xs-12 result_titles hidden visible-xs">
	        	<span class="col-xs-12 pad-0 hidden visible-xs">
	            	Detalles de Usuarios
	            </span>
	        </div> 

	        @foreach($users as $count => $user)
				<div class="col-sm-12 results">
					<div class="col-xs-12 pad-0 inner">
			            <div class="col-xs-1 pad-0 center">{{ ++$count }}</div>
			           	<div class="col-xs-1 pad-0 center">{{ $user->title }}</div>
			            <div class="col-xs-10 col-sm-4 col-sm-offset-0">{{ $user->fname.' '.$user->lname }}</div>
			            <div class="col-xs-10 col-xs-offset-2 col-sm-4 col-sm-offset-0 email">
			            	{{ $user->email }}
			            </div>
			            <div class="col-xs-10 col-xs-offset-2 col-sm-2 col-sm-offset-0">
			            	<a class="inner_button" href="{{ asset('users/edit/'.$user->id) }}">
			            		Editar
			            	</a>
			            </div>
		        	</div>
		        </div>
	        @endforeach
			
		</div>
	</div>



@endsection