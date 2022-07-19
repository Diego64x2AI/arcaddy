@if($cliente->colaboradores->count() > 0)
		<section id="colaboradores" class="mt-5 py-5 lg:mt-10">
			<div id="colaboradores-swiper" class="swiper swiper-3">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper pb-14">
					@foreach($cliente->colaboradores as $colaborador)
					<div class="swiper-slide">
						@if ($colaborador->talento !== NULL && $colaborador->talento !== '')
						<div class="text-center text-2xl font-extrabold ">{{ $colaborador->talento }}</div>
						@endif
						<div class="mt-5 relative">
							<img src="{{ asset('storage/'.$colaborador->archivo) }}" class="object-fill w-full h-auto">
							<div class="swiper-paginationfsdsdf"></div>
						</div>
						@if ($colaborador->nombre !== NULL && $colaborador->nombre !== '')
						<div class="color text-center font-extrabold text-4xl mt-3">{{ $colaborador->nombre }}</div>
						@endif
						@if ($colaborador->descripcion !== NULL && $colaborador->descripcion !== '')
						<p class="text-center text-base px-4 mt-5">{!! nl2br($colaborador->descripcion) !!}</p>
						@endif
					</div>
					@endforeach
				</div>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>
			</div>
		</section>
		@endif
