<div id="galeriamarcos" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="galeriamarcos">
	<div class="flex flex-row flex-wrap items-center justify-evenly font-bold gap-3 md:gap-5">
		<div class="text-xl lg:text-3xl basis-full lg:basis-0 lg:grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[galeriamarcos]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->titulo : 'Galería' }}">
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="galeriamarcos-activo2">Título</label></div>
			<div><input type="checkbox" id="galeriamarcos-activo2" name="galeriamarcos-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->mostrar_titulo) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="galeriamarcos-activo">Activo</label></div>
			<div><input type="checkbox" id="galeriamarcos-activo" name="galeriamarcos-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->activa) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="galeriamarcos-login">Login</label></div>
			<div><input type="checkbox" id="galeriamarcos-login" name="galeriamarcos-login" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->login) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center cursor-move handler2">
			<div class="text-sm lg:text-base">Mover</div>
			<div><i class="fas fa-ellipsis-v"></i></div>
		</div>
	</div>
	<div id="galeriamarcos-container" class="container-draggable mt-5 section-box">

	</div>
	<div class="text-center mt-5">
		<a href="{{ route('cliente.galerias.index', ['cliente' => $cliente->id]) }}" class="btn-pill">Administrar imagenes</a>
	</div>
</div>
<!-- /galeriamarcos -->
