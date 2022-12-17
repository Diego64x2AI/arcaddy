@if($cliente->playlist->count() > 0)
<section id="playlist" class="mt-5 py-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'playlist')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'playlist')->first()->titulo }}</div>
	@endif
	<div id="libres-swiper" class="swiper swiper-3 mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->playlist as $item)
			<div class="swiper-slide">
				<div><img src="{{ asset('storage/'.$item->archivo) }}" alt="{{ $item->plataforma }}" class="object-fill w-3/4 h-auto inline"></div>
				<div class="text-center">
					<a href="{{ $item->link }}" target="_blank" class="btn-pill mt-5">Escuchar en <span class="uppercase">{{ $item->plataforma }}</span></a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
