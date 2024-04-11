<div id="galeriamarcos" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="galeriamarcos">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[galeriamarcos]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->titulo : 'Galería' }}">
		</div>
		<div class="ml-auto">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="galeriamarcos-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="galeriamarcos-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div id="galeriamarcos-container" class="container-draggable mt-5 section-box">

	</div>
</div>
<!-- /galeriamarcos -->
