<div class="flex flex-col gap-3">
	<textarea name="open-answer-{{ $pregunta->id }}" id="open-answer-{{ $pregunta->id }}" class="w-full resize-none color" placeholder="{{ __('arcaddy.quizopen') }}" data-respuesta="{{ $pregunta->respuestas->first()->id }}"></textarea>
</div>
