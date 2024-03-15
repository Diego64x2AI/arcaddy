<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Editar Usuario
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('usuarios.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>
	<form method="POST" autocomplete="off" action="{{ route('usuarios.update', ['cliente' => $cliente->id, 'user' => $user->id]) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="py-5">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100 py-10">
				@if ($errors->any())
				<div class="py-5">
					<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
				</div>
				@endif
				@if (session('success'))
				<div class="py-5">
					<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
				</div>
				@endif
				<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-8">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="name">
							Nombre
						</label>
						<input type="text" id="name" name="name" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('name', $user->name) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="email">
							Email
						</label>
						<input type="email" id="email" name="email" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('email', $user->email) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="password">
							Contraseña <span class="text-xs">(si deseas cambiarla)</span>
						</label>
						<input type="password" id="password" name="password" autocomplete="new-password" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('password') }}">
					</div>
					@foreach ($cliente->campos()->where('activo', 1)->get() as $campo)
						<div>
							<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="campos[{{ $campo->campo_id }}]">
								{{ $campo->nombre }}
							</label>
							@if($campo->campo_id !== 4)
							<input type="text" id="campos[{{ $campo->campo_id }}]" name="campos[{{ $campo->campo_id }}]" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('campos.'.$campo->campo_id, $user->campos()->where('campo_id', $campo->campo_id)->first()?->valor) }}" required>
							@else
							<input type="date" id="nacimiento" name="nacimiento" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('nacimiento', $user->nacimiento) }}" required>
							@endif
						</div>
					@endforeach
					<div class="lg:col-span-2">
						<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</x-app-layout>
<script>
	document.addEventListener('DOMContentLoaded', function load() {
		if (!window.jQuery) return setTimeout(load, 50);

	});
</script>
