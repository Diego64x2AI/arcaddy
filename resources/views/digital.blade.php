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
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
	<main class="max-w-7xl mx-auto">
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cupon->producto->cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cupon->producto->cliente->cliente }}">
		</div>
		@if ($cupon->canjeado)
			<div class="my-5 px-5">
				<div class="relative w-full text-center p-4 text-white bg-red-500 rounded-lg">Este item ya ha sido canjeado en la siguiente fecha: {{ $cupon->canjeado_at }}.</div>
			</div>
		@else
			<div class="my-5 px-5">
				<div class="relative w-full text-center p-4 text-white bg-lime-500 rounded-lg"><i class="fa fa-warning"></i> Canjea este item solamente cuando estes en frente de un personal del staff para que te lo entregue, de otra manera ya no podrás recibirlo.</div>
			</div>
		@endif
		<section id="galeria" class="mt-5 text-center lg:mt-10">
			<div id="galeria-swiper" class="swiper swiper-galeria mt-5 lg:mt-10">
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
		<section id="informacion" class="p-5 mt-5 max-w-5xl mx-auto lg:px-8 lg:mt-10">
			<h1 class="text-center font-extrabold text-xl lg:text-2xl">ID: {{ $cupon->id }}</h1>
			<h1 class="color text-center font-extrabold text-4xl lg:text-8xl">{{ $cupon->producto->nombre }}</h1>
			<p class="text-center text-base px-4 mt-5 lg:text-2xl">{!! nl2br($cupon->producto->descripcion) !!}</p>
		</section>
		@if (!$cupon->canjeado)
		<div class="text-center mt-4">
			<a href="{{ route('digital_canjear', ['cupon' => $cupon->id]) }}" class="btn-pill">Canjear</a>
		</div>
		@endif
	</main>
	<footer class="mt-5">
		<div class="flex items-center justify-center">
			<img src="{{ asset('storage/'.$cupon->producto->cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cupon->producto->cliente->cliente }}">
		</div>
		@if ($cupon->producto->cliente->secciones()->where('activa', 1)->where('seccion', 'social')->count() > 0)
		<div class="text-center mt-5">
			<div class="text-xl">Síguenos:</div>
			<div class="text-center mt-3 flex flex-row items-center justify-center">
			@if ($cupon->producto->cliente->instagram !== '' && $cupon->producto->cliente->instagram !== NULL)
			<a href="{{ $cupon->producto->cliente->instagram }}" target="_blank" class="mr-2"><img src="{{ asset('images/instagram.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cupon->producto->cliente->facebook !== '' && $cupon->producto->cliente->facebook !== NULL)
			<a href="{{ $cupon->producto->cliente->facebook }}" target="_blank" class="mr-2"><img src="{{ asset('images/facebook.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cupon->producto->cliente->twitter !== '' && $cupon->producto->cliente->twitter !== NULL)
			<a href="{{ $cupon->producto->cliente->twitter }}" target="_blank"><img src="{{ asset('images/twitter.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			</div>
		</div>
		@endif
		<div class="degradado px-5 py-6 mt-5 text-white">
			<div class="flex flex-row items-center justify-between">
				<div>
					<img src="{{ asset('images/logo@2x.png') }}" class="block h-6 w-auto fill-current text-gray-600">
				</div>
				<div class="text-lg">Reality is an illusion...</div>
			</div>
		</div>
	</footer>
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
