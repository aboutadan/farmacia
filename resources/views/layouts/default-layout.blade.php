<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- <meta http-equiv="refresh" content="3;url=http://www.google.com/" /> --}}
    @yield('redirect')

    <title> @yield('title') | Farmacia Bienstar</title>


    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
	@yield('custom_font')

    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">

    {{-- Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styles.css')}}">
    @yield('custom_css')

</head>
<body>
	
	@include('layouts.menu.header')
	
	{{-- Main Body Content--}}
	<div class="container-fluid pad-0">
		<div class="main col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
			@if(session('message'))
				<div id="message_banner" class="section clear">
					<div class="col-sm-12 {{ session('type') === null ? 'alert-success' : 'alert-'.session('type') }}">
					    {{ session('message') }}
					</div>
				</div>
			@endif
	    	@yield('content')
    	</div>
    	<div class="size-indicator col-xs-12">
			<span class="label label-default visible-xs-inline">Extra Small (<768px)</span>
			<span class="label label-primary  visible-sm-inline">Small (≥768px)</span>
			<span class="label label-success visible-md-inline">Medium (≥992px)</span>
			<span class="label label-info visible-lg-inline">Large (≥1200px)</span>
		</div>
    
	</div>
	@yield('other')

	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script> {{-- Script provided by Laravel (includes jquery) --}}
	<script type="text/javascript" src="{{ asset('js/main.js') }}"></script> {{-- This is my custom js --}}
	{{-- Custom Scripts --}}
	@yield('custom_script')
	
</body>
</html>