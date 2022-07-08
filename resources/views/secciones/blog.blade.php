@if($cliente->blog->count() > 0)
<section id="blog" class="mt-5 py-5 text-center">
	<div class="text-center text-4xl">Life<span class="color font-extrabold">Style</span></div>
	<div id="blog-swiper" class="swiper mt-5">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper pb-14">
			@foreach($cliente->blog as $entry)
			<div class="swiper-slide">
				<div><img src="{{ asset('storage/'.$entry->archivo) }}" class="object-fill w-full h-auto inline"></div>
				@if ($entry->titulo !== NULL && $entry->titulo !== '')
				<div class="text-center text-3xl font-extrabold px-5 mt-5">{{ $entry->titulo }}</div>
				@endif
				@if ($entry->descripcion !== NULL && $entry->descripcion !== '')
				<p class="text-center text-base px-4 mt-5">{!! nl2br($entry->descripcion) !!}</p>
				@endif
				@if ($entry->link !== NULL && $entry->link !== '')
				<div class="text-center mt-4"><a href="{{ $entry->link }}" class="btn-pill" target="_blank">Ver más</a></div>
				@endif
			</div>
			@endforeach
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
@endif
