@php
$classes = $cliente->id === NULL ? 'degradado' : 'bg-gray-100';
@endphp
<x-guest-layout :classes="$classes">
	<x-auth-card>
		<x-slot name="logo">
			@if ($cliente->id === NULL)
				<a href="{{ route('home') }}"><x-application-logo class="w-auto h-20 fill-current text-gray-500 w-full sm:max-w-md" /></a>
			@else
				<div class="flex justify-center w-full sm:max-w-md mt-5">
					<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-10 fill-current text-gray-500"></a>
				</div>
				<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">Login</h1>
				@if($cliente->registro_img !== NULL)
					<div class="mt-3 w-full sm:max-w-md">
						<img src="{{ asset('storage/'.$cliente->registro_img) }}" style="border-radius:50px" class="img-general rounded-lg shadow object-cover w-100 border border-secondary">
					</div>
				@endif
			@endif
		</x-slot>

		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('login') }}">
			@csrf

			<!-- Email Address -->
			<div>
				<x-label for="email" :value="__('Email')" />

				<x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
					autofocus />
			</div>

			<!-- Password -->
			<div class="mt-4">
				<x-label for="password" :value="__('Password')" />

				<x-input id="password" class="block mt-1 w-full" type="password" name="password" required
					autocomplete="current-password" />
			</div>

			<!-- Remember Me -->
			<div class="block mt-4">
				<label for="remember_me" class="inline-flex items-center">
					<input id="remember_me" type="checkbox"
						class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
						name="remember">
					<span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
				</label>
			</div>

			<div class="flex items-center justify-end mt-4">
				@if (Route::has('password.request'))
				<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
					{{ __('Forgot your password?') }}
				</a>
				@endif

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
