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
	<main class="px-5 pb-20 w-full max-w-md mx-auto">
		@if ($cliente->id === NULL)
			<a href="{{ route('home') }}"><x-application-logo class="w-full h-auto max-w-xs fill-current text-gray-500 mt-5" /></a>
		@else
			<div class="flex justify-center w-full mt-5">
				<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs fill-current text-gray-500"></a>
			</div>
			<h1 class="text-center font-extrabold text-3xl mt-3 w-full">Login</h1>
			@if($cliente->registro_img !== NULL)
				<div class="mt-3 w-full">
					<img src="{{ asset('storage/'.$cliente->registro_img) }}" class="rounded-2xl shadow object-cover w-full h-auto border border-secondary">
				</div>
			@endif
		@endif
		@if($cliente->btn_registro_en_login)
		<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg back-alternativo contenedor-eres-nuevo esq-redondas">
			<div class="color-text-alternativo">¿ERES NUEVO POR AQUÍ?</div>
			<a href="{{ route('register', ['cliente' => $cliente->id]) }}">
				<x-button type="button" class="ml-3 btn-pill">
				Registrate
				</x-button>
			</a>
		</div>
		@endif
		<!-- Session Status -->
		<x-auth-session-status class="mb-4 mt-10" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4 mt-10" :errors="$errors" />

		<form method="POST" action="{{ route('login', ['cliente' => $cliente->id]) }}" class="mt-10">
			@csrf
			<!-- Email Address -->
			<div>
				<x-label for="email" :value="__('Email')" />
				<x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)" required
					autofocus />
			</div>

			<!-- Password -->
			<div class="mt-4">
				<x-label for="password" :value="__('Password')" />
				<x-input id="password" class="block mt-1 w-full" type="password" name="password" required
					autocomplete="current-password" />
			</div>

			<!-- Remember Me -->
			<div class="block mt-4" style="display:none;">
				<label for="remember_me" class="inline-flex items-center">
					<input id="remember_me" type="checkbox"
						class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
						name="remember" checked>
					<span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
				</label>
			</div>

			<div class="flex items-center justify-end mt-4">
				@if (Route::has('password.request'))
				<a class="underline text-sm color" href="{{ route('password.request', ['cliente' => $cliente->id]) }}">
					{{ __('Forgot your password?') }}
				</a>
				@endif

				<x-button class="ml-3 btn-pill">
					{{ __('Log in') }}
				</x-button>
				<div style="clear"></div>
			</div>
		</form>
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
			@if ($groupExists !== NULL && $groupExists === 'yes')
				Swal.fire({
					html: `
					@if ($grupo->logo !== NULL)
					<div class="text-center color2 font-bold mb-5">
						<img src="{{ asset('storage/'.$grupo->logo) }}" class="img-general inline-block object-cover w-auto h-15">
					</div>
					@endif
						<div class="text-center color2 font-bold">
							Tu correo:<br>{{ $email }}
						</div>
						<div class="text-center color2 px-16">
							ya se ha registrado anteriormente pues forma parte de las dinámicas de <span class="font-bold">{{ $grupo->nombre }}</span>.
						</div>
						@if ($grupo->miembros->count() > 0)
							<div class="grid grid-cols-4 items-center justify-center gap-3 mt-5">
								@foreach ($grupo->miembros as $miembro)
								<div class="text-center">
									<img src="{{ asset('storage/'.$miembro->cliente->logo) }}" class="img-general inline-block object-cover w-auto h-7">
								</div>
								@endforeach
							</div>
						@endif
						<div class="text-center color2 px-16 mt-5">
							<span class="font-bold color">Ingresa con tu correo sin necesidad de registrarte nuevamente</span> y
goza de los beneficios que Grupo Pasta
Tiene para ti
						</div>
					`,
					icon: null,
					showCloseButton: false,
					showCancelButton: false,
					confirmButtonText: 'INGRESAR',
					cancelButtonText: '{{ __('arcaddy.cancel') }}'
				}).then(async (result) => {
					if (result.isConfirmed) {
						uploadImage(0);
					}
				});
			@endif
		});
	</script>
	@include('componentes.estilos')
</body>

</html>
