<section id="informacion" class="p-5 mt-5 max-w-5xl mx-auto lg:px-8 lg:mt-10">
	@if ($cliente->titulo !== NULL && $cliente->titulo !== '')
	<h1 class="titulo-modulo">{{ $cliente->titulo }}</h1>
	@endif
	@if ($cliente->subtitulo !== NULL && $cliente->subtitulo !== '')
	<h2 class="text-center font-extrabold text-2xl px-8 lg:text-4xl">{{ $cliente->subtitulo }}</h2>
	@endif
	@if ($cliente->fecha !== NULL && $cliente->fecha !== '')
	<div class="text-center font-bold text-xl mt-2 lg:text-2xl">{{ $cliente->fecha }}</div>
	@endif
	@if ($cliente->descripcion !== NULL && $cliente->descripcion !== '')
	<p class="text-center text-base px-4 mt-5 lg:text-2xl">
	    <div class="alx-editor-impresion">
	    <?php /*{!! nl2br($cliente->descripcion) !!} */?>
	    {!! $cliente->descripcion !!}
	    </div>
	</p>
	@endif
</section>
@includeIf('secciones.votaciones')
<style>
.alx-editor-impresion ul{
    list-style: disc;
    padding-left: 40px;
}
.alx-editor-impresion ol{
    list-style: auto;
    padding-left: 40px;
}
</style>
