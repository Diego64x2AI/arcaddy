<div class="flex flex-col gap-3">
@foreach ($pregunta->respuestas as $respuesta)
	<div>
		<input type="checkbox" class="mr-2" id="respuesta-{{ $pregunta->id }}" name="respuesta-{{ $pregunta->id }}" data-otra="{{ ($respuesta->respuesta === 'Otra...') ? 1 : 0 }}" value="{{ $respuesta->id }}">
		@if ($respuesta->respuesta === 'Otra...')
		<label for="respuesta-{{ $respuesta->id }}"><input type="text" name="respuesta-{{ $pregunta->id }}-otra" placeholder="{{ str_replace("", __('arcaddy.other'), $respuesta->respuesta) }}" class="border py-2 text-sm border-gray-300 w-3/4 color"></label>
		@else
		<label for="respuesta-{{ $respuesta->id }}">{{ $respuesta->respuesta }}</label>
		@endif
	</div>
@endforeach
</div>
