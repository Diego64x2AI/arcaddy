<div class="flex flex-col gap-3">
	<div>
		<img src="{{ asset('storage/'.$pregunta->archivo) }}" alt="{{ $pregunta->pregunta }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
	</div>
	<dib class="grid grid-cols-2 items-center gap-1 mt-3 font-semibold">
		@if($pregunta->iconos)
		<div class="flex flex-row justify-center">
			<a href="javascript:void(0);" data-respuesta="{{ $pregunta->respuestas->where('tipo', 'like')->first()?->id }}" class="rounded-full border-2 border-white like-click bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-3xl items-center p-4">
				<i class="far fa-thumbs-up"></i>
			</a>
		</div>
		<div class="flex flex-row justify-center">
			<a href="javascript:void(0);" data-respuesta="{{ $pregunta->respuestas->where('tipo', 'dislike')->first()?->id }}" class="rounded-full border-2 border-white dislike-click bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-3xl items-center p-4">
				<i class="far fa-thumbs-down"></i>
			</a>
		</div>
		@endif
		<div class="flex flex-row justify-center">
			<a href="javascript:void(0);" class="like-click border-2 px-3 border-white" data-respuesta="{{ $pregunta->respuestas->where('tipo', 'like')->first()?->id }}">
				{{ $pregunta->respuestas->where('tipo', 'like')->first()?->respuesta }}
			</a>
		</div>
		<div class="flex flex-row justify-center">
			<a href="javascript:void(0);" class="dislike-click border-2 px-3 border-white" data-respuesta="{{ $pregunta->respuestas->where('tipo', 'dislike')->first()?->id }}">
				{{ $pregunta->respuestas->where('tipo', 'dislike')->first()?->respuesta }}
			</a>
		</div>
	</dib>
	<input type="hidden" id="like-dislike" name="respuesta-{{ $pregunta->id }}" value="">
</div>
