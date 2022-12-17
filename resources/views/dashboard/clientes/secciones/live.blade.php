<div id="live" class="bg-white p-3 mt-3 section-box">
	<input type="hidden" name="secciones[]" value="live">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[live]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'live')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'live')->first()->titulo : 'Live Link' }}">
		</div>
		<div class="ml-auto">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="live-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'live')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="live-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'live')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="mt-5">
		<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="facebook_live">
			Link de youtube:
		</label>
		<input class="input-underline" name="facebook_live" id="facebook_live" value="{{ ($cliente->id !== NULL) ? $cliente->facebook_live : old('facebook_live') }}"
				type="url">
		</label>
	</div>
</div>
<!-- /live -->
