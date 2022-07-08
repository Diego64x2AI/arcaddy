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
		<section id="informacion" class="p-5 mt-5">
			@if ($cliente->titulo !== NULL && $cliente->titulo !== '')
			<h1 class="color text-center font-extrabold text-4xl">{{ $cliente->titulo }}</h1>
			@endif
			@if ($cliente->subtitulo !== NULL && $cliente->subtitulo !== '')
			<h2 class="text-center font-extrabold text-2xl px-8">{{ $cliente->subtitulo }}</h2>
			@endif
			@if ($cliente->fecha !== NULL && $cliente->fecha !== '')
			<div class="text-center font-bold text-xl mt-2">{{ $cliente->fecha }}</div>
			@endif
			@if ($cliente->descripcion !== NULL && $cliente->descripcion !== '')
			<p class="text-center text-base px-4 mt-5">{!! nl2br($cliente->descripcion) !!}</p>
			@endif
		</section>
		<section id="colaboradores" class="mt-5 py-5">
			<div id="colaboradores-swiper" class="swiper">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					@foreach($cliente->colaboradores as $colaborador)
					<div class="swiper-slide">
						@if ($colaborador->talento !== NULL && $colaborador->talento !== '')
						<div class="text-center text-2xl font-extrabold ">{{ $colaborador->talento }}</div>
						@endif
						<div class="mt-5 relative">
							<img src="{{ asset('storage/'.$colaborador->archivo) }}" class="object-fill w-full h-auto">
							<div class="swiper-pagination"></div>
						</div>
						@if ($colaborador->nombre !== NULL && $colaborador->nombre !== '')
						<div class="color text-center font-extrabold text-4xl mt-3">{{ $colaborador->nombre }}</div>
						@endif
						@if ($colaborador->descripcion !== NULL && $colaborador->descripcion !== '')
						<p class="text-center text-base px-4 mt-5">{!! nl2br($colaborador->descripcion) !!}</p>
						@endif
					</div>
					@endforeach
				</div>
			</div>
		</section>
		@if($cliente->patrocinadores->count() > 0)
		<section id="patrocinadores" class="mt-5 py-5 text-center">
			<div class="text-center font-extrabold text-4xl">Patrocinadores</div>
			<div class="color text-center font-extrabold text-4xl">{{ $cliente->titulo }}:</div>
			<div class="flex flex-col flex-wrap items-center justify-center">
				@foreach($cliente->patrocinadores as $patrocinador)
				<div class="w-full md:w-1/2 lg:w-1/3 px-2 mt-10">
					<img src="{{ asset('storage/'.$patrocinador->archivo) }}" class="object-fill w-3/4 h-auto inline">
				</div>
				@endforeach
			</div>
		</section>
		@endif
		@if($cliente->blog->count() > 0)
		<section id="blog" class="mt-5 py-5 text-center">
			<div class="text-center text-4xl">Life<span class="color font-extrabold">Style</span></div>
			<div id="blog-swiper" class="swiper mt-5">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper pb-14">
					@foreach($cliente->blog as $entry)
					<div class="swiper-slide">
						<div><img src="{{ asset('storage/'.$entry->archivo) }}" class="object-fill w-full h-auto inline"></div>
						@if ($entry->titulo !== NULL && $entry->titulo !== '')
						<div class="text-center text-3xl font-extrabold px-5 mt-5">{{ $entry->titulo }}</div>
						@endif
						@if ($entry->descripcion !== NULL && $entry->descripcion !== '')
						<p class="text-center text-base px-4 mt-5">{!! nl2br($entry->descripcion) !!}</p>
						@endif
						@if ($entry->link !== NULL && $entry->link !== '')
						<div class="text-center mt-4"><a href="{{ $entry->link }}" class="btn-pill" target="_blank">Ver más</a></div>
						@endif
					</div>
					@endforeach
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</section>
		@endif
	</main>
	<footer class="mt-5">
		<div class="flex items-center justify-center">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		@if ($cliente->instagram !== '' || $cliente->facebook !== '' || $cliente->twitter !== '')
		<div class="text-center mt-5">
			<div class="text-xl">Síguenos:</div>
			<div class="text-center mt-3 flex flex-row items-center justify-center">
			@if ($cliente->instagram !== '' && $cliente->instagram !== NULL)
			<a href="{{ $cliente->instagram }}" target="_blank" class="mr-2"><img src="{{ asset('images/instagram.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cliente->facebook !== '' && $cliente->facebook !== NULL)
			<a href="{{ $cliente->facebook }}" target="_blank" class="mr-2"><img src="{{ asset('images/facebook.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cliente->twitter !== '' && $cliente->twitter !== NULL)
			<a href="{{ $cliente->twitter }}" target="_blank"><img src="{{ asset('images/twitter.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			</div>
		</div>
		@endif
		<div class="degradado px-5 py-6 mt-5 text-white">
			<div class="flex flex-row items-center justify-between">
				<div>
					<img src="https://arcaddy.dev/images/logo@2x.png" class="block h-6 w-auto fill-current text-gray-600">
				</div>
				<div class="text-lg">Reality is an illusion...</div>
			</div>
		</div>
	</footer>
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

		.btn-pill {
			background-color: {{ $cliente->color }} !important;
		}

		.color {
			color: {{ $cliente->color }} !important;
		}

		.swiper-pagination-bullet-active {
			background: {{ $cliente->color }} !important;
		}
	</style>
</body>

</html>
