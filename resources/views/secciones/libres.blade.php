@if($cliente->libres->count() > 0)
<section id="blog" class="mt-5 text-center">
	<div class="text-center color text-4xl">Así se vive</div>
	<div class="text-center text-4xl font-extrabold">{{ $cliente->titulo }}</div>
	<div id="libres-swiper" class="swiper mt-5">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->libres as $banner)
			<div class="swiper-slide">
				<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
