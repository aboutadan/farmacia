<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> @yield('title') | Farmacia Bienstar</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    {{-- Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styles.css')}}">

</head>
<body id="dark">
	
	{{-- Main Body Content--}}
    @yield('content')
    
	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script> {{-- Bootstrap Script --}}
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
	{{-- Custom Scripts --}}
	@yield('custom_script')
	
</body>
</html>