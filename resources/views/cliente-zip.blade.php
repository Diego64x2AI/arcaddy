@php
$classes = $cliente->id === NULL ? 'degradado pb-20' : 'bg-gray-100 pb-20';
@endphp
<x-guest-layout :classes="$classes">
	<x-auth-card>
		<x-slot name="logo">
			<div class="flex justify-center w-full sm:max-w-md mt-5">
				<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-10 fill-current text-gray-500"></a>
			</div>
			<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">Acceso restringuido</h1>
		</x-slot>
		{{--  <iframe src="https://drive.google.com/file/d/13gjNCbpJVPrsNMcTS2KBXmZa0Z0jOSKS/preview" width="640" height="480" allow="autoplay"></iframe>--}}
		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<p class="text-center">Para acceder a este arcaddy debes introducir tu código postal.</p>

		<form method="POST" action="{{ route('zipcode', ['cliente' => $cliente->id]) }}">
			@csrf
			<div class="mt-4 text-center">
				<x-label for="zip" value="Código postal" class="font-bold text-2xl mb-4" />
				<x-input class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full text-center" maxlength="5" type="text" name="zip" required />
			</div>

			<div class="flex items-center justify-center mt-4">
				<x-button class="ml-3 btn-pill">
					{{ __('Log in') }}
				</x-button>
			</div>
		</form>
	</x-auth-card>
	<div class="h-10"></div>
</x-guest-layout>
<style>
	.btn-pill {
		background-color: {{ $cliente->color }} !important;
	}

	.color {
		color: {{ $cliente->color }} !important;
	}

	.bg-client {
		background-color: {{ $cliente->color }} !important;
	}
</style>
