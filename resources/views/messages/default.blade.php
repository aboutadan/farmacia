@extends('layouts.default-layout')

@section('title', $title) 


@if(isset($redirect))
    @section('redirect')
        <meta http-equiv="refresh" content="5;url={{ $url }}" />
    @endsection
@endif

@section('content')
	<div class="section">
        <div class="row form title {{ $type }}">
            <span></span>
        </div>

        <div class="row form default">
            <div class="col-sm-12 message center">
                <h4>{{ $title }}</h4>
                
                <p>{{ $message }}</p>
                <br />
                <p>
                	<a href="{{ $url }}" class="button green">Regresar</a>
            	</p>
            </div>
        </div>
    </div>
@endsection