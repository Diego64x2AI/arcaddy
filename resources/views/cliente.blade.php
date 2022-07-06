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
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
	<main>
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		<!-- Slider main container -->
		<div class="swiper">
			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">
				@foreach($cliente->banners as $banner)
				<div class="swiper-slide">
					<img src="{{ asset('storage/'.$banner->archivo) }}" class="object-fill w-full h-auto">
				</div>
				@endforeach
			</div>
			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>
		</div>
	</main>
	<script>
		window.addEventListener('load', function() {
			const swiper = new Swiper('.swiper', {
				// Optional parameters
				direction: 'horizontal',
				loop: false,
				pagination: {
					el: '.swiper-pagination',
				},
			});
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

		.swiper-pagination-bullet-active {
			background: {{ $cliente->color }} !important;
		}
	</style>
</body>

</html>
