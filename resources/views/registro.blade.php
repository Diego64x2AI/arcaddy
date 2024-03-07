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
	<main class="px-5 pb-20">
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cliente->logo) }}" style="height: 40px; width:auto" alt="{{ $cliente->cliente }}">
		</div>
		@if($cliente->registro_img !== NULL)
			<div class="mt-3 w-full sm:max-w-md mx-auto">
				<img src="{{ asset('storage/'.$cliente->registro_img) }}" class="img-general shadow object-cover w-100 border border-secondary" style="border-radius:50px">
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
			@if ($cliente->productos()->where('regalado', 1)->whereNotIn('id', $canjeados)->count() > 0)
			<div class="titulo-modulo">Canjes disponibles</div>
			<div class="grid grid-cols-1 gap-3">
				@foreach ($cliente->productos()->where('regalado', 1)->whereNotIn('id', $canjeados)->get() as $producto)
					<div class="flex flex-row items-center gap-5 border-b borde pb-3">
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
			@if ($cliente->productos()->where('regalado', 1)->whereIn('id', $canjeados)->count() > 0)
			<div class="titulo-modulo mt-10">Canjes realizados</div>
			<div class="grid grid-cols-1 gap-3">
				@foreach ($cliente->productos()->where('regalado', 1)->whereIn('id', $canjeados)->get() as $producto)
					<div class="flex flex-row items-center gap-5 border-b borde pb-3 relative">
						<div class="w-16 min-w-16">
							<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 lg:w-full lg:h-auto object-cover shadow-xl rounded-full">
						</div>
						<div>
							<div>{{ $producto->nombre }}</div>
							<div class="text-sm">{{ $producto->descripcion }}</div>
						</div>
						<div class="absolute top-0 left-0 w-full h-full flex flex-row items-center justify-center">
							<div class="bg-semitransparent w-full h-full top-0 left-0 absolute z-0"></div>
							<div class="btn-pill2 uppercase font-bold z-50">Canjeado</div>
						</div>
					</div>
				@endforeach
			</div>
			@endif
		</div>
		<div class="my-10 text-center w-full sm:max-w-md mx-auto">
			<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}" class="btn btn-pill font-bold">Ir a la página principal</a>
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
	@include('componentes.estilos')
</body>

</html>
