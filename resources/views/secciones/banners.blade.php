@if($cliente->banners->count() > 0)
		<section id="banners">
			<!-- Slider main container -->
			<div class="swiper swiper-1">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					@foreach($cliente->banners as $banner)
					<div class="swiper-slide">
						<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
					</div>
					@endforeach
				</div>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>
			</div>
		</section>
		@endif
