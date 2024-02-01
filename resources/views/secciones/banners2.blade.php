@if($cliente->banners2->count() > 0)
<section id="banners2">
	@if ($cliente->secciones()->where('seccion', 'banners2')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'banners2')->first()->titulo }}</div>
	@endif
	<!-- Slider main container -->
	<div class="swiper swiper-1">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			@foreach($cliente->banners2 as $banner)
			<div class="swiper-slide bg-cover bg-center slide-bg" style="background-image: url({{ asset('storage/'.$banner->archivo) }});">
				@if ($banner->link !== NULL && trim($banner->link) !== '')
					<a href="{{ $banner->link }}" style="text-indent: -8000px;display:block;width:100%;height:100%;">Link</a>
				@endif
			</div>
			@endforeach
		</div>
		<div class="swiper-button-next">
			<i class="fa fa-chevron-right"></i>
		</div>
    <div class="swiper-button-prev">
			<i class="fa fa-chevron-left"></i>
		</div>
	</div>
</section>
@endif
