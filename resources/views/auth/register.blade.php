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
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
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
	<main class="px-5 pb-20 w-full max-w-md mx-auto">
		@if ($cliente->id === NULL)
			<a href="{{ route('home') }}"><x-application-logo class="w-full h-auto max-w-xs fill-current text-gray-500 mt-5" /></a>
		@else
			<div class="flex justify-center w-full mt-5">
				<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs fill-current text-gray-500"></a>
			</div>
			<h1 class="text-center font-extrabold text-3xl mt-3 w-full">Registro</h1>
			@if($cliente->registro_img !== NULL)
				<div class="mt-3 w-full">
					<img src="{{ asset('storage/'.$cliente->registro_img) }}" class="rounded-2xl shadow object-cover w-full h-auto border border-secondary">
				</div>
			@endif
			@if($cliente->registro_descripcion !== NULL)
				<div class="mt-5 font-bold text-center w-full">
					{{ $cliente->registro_descripcion }}
				</div>
			@endif
		@endif
		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('register_store') }}" class="mt-10">
			@csrf
			<input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
			<input type="hidden" name="sinlogin" value="{{ $sinlogin }}">
			<!-- Name -->
			<div>
				<x-label for="name" :value="__('Name')" />
				<x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
			</div>
			<!-- Email Address -->
			<div class="mt-4">
				<x-label for="email" :value="__('Email')" />
				<x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
			</div>
			<!-- Password -->
			<div class="mt-4">
				<x-label for="password" :value="__('Password')" />
				<x-input id="password" class="block mt-1 w-full" type="password" name="password" required
					autocomplete="new-password" />
			</div>
			<!-- Confirm Password -->
			<div class="mt-4">
				<x-label for="password_confirmation" :value="__('Confirm Password')" />
				<x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
					required />
			</div>
			@foreach ($cliente->campos()->where('activo', 1)->get() as $campo)
				<div class="mt-4">
					<x-label for="campos[{{ $campo->campo_id }}]" :value="$campo->nombre" />
					@if($campo->campo_id !== 4)
					<x-input class="block mt-1 w-full" type="text" name="campos[{{ $campo->campo_id }}]" required />
					@else
					    <input type="date" id="nacimiento" name="nacimiento" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1" required>
					@endif
				</div>
			@endforeach
			@if ($cliente->registro_sucursal)
			<div class="mt-4">
			<x-label for="sucursal_id" :value="__('Sucursal')" />
			<select name="sucursal_id" id="sucursal_id" class="block mt-1 w-full !border-gray-300" required>
				<option value="">Selecciona una sucursal</option>
				@foreach ($cliente->sucursales as $sucursal)
				<option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
				@endforeach
			</select>
			</div>
			@endif
			<div class="flex items-center justify-end mt-4">
				<a class="underline text-sm color" href="{{ route('login', ['cliente' => $cliente->id]) }}">
					{{ __('Already registered?') }}
				</a>
				<x-button class="ml-4 btn-pill">
					{{ __('Register') }}
				</x-button>
			</div>
		</form>
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
