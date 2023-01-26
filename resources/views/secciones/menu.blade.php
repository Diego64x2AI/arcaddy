@if($cliente->menu->count() > 0)
<section id="menu" class="py-10 px-5">
	@if ($cliente->secciones()->where('seccion', 'menu')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'menu')->first()->titulo }}</div>
	@endif
	<div class="flex flex-row justify-evenly py-5 filter-button-group2">
		@foreach ($cliente->menu()->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
			<button class="btn-pill2 capitalize @if($loop->index === 0) current-cat @endif" data-filter=".cat-{{ $menu_categoria }}"">{{ $menu_categoria }}</button>
		@endforeach
	</div>
	<div class="isotope-menu grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6">
		@foreach ($cliente->menu()->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
			@foreach ($cliente->menu->where('categoria', $menu_categoria) as $menu)
				<div class="isotope-menu relative cat-{{ $menu_categoria }} w-full flex flex-row items-center shadow rounded-3xl text-gray-800 hover:bg-gray-100 mb-4 px-4 py-3">
					<div><img src="{{ ($menu->archivo !== NULL && trim($menu->archivo) !== '') ? asset('storage/'.$menu->archivo) : asset('images/blank.png') }}" alt="{{ $menu->nombre }}" class="w-10 h-10 md:w-20 md:h-20"></div>
					<div class="grow ml-2 text-sm md:text-xl">
						<div class="font-semibold">{{ $menu->nombre }}</div>
						<div class="text-xs md:text-base">{{ $menu->descripcion }}</div>
					</div>
					<div class="ml-2 text-xs md:text-base color font-semibold">
						{{ $menu->precio }}
					</div>
					@if ($menu->canje_texto)
					<div class="absolute -top-3 right-0 bg-client text-[9px] md:text-sm text-white rounded-3xl px-3 py-2 uppercase font-semibold">{{ $menu->canje_texto }}</div>
					@endif
				</div>
			@endforeach
		@endforeach
	</div>
</section>
@endif
