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
		@foreach($cliente->secciones()->where('activa', 1)->get() as $seccion)
			@includeIf('secciones.'.$seccion->seccion)
		@endforeach
	</main>
	<footer class="mt-5">
		<div class="flex items-center justify-center">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		@if ($cliente->secciones()->where('activa', 1)->where('seccion', 'social')->count() > 0)
		<div class="text-center mt-5">
			<div class="text-xl">Síguenos:</div>
			<div class="text-center mt-3 flex flex-row items-center justify-center">
			@if ($cliente->instagram !== '' && $cliente->instagram !== NULL)
			<a href="{{ $cliente->instagram }}" target="_blank" class="mr-2"><img src="{{ asset('images/instagram.png') }}" class="object-fit w-14 h-auto" alt="Instagram"></a>
			@endif
			@if ($cliente->facebook !== '' && $cliente->facebook !== NULL)
			<a href="{{ $cliente->facebook }}" target="_blank" class="mr-2"><img src="{{ asset('images/facebook.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cliente->twitter !== '' && $cliente->twitter !== NULL)
			<a href="{{ $cliente->twitter }}" target="_blank" class="mr-2"><img src="{{ asset('images/twitter.png') }}" class="object-fit w-14 h-auto" alt="Twitter"></a>
			@endif
			@if ($cliente->tiktok !== '' && $cliente->tiktok !== NULL)
			<a href="{{ $cliente->tiktok }}" target="_blank" class="mr-2"><img src="{{ asset('images/tiktok.png') }}" class="object-fit w-14 h-auto" alt="Tiktok"></a>
			@endif
			@if ($cliente->whatsapp !== '' && $cliente->whatsapp !== NULL)
			<a href="{{ $cliente->whatsapp }}" target="_blank"><img src="{{ asset('images/whatsapp.png') }}" class="object-fit w-14 h-auto" alt="Whatsapp"></a>
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
	<div class="fixed top-0 right-0 px-6 py-4">
		<div class="flex">
			@auth
				@role('admin')
				<a href="{{ route('dashboard') }}" class="text-base mr-4">Dashboard</a>
				@endrole
				<!-- Authentication -->
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<a :href="route('logout')" class="text-base" onclick="event.preventDefault(); this.closest('form').submit();">
						{{ __('Log Out') }}
					</a>
				</form>
			@else
				<a href="{{ route('login', ['cliente' => $cliente->id]) }}" class="text-base">Log in</a>
				@if (Route::has('register'))
				<a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="ml-4 text-base">Register</a>
				@endif
			@endauth
		</div>
	</div>
	<script>
		window.addEventListener('load', function() {
			new Swiper('.swiper-1', {
				// Optional parameters
				direction: 'horizontal',
				loop: false,
				autoHeight: true,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
				pagination: {
					el: '.swiper-pagination',
				},
			});
			new Swiper('.swiper-2', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 2,
				spaceBetween: 10,
				centerInsufficientSlides: true,
				autoHeight: true,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
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
			new Swiper('.swiper-3', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				autoHeight: true,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
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
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
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
