<div id="descriptivos" class="bg-white p-3 mt-3 section-box">
	<input type="hidden" name="secciones[]" value="descriptivos">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-1">Descriptivos</div>
		<div class="ml-auto"><span class="hidden md:inline-block">Activar / Desactivar </span><input type="checkbox" name="descriptivos-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'descriptivos')->first()->activa) checked @endif></div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="flex flex-wrap items-center -mx-3 mt-5">
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="titulo">
				Título
			</label>
			<input class="input-underline" name="titulo" id="titulo" value="{{ ($cliente->id !== NULL) ? $cliente->titulo : old('titulo') }}"
				type="text">
		</div>
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="subtitulo">
				Subtítulo
			</label>
			<input class="input-underline" name="subtitulo" id="subtitulo" value="{{ ($cliente->id !== NULL) ? $cliente->subtitulo : old('subtitulo') }}"
				type="text">
		</div>
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="fecha">
				Fecha
			</label>
			<input class="input-underline" name="fecha" id="fecha" value="{{ ($cliente->id !== NULL) ? $cliente->fecha : old('fecha') }}"
				type="text">
		</div>
	</div>
	<div class="mt-5">
		<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="descripcion">
			Descripción
		</label>
		<textarea class="input-border alx-editor" name="descripcion" id="descripcion"
			rows="5">{{ ($cliente->id !== NULL) ? $cliente->descripcion : old('descripcion') }}</textarea>
		</label>
	</div>
</div>
<!-- /descriptivos -->
