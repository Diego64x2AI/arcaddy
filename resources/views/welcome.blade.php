<x-guest-layout>
	<div>
		<img src="{{ asset('images/banner-header.jpg') }}" class="h-auto w-full" alt="AR|CADDY - Reality is an illusion">
	</div>
	<div>
		<img src="{{ asset('images/banner-arcade.jpg') }}" class="h-auto w-full" alt="AR|CADDY - AUGMENTED REALITY">
	</div>
	<div>
		<img src="{{ asset('images/banner-contenedor.jpg') }}" class="h-auto w-full" alt="AR|CADDY - EMPAQUE MULTIVERSAL">
	</div>
	<div>
		<img src="{{ asset('images/banner-personalizacion.jpg') }}" class="h-auto w-full" alt="AR|CADDY - PERSONALIZACIÓN FÍSICA Y DIGITAL DE TU MARCA">
	</div>
	<div>
		<img src="{{ asset('images/banner-compra.jpg') }}" class="h-auto w-full" alt="AR|CADDY - COMPRA ONLINE">
	</div>
	<div>
		<img src="{{ asset('images/banner-contacto.jpg') }}" class="h-auto w-full" alt="AR|CADDY - CONTÁCTANOS">
	</div>
	<div class="fixed top-0 right-0 px-6 py-4">
		@auth
		<a href="{{ url('/dashboard') }}" class="text-base text-white">Dashboard</a>
		@else
		<a href="{{ route('login') }}" class="text-base text-white">Log in</a>

		@if (Route::has('register'))
		<a href="{{ route('register') }}" class="ml-4 text-base text-white">Register</a>
		@endif
		@endauth
	</div>
</x-guest-layout>
