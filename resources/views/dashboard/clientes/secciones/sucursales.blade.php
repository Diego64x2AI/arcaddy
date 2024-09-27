<div id="sucursales" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="sucursales">
	<div class="flex flex-row flex-wrap items-center justify-evenly font-bold gap-3 md:gap-5">
		<div class="text-xl lg:text-3xl basis-full lg:basis-0 lg:grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[sucursales]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'sucursales')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'sucursales')->first()->titulo : 'Sucursales' }}">
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="sucursales-activo2">Título</label></div>
			<div><input type="checkbox" id="sucursales-activo2" name="sucursales-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'sucursales')->first()->mostrar_titulo) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="sucursales-activo">Activo</label></div>
			<div><input type="checkbox" id="sucursales-activo" name="sucursales-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'sucursales')->first()->activa) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="sucursales_mapa">Mapa</label></div>
			<div><input type="checkbox" id="sucursales_mapa" name="sucursales_mapa" value="on" @if($cliente->id !== NULL && $cliente->sucursales_mapa) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center cursor-move handler2">
			<div class="text-sm lg:text-base">Mover</div>
			<div><i class="fas fa-ellipsis-v"></i></div>
		</div>
	</div>
	<div id="sucursales-container" class="container-draggable mt-5 section-box">

	</div>
	<div class="text-center mt-5">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
			<div class="text-center">
				<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
					PIN para el mapa
				</label>
				<img src="{{ ($cliente->id !== NULL && $cliente->sucursales_pin !== NULL) ? asset('storage/'.$cliente->sucursales_pin) : asset('images/sucursal-pin.png') }}"
										class="img-general object-cover w-100 border border-secondary inline-block">
				<div class="text-center mt-3">
					<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
					<div class="examinar-size text-xs mt-2 text-gray-400">(36 x 36)</div>
				</div>
				<input name="sucursales_pin" id="sucursales_pin" type="file" class="file-general" accept="image/*" style="display: none">
			</div>
			<div class="text-center">
				<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
					Cantidad de sucursales cercanas:
				</label>
				<input class="shadow appearance-none border-0 w-full py-2 text-center px-3 text-gray-700" name="sucursales_max" id="sucursales_max"
									type="number" min="0" value="{{ ($cliente->id !== NULL) ? $cliente->sucursales_max : old('sucursales_max') }}" placeholder="Ejemplo: 5" required>
			</div>
		</div>
		<a href="{{ route('cliente.sucursales.index', ['cliente' => $cliente->id]) }}" class="btn-pill">Administrar sucursales</a>
	</div>
</div>
<!-- /sucursales -->
