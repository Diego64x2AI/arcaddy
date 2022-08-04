@if($cliente->galeria->count() > 0)
<section id="galeria" class="mt-5 px-5 text-center lg:mt-10">
	<div class="text-center color text-4xl lg:text-8xl">Así se vive</div>
	<div class="text-center text-4xl font-extrabold lg:text-8xl">{{ $cliente->titulo }}</div>
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
