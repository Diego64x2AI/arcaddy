@if($cliente->productos()->where('digital', 0)->count() > 0)
<section id="blog" class="mt-5 py-5 text-center lg:mt-10">
	<div class="text-center text-4xl lg:text-8xl">Tienda <span class="color font-extrabold">Online</span></div>
	<div id="blog-swiper" class="swiper swiper-2 mt-5 lg:mt-10">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->productos()->where('digital', 0)->get() as $producto)
			<div class="swiper-slide">
				<div class="relative">
					<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" class="object-cover w-100 border border-secondary">
					@if ($producto->descuento > 0 && !$producto->digital)
						<div class="absolute bottom-2 left-2 bg-client text-white py-2 px-4 rounded-t-2xl rounded-br-2xl">{{ $producto->descuento }}% OFF</div>
					@endif
					@if ($producto->digital)
						<div class="absolute bottom-2 left-2 bg-client text-white py-2 px-4 rounded-t-2xl rounded-br-2xl">DIGITAL</div>
					@endif
				</div>
				<div class="text-center font-bold px-2 mt-2">{{ $producto->nombre }}</div>
				<div class="text-center font-normal px-2 mt-2">${{ $producto->precio }}</div>
				<div class="text-center">
					<a href="" class="btn-pill">Comprar</a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
