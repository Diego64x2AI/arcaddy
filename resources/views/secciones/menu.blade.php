@if($cliente->menu->count() > 0)
<section id="menu" class="py-10 px-5">
	@if ($cliente->secciones()->where('seccion', 'menu')->first()->mostrar_titulo)
	<div class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl">{{ $cliente->secciones()->where('seccion', 'menu')->first()->titulo }}</div>
	@endif
	@if ($cliente->menu()->groupBy('categoria')->pluck('categoria')->count() > 3)
	<div class="mb-5">
		<select name="select-menu" id="select-menu">
			@foreach ($cliente->menu()->orderBy('id', 'asc')->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
				<option value=".cat-{{ Str::slug($menu_categoria) }}"  @if($loop->index === 0) selected @endif>{{ $menu_categoria }}</option>
			@endforeach
		</select>
	</div>
	@else
	<div class="flex flex-row justify-evenly gap-3 text-sm py-5 filter-button-group2">
		@foreach ($cliente->menu()->orderBy('id', 'asc')->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
			<button class="btn-pill2 capitalize @if($loop->index === 0) current-cat @endif" data-filter=".cat-{{ Str::slug($menu_categoria) }}">{{ $menu_categoria }}</button>
		@endforeach
	</div>
	@endif
	<div class="isotope-menu container mx-auto">
		@foreach ($cliente->menu()->orderBy('id', 'asc')->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
			@foreach ($cliente->menu->where('categoria', $menu_categoria) as $menu)
				<div class="isotope-menu-item relative cat-{{ Str::slug($menu_categoria) }} w-full lg:w-1/4 flex flex-row lg:flex-col items-center shadow rounded-3xl lg:rounded-none mb-4 px-3 py-3"
					data-imagen="{{ ($menu->archivo !== NULL && trim($menu->archivo) !== '') ? asset('storage/'.$menu->archivo) : asset('images/blank.png') }}"
					data-nombre="{{ $menu->nombre }}"
					data-descripcion="{{ $menu->descripcion }}"
					data-precio="{{ $menu->precio }}"
					data-cantidad="{{ $menu->cantidad }}"
					data-boton="{{ $menu->boton_titulo }}"
					data-link="{{ $menu->boton_link }}"
					data-categoria="{{ $menu->categoria }}"
					data-canje-texto="{{ $menu->canje_texto }}"
				>
					<div><img src="{{ ($menu->archivo !== NULL && trim($menu->archivo) !== '') ? asset('storage/'.$menu->archivo) : asset('images/blank.png') }}" alt="{{ $menu->nombre }}" class="w-16 h-auto lg:w-full"></div>
					<div class="grow ml-2 text-sm lg:text-base xl:text-xl color2 lg:mt-5 lg:text-center lg:w-full">
						<div class="font-semibold">{{ $menu->nombre }}</div>
						<div class="text-xs lg:text-base">{{ $menu->descripcion }}</div>
						<div class="text-xs hidden lg:block">{!! ($menu->cantidad !== NULL && trim($menu->cantidad) !== '') ? $menu->cantidad : '&nbsp;' !!}</div>
					</div>
					<div class="ml-2 text-[15px] lg:text-base color font-bold">
						{{ $menu->precio }}
					</div>
					@if ($menu->canje_texto)
					<div class="absolute -top-3 right-0 bg-client text-[9px] text-white rounded-3xl px-3 py-2 uppercase font-semibold">{{ $menu->canje_texto }}</div>
					@endif
				</div>
			@endforeach
		@endforeach
	</div>
</section>
@endif
