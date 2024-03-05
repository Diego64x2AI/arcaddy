@if($cliente->colaboradores->count() > 0)
<section id="colaboradores" class="mt-5 py-5 lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'colaboradores')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'colaboradores')->first()->titulo }}</div>
	@endif
	<div id="colaboradores-swiper" class="swiper">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->colaboradores as $colaborador)
			<div class="swiper-slide">
				<div class="mb-5 relative">
					<img src="{{ asset('storage/'.$colaborador->archivo) }}" class="object-fill w-full h-auto">
					<div class="swiper-paginationfsdsdf"></div>
				</div>
				@if ($colaborador->nombre !== NULL && $colaborador->nombre !== '')
				<div class="text-center text-2xl font-extrabold ">{{ $colaborador->nombre }}</div>
				@endif
				@if ($colaborador->talento !== NULL && $colaborador->talento !== '')
				<div class="color text-center font-extrabold text-xl mt-3">{{ $colaborador->talento }}</div>
				@endif
				@if ($colaborador->descripcion !== NULL && $colaborador->descripcion !== '')
				<p class="text-center text-base px-8 mt-5">{!! nl2br($colaborador->descripcion) !!}</p>
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
