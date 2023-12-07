<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>@yield('titulo')</title>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800;900&display=swap" rel="stylesheet">
	<link href="{{ asset('build/assets/alx-bootstrap.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('build/assets/alx-owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('build/assets/alx-owl-carousel/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('build/assets/alx-css.css')}}?v=10">
    @yield('metas')
</head>
<body>
	<div class="alx-mobile">

		<div id="alx-header">
			<div id="alx-header-etq"
				<span class="alx-w-black">Hola</span>
				<?php /*<img src="{{ asset('/upload/logo/logo-arcaddy-arcaddy.png')}}"> */?>
				
				@if(isset($clientedatos) && $clientedatos->logo != '')
				    <img src="{{ asset('storage/'.$clientedatos->logo) }}"><br>
				@endif
				
				
				
			</div>
		</div>

		<div id="alx-body">
			<div class="alx-mobile">
				 @yield('content')
			</div>
		</div>

        <div id="alx-footerfantasma"></div>
		<div id="alx-footer">
			<div id="alx-footer-logo"></div>
			<div id="alx-footer-txt"></div>
		</div>

	</div>
	<script src="{{ asset('build/assets/alx-jquery.js')}}"></script>
	<script src="{{ asset('build/assets/alx-bootstrap.min.js')}}"></script>
	<script src="{{ asset('build/assets/alx-owl-carousel/owl.carousel.js')}}"></script>
	@yield('js')
</body>
</html>