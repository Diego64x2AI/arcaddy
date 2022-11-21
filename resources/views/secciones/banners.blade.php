@if($cliente->banners->count() > 0)
<section id="banners">
	<!-- Slider main container -->
	<div class="swiper swiper-1">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			@foreach($cliente->banners as $banner)
			<div class="swiper-slide bg-cover bg-center slide-bg" style="background-image: url({{ asset('storage/'.$banner->archivo) }});">
				@if ($banner->link !== NULL && trim($banner->link) !== '')
					<a href="{{ $banner->link }}" target="_blank" style="text-indent: -8000px;display:block;width:100%;height:100%;">Link</a>
				@endif
			</div>
			@endforeach
		</div>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
