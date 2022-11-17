@php
$classes = $cliente->id === NULL ? 'degradado pb-20 min-h-screen' : 'bg-gray-100 pb-20 min-h-screen';
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
					<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">Recuperar contraseña</h1>
					@if($cliente->registro_img !== NULL)
						<div class="mt-3 w-full sm:max-w-md">
							<img src="{{ asset('storage/'.$cliente->registro_img) }}" style="border-radius:50px" class="img-general rounded-lg shadow object-cover w-100 border border-secondary">
						</div>
					@endif
				@endif
			</x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email', ['cliente' => $cliente->id]) }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
