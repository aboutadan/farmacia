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
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Pinyon+Script' rel='stylesheet' type='text/css'>
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    

    {{-- Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/medical_note/styles.css') }}">

    @yield('custom_css')

</head>
<body>
	
	{{-- Main Body Content--}}
	@yield('content')
    
	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script> {{-- Script provided by Laravel (includes jquery) --}}
	<script type="text/javascript" src="{{ asset('js/main.js') }}"></script> {{-- This is my custom js --}}
	{{-- Custom Scripts --}}
	@yield('custom_script')
	
</body>
</html>