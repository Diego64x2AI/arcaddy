<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Experiencias GEO / Rally
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.rally.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<form method="POST" action="{{route('cliente.rally.store', ['cliente' => $cliente->id])}}" enctype="multipart/form-data">
		@csrf
		<div class="py-5">
			<div class="max-w-7xl mx-auto px-4 lg:px-8 bg-gray-100 py-10">
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
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="titulo">
							Título
						</label>
						<input type="text" name="titulo" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('titulo') }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="imagen">
							Imagen
						</label>
						<div id="preview-container"></div>
						<input type="file" id="imagen" name="imagen" multiple accept="image/*" required>
					</div>
					<div class="font-bold">
						<label for="geo_oculto" class="flex items-center cursor-pointer">
							<div class="relative mr-5">
								<input id="geo_oculto" name="geo_oculto" type="checkbox" class="sr-only" checked />
								<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
								<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
							</div>
							Geo Oculto
						</label>
					</div>
					<div class="font-bold">
						<label for="activo" class="flex items-center cursor-pointer">
							<div class="relative mr-5">
								<input id="activo" name="activo" type="checkbox" class="sr-only" checked />
								<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
								<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
							</div>
							Activo
						</label>
					</div>
					<div class="lg:col-span-2">
						<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
					</div>
				</div>

			</div>
		</div>
	</form>
	@section('js')
	<script>
		window.addEventListener('load', function() {
		});
	</script>
	@endsection
</x-app-layout>
