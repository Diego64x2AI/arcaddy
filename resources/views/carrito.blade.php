<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }} - Carrito de compras</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/6167140cfb.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://js.stripe.com/v3/"></script>
</head>

<body class="bg-gray-300">
	<div class="h-screen">
		<div class="py-12 px-5 md:px-0">
			<form action="{{ route('actualizar_carrito') }}" method="POST">
				@csrf
				<div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-lg md:max-w-5xl">
					@if ($errors->any())
					<div class="p-5">
						<div class="relative w-full text-sm p-3 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
					</div>
					@endif
					@if (session('success'))
					<div class="p-5">
						<div class="relative w-full text-sm p-3 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
					</div>
					@endif
					@if (Cart::isEmpty())
						<div class="p-10 text-center">Tu carrito de compras se encuentra vacio.</div>
					@else
					<div class="md:flex ">
						<div class="w-full p-4 px-5 py-5">
							<div class="md:grid md:grid-cols-3 gap-2 ">
								<div class="col-span-2">
									<div class="flex justify-between items-center mb-6 pb-6 border-b">
										<div>
											<h1 class="text-xl font-medium ">Carrito de compras</h1>
										</div>
										<div class="flex justify-center items-end">
											<a href="{{ route('cliente', ['slug' => $carrito->first()->attributes->slug]) }}">Seguir comprando</a>
										</div>
									</div>
									@php
									$total = 0;
									@endphp
									@foreach ($carrito as $item)
									@php
									$total += ($item->price * $item->quantity);
									@endphp
									<div class="flex justify-between items-center mt-6 pt-6">
										<div class="flex items-center">
											<img src="{{ asset('storage/'.$item->attributes->imagen) }}"
												class="rounded-full border shadow w-12 h-12">
											<div class="flex flex-col ml-2">
												<span class="md:text-md font-medium">{{ $item->name }} <a href="{{ route('agregar_eliminar', ['producto' => $item->id]) }}"
														class="ml-3 text-sm text-red-600"><i class="fa fa-trash"></i></a></span>
												{{--<span class="text-xs font-light text-gray-400">#41551</span>--}}
											</div>
										</div>
										<div class="flex justify-center items-center">
											<div class="pr-8 flex ">
												<input type="text" name="cantidad[{{ $item->id }}]"
													class="focus:outline-none bg-gray-100 border w-12 text-center rounded text-sm px-2 mx-2"
													value="{{ $item->quantity }}">
											</div>
											<div>
												<span class="text-xs font-medium">${{ number_format(($item->price * $item->quantity), 2) }}</span>
											</div>
											<div>
												<i class="fa fa-close text-xs font-medium"></i>
											</div>
										</div>
									</div>
									@endforeach
									<div class="flex justify-between items-center mt-6 pt-6 border-t">
										<div>
											<button type="submit" class="btn-pill bg-blue-500">Actualizar carrito</button>
										</div>
										<div class="flex justify-center items-end">
											<span class="text-sm font-medium text-gray-400 mr-1">Total:</span>
											<span class="text-lg font-bold text-gray-800 "> ${{ number_format($total, 2) }}</span>
										</div>
									</div>
								</div>
								<div class="p-5 bg-gray-800 rounded overflow-visible mt-10 md:mt-0">
            			<span class="text-xl font-medium text-gray-100 block pb-3">Completar pedido</span>
									@auth
										<p class="text-white text-sm">Hola {{ auth()->user()->name }} para proceder al pago da click en el siguiente enlace:</p>
										<a href="{{ route('pagar') }}" class="w-full uppercase text-center p-3 block bg-blue-500 rounded focus:outline-none text-white hover:bg-blue-600 mt-5">Pagar</a>
									@else
									<p class="text-white text-sm">Para completar tu pedido, necesitas iniciar sesión en tu cuenta o registrarte.</p>
            			<a href="{{ route('login', ['cliente' => $carrito->first()->attributes->cliente_id]) }}" class="w-full text-center p-3 block bg-blue-500 rounded focus:outline-none text-white hover:bg-blue-600 mt-5">Iniciar sesión</a>
									<a href="{{ route('register', ['cliente' => $carrito->first()->attributes->cliente_id]) }}" class="w-full text-center p-3 block bg-blue-500 rounded focus:outline-none text-white hover:bg-blue-600 mt-5">Registrarme</a>
									@endauth
            		</div>
							</div>
						</div>
					</div>
					@endif
				</div>
			</form>
		</div>
	</div>

	<footer class="mt-5">
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
