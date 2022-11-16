@if($cliente->libres->count() > 0)
<section id="blog" class="mt-5 text-center lg:mt-10">
	<div id="libres-swiper" class="swiper swiper-1 mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->libres as $banner)
			<div class="swiper-slide bg-cover bg-center slide-bg" style="background-image: url({{ asset('storage/'.$banner->archivo) }});">
				@if ($banner->link !== NULL && trim($banner->link) !== '')
					<a href="{{ $banner->link }}" target="_blank" style="text-indent: -8000px;display:block;width:100%;height:100%;">Link</a>
				@endif
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
