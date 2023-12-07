@extends('my-app-client.layout')

@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-usuarios">
			Registro de <br>nuevo usuario
		</div>
	</div>
</div>

<div style="position: relative;">
<div class="alx-section">
<div class="container alx-mobile">
		<br>		
		<div class="flex justify-center w-full sm:max-w-md mt-5">
			<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" style="width: 100%;"></a>
		</div>
		<br><br>

		<style>
			#alx-form-registro input{
				width: 100%;
				height: 40px;
				line-height: 40px;
				padding: 10px 10px;
			}
		</style>

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('recibe-registro-interno-de-usuario', $cliente->id) }}" id="alx-form-registro">
			@csrf
			<input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
			<!-- Name -->
			<div>
				<div class="alx-w-bold">Nombre</div>
				
				<x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
			</div>
			<br>

			<!-- Email Address -->
			<div class="mt-4">
				<div class="alx-w-bold">Email</div>
				<x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
			</div>
			<br>

			<!-- Password -->
			<div class="mt-4">
				<div class="alx-w-bold">Contraseña</div>
				<x-input id="password" class="block mt-1 w-full" type="password" name="password" required
					autocomplete="new-password" />
			</div>
			<br>

			<!-- Confirm Password -->
			<div class="mt-4">
				<x-label class="alx-w-bold" for="password_confirmation" :value="__('Confirm Password')" /><br>
				<x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
					required />
			</div>
			<br>

			@foreach ($cliente->campos()->where('activo', 1)->get() as $campo)
				
				@if($campo->campo_id != 4) 
				<div class="mt-4">
					<x-label class="alx-w-bold" for="campos[{{ $campo->campo_id }}]" :value="$campo->nombre" /><br>
					<x-input class="block mt-1 w-full" type="text" name="campos[{{ $campo->campo_id }}]" required />
				</div>
					@else
					<div class="mt-4">
					    <x-label class="alx-w-bold" for="campos[{{ $campo->campo_id }}]" :value="$campo->nombre" /><br>
					    <input type="date" id="nacimiento" name="nacimiento" class="block" style="width: initial;" required>
						</div>
					@endif
				
				
				
				
				<br>
			@endforeach
			<div class="flex items-center justify-end mt-4 text-center">
				<x-button class="alx-btn" style="border: 0px; margin: 0px auto;">
					Registrar
				</x-button>
			</div>
			<br>
			<div class="flex items-center justify-end mt-4 text-center">
				<a href="{{route('my-app-client.reporte-base-usuarios')}}" class="alx-btn" style="border: 0px; margin: 0px auto;">Regresar al listado</a>
			</div>
		</form>
		<br><br>

</div>
</div>
</div>

@endsection
