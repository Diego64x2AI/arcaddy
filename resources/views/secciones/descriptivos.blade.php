<section id="informacion" class="p-5 mt-5">
	@if ($cliente->titulo !== NULL && $cliente->titulo !== '')
	<h1 class="color text-center font-extrabold text-4xl">{{ $cliente->titulo }}</h1>
	@endif
	@if ($cliente->subtitulo !== NULL && $cliente->subtitulo !== '')
	<h2 class="text-center font-extrabold text-2xl px-8">{{ $cliente->subtitulo }}</h2>
	@endif
	@if ($cliente->fecha !== NULL && $cliente->fecha !== '')
	<div class="text-center font-bold text-xl mt-2">{{ $cliente->fecha }}</div>
	@endif
	@if ($cliente->descripcion !== NULL && $cliente->descripcion !== '')
	<p class="text-center text-base px-4 mt-5">{!! nl2br($cliente->descripcion) !!}</p>
	@endif
</section>
