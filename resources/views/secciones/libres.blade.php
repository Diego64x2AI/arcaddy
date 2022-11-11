@if($cliente->libres->count() > 0)
<section id="blog" class="mt-5 text-center lg:mt-10">
	<div id="libres-swiper" class="swiper swiper-1 mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->libres as $banner)
			<div class="swiper-slide">
				@if ($banner->link !== NULL && trim($banner->link) !== '')
					<a href="{{ $banner->link }}" target="_blank"><img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto"></a>
				@else
					<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
				@endif
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
