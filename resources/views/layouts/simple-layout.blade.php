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

	@include('layouts.menu.simple-header')
	
	{{-- Main Body --}}
	@yield('content')
	<div class="size-indicator col-xs-12">
		<span class="label label-default visible-xs-inline">Extra Small (<768px)</span>
		<span class="label label-primary  visible-sm-inline">Small (≥768px)</span>
		<span class="label label-success visible-md-inline">Medium (≥992px)</span>
		<span class="label label-info visible-lg-inline">Large (≥1200px)</span>
	</div>
    
	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script> {{-- Script provided by Laravel (includes jquery) --}}
	<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script> {{-- Bootstrap Script --}}
	<script type="text/javascript" src="{{ asset('js/main.js') }}"></script> {{-- This is my custom js --}}
	{{-- Custom Scripts --}}
	@yield('custom_script')
	
</body>
</html>