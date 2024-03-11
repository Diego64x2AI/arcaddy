<div class="flex flex-col gap-3">
	@if($pregunta->archivo !== NULL)
	<div>
		<img src="{{ asset('storage/'.$pregunta->archivo) }}" alt="{{ $pregunta->pregunta }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
	</div>
	@endif
	<div>
		<input id="steps-range-{{ $pregunta->id }}" type="range" min="0" max="10" value="5" step="1" data-respuesta="{{ $pregunta->respuestas->where('tipo', 'high')->first()?->id }}" class="range-slider">
	</div>
	<dib class="grid grid-cols-2 items-center gap-1 mt-3 font-semibold">
		<div class="text-start">
			{{ $pregunta->respuestas->where('tipo', 'low')->first()?->respuesta }}
		</div>
		<div class="text-end">
			{{ $pregunta->respuestas->where('tipo', 'high')->first()?->respuesta }}
		</div>
	</dib>
</div>
