<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/6167140cfb.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
	<main class="mx-auto max-w-md">
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cupon->producto->cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cupon->producto->cliente->cliente }}">
		</div>
		<section id="galeria" class="mt-5 text-center px-5">
			<div id="galeria-swiper" class="swiper swiper-1 mt-5">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper pb-14">
					@foreach($cupon->producto->imagenes as $banner)
					<div class="swiper-slide">
						<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
					</div>
					@endforeach
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</section>
		<section id="informacion" class="p-5 mt-5 max-w-5xl mx-auto lg:px-8">
			<h1 class="text-center font-extrabold text-xl">ID: {{ $cupon->id }}</h1>
			<h1 class="color text-center font-extrabold text-4xl">{{ $cupon->producto->nombre }}</h1>
			<p class="text-center text-base px-4 mt-5">{!! nl2br($cupon->producto->descripcion) !!}</p>
		</section>
		<div class="text-center my-5 px-5">
			<img src="{{ asset("storage/qrcodes/{$cupon->id}.png") }}" class="object-cover w-100 h-auto inline-block">
		</div>
	</main>
	<script>
		window.addEventListener('load', function() {
			new Swiper('.swiper-1', {
				// Optional parameters
				direction: 'horizontal',
				loop: false,
				autoHeight: true,
				pagination: {
					el: '.swiper-pagination',
				},
			});
			new Swiper('.swiper-3', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				loop: false,
				autoHeight: true,
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 0,
					},
				},
				loop: false,
				pagination: {
					el: '.swiper-pagination',
				},
			});
			new Swiper('.swiper-galeria', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				loop: false,
				autoHeight: true,
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 0,
						autoHeight: false,
						grid: {
							rows: 2
						}
					},
				},
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

		.btn-pill {
			background-color: {{ $cupon->producto->cliente->color }} !important;
		}

		.color {
			color: {{ $cupon->producto->cliente->color }} !important;
		}

		.swiper-pagination-bullet-active {
			background: {{ $cupon->producto->cliente->color }} !important;
		}
	</style>
</body>

</html>
