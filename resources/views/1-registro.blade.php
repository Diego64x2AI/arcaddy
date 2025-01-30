<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
	<!-- Font Awesome Icons -->
	<link href="{{ asset('fontawesome-free-6.7.2-web/css/all.min.css') }}" rel="stylesheet">
	<script src="{{ asset('fontawesome-free-6.7.2-web/js/all.min.js') }}"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
	<main class="px-5 pb-20">
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cliente->logo) }}" style="height: 40px; width:auto" alt="{{ $cliente->cliente }}">
		</div>
		@if($cliente->registro_img !== NULL)
			<div class="mt-3 w-full sm:max-w-md mx-auto">
				<img src="{{ asset('storage/'.$cliente->registro_img) }}" class="img-general shadow object-cover w-100 border border-secondary" style="border-radius:50px">
			</div>
		@endif
		<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md mx-auto">¡Registro exitoso!</h1>
		<h4 class="color uppercase font-bold text-center mt-5 w-full sm:max-w-md mx-auto">Bienvenido</h4>
		<div class="text-center font-semibold w-full sm:max-w-md mx-auto">{{ Auth::user()->name }}</div>
		<div class="text-center font-semibold w-full sm:max-w-md mx-auto">{{ Auth::user()->email }}</div>
		<div class="w-full sm:max-w-md mx-auto" style="text-align: center; margin-top: 2rem;">
			<img src="{{ asset('storage/qrcodesr/'.Auth::user()->id.'.png?'.time()) }}" style="width:100%;max-width: 200px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}">
		</div>
		<div class="my-5 text-center w-full sm:max-w-md mx-auto">
			<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}" class="btn btn-pill font-bold">{{ __('arcaddy.gohome') }}</a>
		</div>
	</main>
	@if ($cliente->slug === 'estafeta')
	<div class="fixed right-0 bottom-0 mr-5 mb-5">
		<div class="bg-[#25D366] py-3 px-5 text-white rounded-full text-xl">
			<a href="https://wa.me/5213326293396?" target="_blank">Ayuda <i class="fa fa-whatsapp"></i></a>
		</div>
	</div>
	@endif
	<script>
		window.addEventListener('load', function() {

		});
	</script>
	<style>
		.swiper {
			width: 100%;
			height: auto;
			overflow: hidden;
		}

		.swiper-pagination-bullet {
			width: 16px !important;
			height: 16px !important;
			background: #E6E6E6 !important;
			opacity: 1 !important;
		}

		.btn-pill {
			background-color: {{ $cliente->color }} !important;
		}

		.color {
			color: {{ $cliente->color }} !important;
		}

		.bg-client {
			background-color: {{ $cliente->color }} !important;
		}

		.swiper-pagination-bullet-active {
			background: {{ $cliente->color }} !important;
		}
	</style>
</body>

</html>
