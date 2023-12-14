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
				<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">Login</h1>
				@if($cliente->registro_img !== NULL)
					<div class="mt-3 w-full sm:max-w-md">
						<img src="{{ asset('storage/'.$cliente->registro_img) }}" style="border-radius:50px" class="img-general rounded-lg shadow object-cover w-100 border border-secondary">
					</div>
				@endif
			@endif
		</x-slot>



		@if($cliente->btn_registro_en_login)	
	<div class="flex flex-col sm:justify-center items-center pt-0 px-4 sm:pt-0">
	<div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md sm:rounded-lg back-alternativo contenedor-eres-nuevo">
		<div class="mt-4">
			<div class="color-text-alternativo">¿ERES NUEVO POR AQUÍ?</div>
			<a href="{{ route('register', ['cliente' => $cliente->id]) }}">
				<x-button type="button" class="ml-3 btn-pill">
				Registrate
				</x-button>
			</a>
		</div>
	</div>
	</div>
	@endif


		
		{{--  <iframe src="https://drive.google.com/file/d/13gjNCbpJVPrsNMcTS2KBXmZa0Z0jOSKS/preview" width="640" height="480" allow="autoplay"></iframe>--}}
		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('login', ['cliente' => $cliente->id]) }}">
			@csrf

			<div class="titulo-alternativo">
				¿YA ERES USUARIO REGISTRADO?
			</div>

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
				<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request', ['cliente' => $cliente->id]) }}">
					{{ __('Forgot your password?') }}
				</a>
				@endif

				<x-button class="ml-3 btn-pill">
					{{ __('Log in') }}
				</x-button>
				<div style="clear"></div>
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
	.clear{
		clear: both;
	}
	.f-right{
		float: right;
	}
	.color-text-alternativo{
		font-weight: 700;
		margin-bottom: 12px;
		color: {{ $cliente->color_bg }};
	}
	.titulo-alternativo{
		font-weight: 700;
		margin-bottom: 12px;
		text-align: center;
	}
	.back-alternativo{
		 
		background-color: {{ $cliente->color_base }};

	}
	.contenedor-eres-nuevo{
		text-align: center;
		margin: 20px auto;
	}
</style>
