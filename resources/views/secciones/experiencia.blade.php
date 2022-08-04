@if($cliente->experiencias->count() > 0)
<section id="experiencia" class="mt-5 py-5 text-center lg:mt-10">
	<div id="libres-swiper" class="swiper swiper-1 mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->experiencias as $item)
			<div class="swiper-slide">
				<div><img src="{{ asset('storage/'.$item->archivo) }}" alt="{{ $item->titulo }}" class="object-fill w-full h-auto inline"></div>
				@if ($item->titulo !== NULL && $item->titulo !== '')
				<div class="text-center color text-3xl font-extrabold px-5 mt-5 lg:text-6xl">{{ $item->titulo }}</div>
				@endif
				@if ($item->descripcion !== NULL && $item->descripcion !== '')
				<p class="text-center text-base px-4 mt-5 lg:text-2xl">{!! nl2br($item->descripcion) !!}</p>
				@endif
				<div class="text-center">
					<a href="{{ $item->link }}" target="_blank" class="btn-pill mt-5">Ingresar a VR</span></a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
