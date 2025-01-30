<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<!-- Font Awesome Icons -->
	<link href="{{ asset('fontawesome-free-6.7.2-web/css/all.min.css') }}" rel="stylesheet">
	<script src="{{ asset('fontawesome-free-6.7.2-web/js/all.min.js') }}"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://js.stripe.com/v3/"></script>
</head>

<body class="font-sans antialiased">
	<main class="max-w-7xl mx-auto pt-10 px-5">
		<div class="col-span-1 lg:col-span-6">
			<h4 class="text-3xl text-gray-700 mb-5">Gracias por tu pago</h4>
			<div class="p-5 rounded-md shadow-xl border bg-white">
				Estamos revisando tu pedido y lo enviaremos a la brevedad posible, muchas gracias por tu compra.
			</div>
		</div>
		</div>
	</main>
	<footer class="mt-5 fixed left-0 bottom-0 w-full">
		<div class="degradado px-5 py-6 mt-5 text-white">
			<div class="flex flex-row items-center justify-between">
				<div>
					<img src="{{ asset('images/logo@2x.png') }}" class="block h-6 w-auto fill-current text-gray-600">
				</div>
				<div class="text-lg">Reality is an illusion...</div>
			</div>
		</div>
	</footer>
</body>

</html>
