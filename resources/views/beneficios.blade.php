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
	<link href="{{ asset('fontawesome-free-6.7.2-web/css/all.min.css') }}" rel="stylesheet">
	<script src="{{ asset('fontawesome-free-6.7.2-web/js/all.min.js') }}"></script>
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
		<h4 class="color uppercase font-bold text-center mt-5 w-full sm:max-w-md mx-auto">Felicidades</h4>
		<div class="text-center font-semibold w-full sm:max-w-md mx-auto">{{ Auth::user()->name }}</div>
		@if ($beneficios_totales === 0)
			<div class="text-center py-10">Ve a tu perfil para ver tus beneficios disponibles.</div>
		@else
		<div class="mx-auto w-full max-w-md">
			@if ($productos->count() > 0)
			<div class="titulo-modulo">Beneficios disponibles</div>
			<div class="text-center">{{ ($beneficios_totales > 1) ? "Puedes cambiar hasta ".$beneficios_totales." totales." : "Selecciona un beneficio para cambiar." }}</div>
			<div class="grid grid-cols-1 gap-3">
				@foreach ($productos as $producto)
					<div class="flex flex-row items-center gap-5 border borde rounded-3xl px-3 py-3">
						<div class="w-16 min-w-16">
							<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" alt="{{ $producto->nombre }}" class="w-16 h-16 lg:w-full lg:h-auto object-cover shadow-xl rounded-full">
						</div>
						<div>
							<div>{{ $producto->nombre }}</div>
							<div class="text-sm">{{ $producto->descripcion }}</div>
						</div>
						<div class="ml-auto">
							<a href="{{ route('beneficios_cambiar', ['cliente' => $cliente->id, 'producto' => $producto->id]) }}" class="btn btn-pill font-bold">Seleccionar</a>
						</div>
					</div>
				@endforeach
			</div>
			@else
				<div class="text-center py-10">Ve a tu perfil para ver tus beneficios disponibles.</div>
			@endif
		</div>
		@endif
		<div class="my-10 text-center w-full sm:max-w-md mx-auto">
			<a href="{{ route('registro', ['cliente' => $cliente->id]) }}" class="btn btn-pill font-bold">Ir a mi perfil</a>
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
			// if session status show swal
			@if (session('status'))
				Swal.fire({
					title: "¡Éxito!",
					text: "{{ session('status') }}",
					icon: "success",
					button: "Aceptar",
				});
			@endif
			@if (session('error'))
				Swal.fire({
					title: "¡Error!",
					text: "{{ session('error') }}",
					icon: "error",
					button: "Aceptar",
				});
			@endif
		});
	</script>
	@include('componentes.estilos')
</body>

</html>
