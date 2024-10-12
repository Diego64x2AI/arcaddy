@if($cliente->banners->count() > 0)
@php
	$sucursal_id = Session::get('sucursal_id');
	$banners = $cliente->banners;
	if ($sucursal_id !== NULL) {
		$banners = $cliente->banners()->whereHas('sucursales', function($query) use ($sucursal_id) {
			$query->where('sucursal_id', $sucursal_id);
		})->orDoesntHave('sucursales')->where('cliente_id', $cliente->id)->where('activo', 1)->get();
	}
@endphp
<section id="banners">
	@if ($cliente->secciones()->where('seccion', 'banners')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'banners')->first()->titulo }}</div>
	@endif
	<!-- Slider main container -->
	<div id="banners-swiper" class="swiper">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			@foreach($banners as $banner)
			<div class="swiper-slide bg-cover bg-center slide-bg relative flex items-center
        justify-center h-screen overflow-hidden" style="background-image: url({{ asset('storage/'.$banner->archivo) }});">
				@if (pathinfo($banner->archivo, PATHINFO_EXTENSION) == 'mp4')
				<video style="position: absolute; z-index: -1; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" playsinline loop muted>
					<source src="{{ asset('storage/'.$banner->archivo) }}" type="video/mp4">
					Your browser does not support the video tag.
				</video>
				@endif
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

<script>
	window.addEventListener('load', function() {
		const swiperBanners = new Swiper('#banners-swiper', {
			loop: true,
			autoplay: {
				delay: {{ $cliente->secciones()->where('seccion', 'banners')->first()->timer }},
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
		// on init check if there is a video in the first slide
		const video = swiperBanners.slides[swiperBanners.activeIndex].querySelector('video');
		if (video) {
			video.play();
		}
		swiperBanners.on('beforeSlideChangeStart', function() {
			// find if there is a video in the previous slide
			const previousSlide = swiperBanners.slides[swiperBanners.previousIndex];
			const video = previousSlide.querySelector('video');
			if (video) {
				// reset the video
				video.currentTime = 0;
				video.pause();
			}
		});
		swiperBanners.on('slideChangeTransitionEnd', function() {
			// find if there is a video in the current slide
			const currentSlide = swiperBanners.slides[swiperBanners.activeIndex];
			const video = currentSlide.querySelector('video');
			if (video) {
				video.currentTime = 0;
				video.play();
			}
		});
	});
</script>
