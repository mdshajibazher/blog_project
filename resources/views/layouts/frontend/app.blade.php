<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}- @yield('title')</title>

    
	<!-- Font -->

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">


	<!-- Stylesheets -->
    <link href="{{asset('public/css/toastr.min.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/frontend/css/bootstrap.css')}}" rel="stylesheet">

	<link href="{{asset('public/assets/frontend/css/swiper.css')}}" rel="stylesheet">

	<link href="{{asset('public/assets//frontend/css/ionicons.css')}}" rel="stylesheet">
    
    @stack('css')


    	<!-- SCIPTS -->

	<script src="{{asset('public/assets/frontend/js/jquery-3.1.1.min.js')}}"></script>

	<script src="{{asset('public/assets/frontend/js/tether.min.js')}}"></script>

	<script src="{{asset('public/assets/frontend/js/bootstrap.js')}}"></script>

    <script src="{{asset('public/assets/frontend/js/scripts.js')}}"></script>
         <!-- Tostr Js -->
    <script src="{{asset('public/js/toastr.min.js')}}"></script>
    {!! Toastr::message() !!}
     
    
    @stack('js')

</head>
<body>
    @include('layouts.frontend.partial.header')
    
    @yield('content')

    @include('layouts.frontend.partial.footer')

	




	

</body>
</html>
