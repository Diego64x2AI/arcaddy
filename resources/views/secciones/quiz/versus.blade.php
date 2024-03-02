<div class="flex flex-col gap-3">
	<dib class="grid grid-cols-2 items-center gap-3 font-semibold">
		<div class="flex flex-row justify-center">
			<div class="mb-3 relative">
				<img src="{{ asset('storage/'.$pregunta->respuestas->where('tipo', 'versus')->first()?->archivo) }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
			</div>
		</div>
		<div class="flex flex-row justify-center">
			<div class="mb-3 relative">
				<img src="{{ asset('storage/'.$pregunta->respuestas->where('tipo', 'versus')->last()?->archivo) }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
			</div>
		</div>
		<div class="flex flex-row justify-center">
			{{ $pregunta->respuestas->where('tipo', 'versus')->first()?->respuesta }}
		</div>
		<div class="flex flex-row justify-center">
			{{ $pregunta->respuestas->where('tipo', 'versus')->last()?->respuesta }}
		</div>
		<div class="flex flex-row justify-center">
			<input type="radio" name="respuesta-versus" value="{{ $pregunta->respuestas->where('tipo', 'versus')->first()?->id }}">
		</div>
		<div class="flex flex-row justify-center">
			<input type="radio" name="respuesta-versus" value="{{ $pregunta->respuestas->where('tipo', 'versus')->last()?->id }}">
		</div>
	</dib>
</div>
