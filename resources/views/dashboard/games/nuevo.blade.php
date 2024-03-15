<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					{{$juegoCategoria->nombre}}
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('games.index') }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>
	<form id="image-form" method="POST" action="{{route('games.store')}}" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="categoria_id" value="{{$juegoCategoria->id}}">
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
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Cliente
						</label>
						<select name="cliente_id" class="shadow appearance-none border-0 w-full !py-2 !px-3 text-gray-700 input-underline" required>
							<option value="">Cliente</option>
							@foreach($clientes as $cliente)
							<option value="{{$cliente->id}}" @if(intval(old('cliente_id')) === $cliente->id) selected @endif>{{$cliente->cliente}}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Activo
						</label>
						<select name="estatus" class="shadow appearance-none border-0 w-full !py-2 !px-3 text-gray-700 input-underline" required>
							<option value="1" @if(intval(old('estatus', 1)) === 1) selected @endif>Si</option>
							<option value="0" @if(intval(old('estatus', 1)) === 0) selected @endif>No</option>
						</select>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Nombre
						</label>
						<input type="text" name="nombre" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('nombre') }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Descripción
						</label>
						<input type="text" name="descripcion" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('descripcion') }}" required>
					</div>
					@if ($juegoCategoria->slug === 'shuffle-puzzle')
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="dificultad">
							Dificultad
						</label>
						<select id="dificultad" name="dificultad" class="shadow appearance-none border-0 w-full !py-2 !px-3 text-gray-700 input-underline" required>
							<option value="3x3" @if(old('dificultad', '4x4') === '3x3') selected @endif>3x3</option>
							<option value="4x4" @if(old('dificultad', '4x4') === '4x4') selected @endif>4x4</option>
							<option value="5x5" @if(old('dificultad', '4x4') === '5x5') selected @endif>5x5</option>
						</select>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="imagen">
							Imagen
						</label>
						<div id="preview-container"></div>
						<input type="file" id="image-input" name="images[]" multiple accept="image/*" required>
					</div>
					@endif
					@if ($juegoCategoria->slug === 'memory')
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Cartas
						</label>
						<div id="preview-container"></div>
						<input type="file" id="image-input" name="images[]" multiple accept="image/*">
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Carta vista back
						</label>
						<div id="preview-container-imageback"></div>
						<input type="file" id="imageback" name="imageback[]" multiple accept="image/*">
					</div>
					@endif
					<div class="lg:col-span-2">
						<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</x-app-layout>
<style>
	#preview-container {
		display: flex;
		flex-wrap: wrap;
	}

	#preview-container img {
		max-width: 100px;
		max-height: 100px;
		margin: 5px;
	}

	#preview-container-imageback {
		display: flex;
		flex-wrap: wrap;
	}

	#preview-container-imageback img {
		max-width: 100px;
		max-height: 100px;
		margin: 5px;
	}
</style>
<script>
	document.addEventListener('DOMContentLoaded', function load() {
		if (!window.jQuery) return setTimeout(load, 50);
		$('#image-input').on('change', function () {
			var files = this.files;
			var previewContainer = $('#preview-container');
			previewContainer.empty();
			for (var i = 0; i < files.length; i++) {
				var reader = new FileReader();
				reader.onload = function (e) {
					previewContainer.append('<img src="' + e.target.result + '">');
				};
				reader.readAsDataURL(files[i]);
			}
		});
		@if ($juegoCategoria->slug === 'memory')
		$('#imageback').on('change', function () {
			var files = this.files;
			var previewContainer = $('#preview-container-imageback');
			previewContainer.empty();
			for (var i = 0; i < files.length; i++) {
				var reader = new FileReader();
				reader.onload = function (e) {
					previewContainer.append('<img src="' + e.target.result + '">');
				};
				reader.readAsDataURL(files[i]);
			}
		});
		@endif
});
</script>
