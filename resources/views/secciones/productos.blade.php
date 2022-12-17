@if($cliente->productos()->where('digital', 0)->count() > 0)
<section id="blog" class="mt-5 py-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'productos')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'productos')->first()->titulo }}</div>
	@endif
	<div id="blog-swiper" class="swiper swiper-2 mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->productos()->where('digital', 0)->get() as $producto)
			<div class="swiper-slide">
				<div class="relative">
					<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" class="object-cover w-full h-auto inline-block border border-secondary">
					@if ($producto->descuento > 0 && !$producto->digital)
						<div class="absolute bottom-2 left-2 bg-client text-white py-2 px-4 rounded-t-2xl rounded-br-2xl">{{ $producto->descuento }}% OFF</div>
					@endif
					@if ($producto->digital)
						<div class="absolute bottom-2 left-2 bg-client text-white py-2 px-4 rounded-t-2xl rounded-br-2xl">DIGITAL</div>
					@endif
				</div>
				<div class="text-center font-bold px-2 mt-2">{{ $producto->nombre }}</div>
				<div class="text-center font-normal px-2 mt-2">
					@if ($producto->descuento > 0 && !$producto->digital)
						<span class="text-sm text-red-600">
							<s>${{ $producto->precio }}</s>
						</span>
						${{ $producto->precio - (($producto->descuento * $producto->precio) / 100) }}
					@else
						${{ $producto->precio }}
					@endif
				</div>
				<div class="text-center mt-4">
					<a href="{{ route('agregar_carrito', ['producto' => $producto->id]) }}" class="btn-pill">Comprar</a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
