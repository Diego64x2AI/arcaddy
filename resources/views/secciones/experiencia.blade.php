@if($cliente->experiencias->count() > 0)
<section id="playlist" class="mt-5 py-5 text-center">
	<div id="libres-swiper" class="swiper mt-5">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->experiencias as $item)
			<div class="swiper-slide">
				<div><img src="{{ asset('storage/'.$item->archivo) }}" alt="{{ $item->titulo }}" class="object-fill w-full h-auto inline"></div>
				@if ($item->titulo !== NULL && $item->titulo !== '')
				<div class="text-center color text-3xl font-extrabold px-5 mt-5">{{ $item->titulo }}</div>
				@endif
				@if ($item->descripcion !== NULL && $item->descripcion !== '')
				<p class="text-center text-base px-4 mt-5">{!! nl2br($item->descripcion) !!}</p>
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
