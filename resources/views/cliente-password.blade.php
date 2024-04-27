@php
$classes = $cliente->id === NULL ? 'degradado pb-20' : 'bg-gray-100 pb-20';
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
				@if($cliente->registro_img !== NULL)
					<div class="mt-3 w-full sm:max-w-md">
						<img src="{{ asset('storage/'.$cliente->registro_img) }}" style="border-radius:50px" class="img-general rounded-lg shadow object-cover w-100 border border-secondary">
					</div>
				@endif
			@endif
			<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">{{ $cliente->password_titulo }}</h1>
		</x-slot>
		{{--  <iframe src="https://drive.google.com/file/d/13gjNCbpJVPrsNMcTS2KBXmZa0Z0jOSKS/preview" width="640" height="480" allow="autoplay"></iframe>--}}
		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<p class="text-center">{{ $cliente->password_descripcion }}</p>

		<form method="POST" action="{{ route('acceso', ['cliente' => $cliente->id]) }}">
			@csrf
			<!-- Password -->
			<div class="mt-4 text-center">
				<x-label for="password" :value="__('Password')" class="font-bold text-2xl mb-4" />
				<x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
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
@if ($cliente->slug === 'estafeta')
	<div class="fixed right-0 bottom-0 mr-5 mb-5">
		<div class="bg-[#25D366] py-3 px-5 text-white rounded-full text-xl">
			<a href="https://wa.me/5213326293396?" target="_blank">{{ __('arcaddy.help') }} <i class="fa fa-whatsapp"></i></a>
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
