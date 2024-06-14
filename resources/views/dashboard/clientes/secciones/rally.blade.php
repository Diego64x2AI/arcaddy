<div id="rally" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="rally">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'rally')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'rally')->first()->titulo : 'Quiz' }}
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[rally]" type="hidden"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'rally')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'rally')->first()->titulo : 'Quiz' }}">
		</div>
		<div class="ml-auto hidden">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="rally-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'rally')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="rally-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'rally')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="py-20 text-center font-semibold text-2xl">
		@if ($cliente->rallys()->where('activo', true)->orderBy('id', 'desc')->first() !== NULL)
			@php
				$rally = $cliente->rallys()->where('activo', true)->orderBy('id', 'desc')->first();
			@endphp
			<div>
				Rally activo: {{ $rally->titulo }}
			</div>
			<div class="text-center mt-5">
				<a href="{{ route('cliente.rally.markers', ['cliente' => $cliente->id, 'rally' => $rally->id]) }}" class="btn-pill">Administrar markers</a>
			</div>
		@else
			No se encuentra ningun rally activo
		@endif
	</div>
</div>
<!-- /quiz -->
