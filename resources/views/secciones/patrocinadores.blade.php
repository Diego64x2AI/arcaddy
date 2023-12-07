@if($cliente->patrocinadores->count() > 0)
<section id="patrocinadores" class="mt-5 p-5 text-center max-w-5xl mx-auto lg:px-8 lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'patrocinadores')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'patrocinadores')->first()->titulo }}</div>
	@endif
	<div class="flex flex-col flex-wrap lg:flex-row items-center">
		@foreach($cliente->patrocinadores as $patrocinador)
		<div class="w-full md:w-1/2 lg:w-1/3 px-2 mt-10 mx-auto">
			@if ($patrocinador->link !== NULL && trim($patrocinador->link) !== '')
				<a href="{{ $patrocinador->link }}" target="_blank"><img src="{{ asset('storage/'.$patrocinador->archivo) }}" class="object-fill w-3/4 h-auto inline"></a>
			@else
			<img src="{{ asset('storage/'.$patrocinador->archivo) }}" class="object-fill w-3/4 h-auto inline">
			@endif
		</div>
		@endforeach
	</div>
</section>
@endif
