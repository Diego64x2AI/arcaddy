@if($cliente->galeria->count() > 0)
<section id="galeria" class="mt-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'galeria')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'galeria')->first()->titulo }}</div>
	@endif
	<div id="galeria-swiper" class="swiper swiper-galeria mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->galeria as $banner)
			<div class="swiper-slide">
				<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
