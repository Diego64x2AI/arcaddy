<x-guest-layout :classes="'degradado'">
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
		<div class="flex">
			@auth
				@role('admin')
				<a href="{{ route('dashboard') }}" class="text-base text-white mr-4">Dashboard</a>
				@endrole
				<!-- Authentication -->
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<a :href="route('logout')" class="text-base text-white" onclick="event.preventDefault(); this.closest('form').submit();">
						{{ __('Log Out') }}
					</a>
				</form>
			@else
				<a href="{{ route('login') }}" class="text-base text-white">Log in</a>
			@endauth
		</div>
	</div>
</x-guest-layout>
