@if($cliente->libres->count() > 0)
<section id="libres" class="text-center"><!-- mt-5 lg:mt-10-->
	@if ($cliente->secciones()->where('seccion', 'libres')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'libres')->first()->titulo }}</div>
	@endif
	<div id="libres-swiper" class="swiper swiper-1 "><!-- mt-5 lg:mt-10-->
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper "><!-- pb-14 -->
			@foreach($cliente->libres as $banner)
			<div class="swiper-slide bg-cover bg-center slide-bg" style="background-image: url({{ asset('storage/'.$banner->archivo) }});">
				@if ($banner->link !== NULL && trim($banner->link) !== '')
					<a href="{{ $banner->link }}" style="text-indent: -8000px;display:block;width:100%;height:100%;">{{ __('arcaddy.link') }}</a>
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
