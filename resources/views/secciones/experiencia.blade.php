@if($cliente->experiencias->count() > 0)
<section id="experiencia" class="mt-5 py-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'experiencia')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'experiencia')->first()->titulo }}</div>
	@endif
	<div id="experiencia-swiper" class="swiper swiper-experiencia mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->experiencias as $item)
			<div class="swiper-slide">
				<div><img src="{{ asset('storage/'.$item->archivo) }}" alt="{{ $item->titulo }}" class="object-fill w-full h-auto inline"></div>
				@if ($item->titulo !== NULL && $item->titulo !== '')
				<div class="color text-center font-extrabold text-4xl mt-3">{{ $item->titulo }}</div>
				@endif
				@if ($item->descripcion !== NULL && $item->descripcion !== '')
				<p class="text-center text-base px-8 mt-5">{!! nl2br($item->descripcion) !!}</p>
				@endif
				<div class="text-center">
					<a href="{{ $item->link }}" class="btn-pill mt-5">
					

					<?php /*{{($cliente->id != 33 && $cliente->id != 42 && $cliente->id != 44)?'Ingresar a VR':'Ingresar a AR'}}*/?>
					@if($item->texto_boton != '')
					{{ $item->texto_boton }}
					@else
						Ingresar a AR
					@endif
					</a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
