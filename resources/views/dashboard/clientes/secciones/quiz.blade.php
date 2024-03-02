<div id="quiz" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="quiz">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'quiz')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'quiz')->first()->titulo : 'Quiz' }}
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[quiz]" type="hidden"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'quiz')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'quiz')->first()->titulo : 'Quiz' }}">
		</div>
		<div class="ml-auto hidden">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="quiz-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'quiz')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="quiz-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'quiz')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="py-20 text-center font-semibold text-2xl">
		@if ($cliente->quiz->where('activa', true)->first() !== NULL)
			Quiz activo: {{ $cliente->quiz->where('activa', true)->first()->nombre }}
		@else
			No se encuentra ningun quiz activo
		@endif
	</div>
</div>
<!-- /quiz -->
