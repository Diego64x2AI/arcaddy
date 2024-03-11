@if($cliente->galeria->count() > 0)
<section id="galeria" class="mt-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'galeria')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'galeria')->first()->titulo }}</div>
	@endif
	<div class="isotope-galeria grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
		@foreach($cliente->galeria as $banner)
		<div
			class="isotope-item isotope-galeria-item border-transparent w-1/3 md:w-1/4 lg:w-1/6"
			data-imagen="{{ asset('storage/'.$banner->archivo) }}"
			data-titulo="{{ $banner->titulo }}"
		>
			<div>
				<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
			</div>
		</div>
		@endforeach
	</div>
</section>
@endif
