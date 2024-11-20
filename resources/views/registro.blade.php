<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/6167140cfb.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-40ZEQ4JZ0Y"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-40ZEQ4JZ0Y');
	</script>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js"></script>
</head>

<body class="font-sans antialiased overflow-x-hidden">
	@includeIf('componentes.header')
	<main class="px-5 pb-20">
		@if($cliente->registro_img !== NULL)
			<div class="mt-3 w-full sm:max-w-md mx-auto text-center">
				<img src="{{ asset('storage/'.$cliente->registro_img) }}" class="inline-block shadow object-cover w-100 h-auto max-w-[200px] border border-secondary rounded-2xl">
			</div>
		@endif
		<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md mx-auto">{{($ver == 0)?'¡Registro exitoso!':'Mi QR'}}</h1>
		<h4 class="color uppercase font-bold text-center mt-5 w-full sm:max-w-md mx-auto">Bienvenido</h4>
		<div class="text-center font-semibold w-full sm:max-w-md mx-auto">{{ Auth::user()->name }}</div>
		<div class="text-center font-semibold w-full sm:max-w-md mx-auto">{{ Auth::user()->email }}</div>
		<div class="w-full sm:max-w-md mx-auto" style="text-align: center; margin-top: 2rem;">

			<img src="{{ asset('storage/qrregister/'.$userQr->codigo.'.png?'.time()) }}" style="width:100%;max-width: 200px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}">

			<?php /*
			<img src="{{ asset('storage/qrcodesr/'.Auth::user()->id.'.png?'.time()) }}" style="width:100%;max-width: 200px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}">
			*/?>
		</div>
		<div class="mx-auto w-full max-w-md">
			@if ($productos->count() > 0)
			<div class="titulo-modulo">Canjes disponibles</div>
			<div class="grid grid-cols-1 gap-3">
				@foreach ($productos->get() as $producto)
					<div class="flex flex-row items-center gap-5 border borde rounded-3xl px-3 pb-3">
						<div class="w-16 min-w-16">
							<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 lg:w-full lg:h-auto object-cover shadow-xl rounded-full">
						</div>
						<div>
							<div>{{ $producto->nombre }}</div>
							<div class="text-sm">{{ $producto->descripcion }}</div>
						</div>
					</div>
				@endforeach
			</div>
			@endif
			@if ($productos2->count() > 0)
			<div class="titulo-modulo mt-10">Canjes realizados</div>
			<div class="grid grid-cols-1 gap-3">
				@foreach ($productos2->get() as $producto)
					<div class="flex flex-row items-center gap-5 border borde rounded-3xl px-3 pb-3 relative">
						<div class="w-16 min-w-16">
							<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 lg:w-full lg:h-auto object-cover shadow-xl rounded-full">
						</div>
						<div>
							<div>{{ $producto->nombre }}</div>
							<div class="text-sm">{{ $producto->descripcion }}</div>
						</div>
						<div class="absolute w-full h-full flex flex-row items-center justify-center" style="top: -1px; left: -1px; width: calc(100% + 2px); height: calc(100% + 2px);">
							<div class="bg-semitransparent w-full h-full top-0 left-0 absolute z-0"></div>
							<div class="btn-pill2 uppercase font-bold z-50">Canjeado</div>
						</div>
					</div>
				@endforeach
			</div>
			@endif
		</div>
		<div class="my-10 text-center w-full sm:max-w-md mx-auto">
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
	@includeIf('componentes.footer')
	<script>
		window.addEventListener('load', function() {
			$('body').css('paddingTop', $('#header').innerHeight());
		});
	</script>
	@include('componentes.estilos')
</body>

</html>
