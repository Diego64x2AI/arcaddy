@php
$classes = $cliente->id === NULL ? 'degradado pb-20' : 'bg-gray-100 pb-20';
@endphp
<x-guest-layout :classes="$classes">
	<x-auth-card>
		<x-slot name="logo">
				@if ($cliente->id === NULL)
					<a href="{{ route('home') }}"><x-application-logo class="w-auto h-20 fill-current text-gray-500 mt-5" /></a>
				@else
					<div class="flex justify-center w-full sm:max-w-md mt-5">
						<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-10 fill-current text-gray-500"></a>
					</div>
					<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">Registro</h1>
					@if($cliente->registro_img !== NULL)
						<div class="mt-3 w-full sm:max-w-md">
							<img src="{{ asset('storage/'.$cliente->registro_img) }}" style="border-radius:50px" class="img-general rounded-lg shadow object-cover w-100 border border-secondary">
						</div>
					@endif
					@if($cliente->registro_descripcion !== NULL)
						<div class="mt-5 font-bold text-center w-full sm:max-w-md">
							{{ $cliente->registro_descripcion }}
						</div>
					@endif
				@endif
		</x-slot>
		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('register_store') }}">
			@csrf
			<input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
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
					<x-input class="block mt-1 w-full" type="text" name="campos[{{ $campo->campo_id }}]" required />
				</div>
			@endforeach
			<div class="flex items-center justify-end mt-4">
				<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login', ['cliente' => $cliente->id]) }}">
					{{ __('Already registered?') }}
				</a>
				<x-button class="ml-4 btn-pill">
					{{ __('Register') }}
				</x-button>
			</div>
		</form>
	</x-auth-card>
	<div class="h-10"></div>
</x-guest-layout>
@if ($cliente->slug === 'estafeta')
	<div class="fixed right-0 bottom-0 mr-5 mb-5">
		<div class="bg-[#25D366] py-3 px-5 text-white rounded-full text-xl">
			<a href="https://wa.me/5213326293396?" target="_blank">Ayuda <i class="fa fa-whatsapp"></i></a>
		</div>
	</div>
	@endif
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
