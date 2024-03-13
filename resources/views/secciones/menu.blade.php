@if($cliente->menu->count() > 0)
<section id="menu" class="py-10 px-5 w-full max-w-5xl mx-auto">
	@if ($cliente->secciones()->where('seccion', 'menu')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'menu')->first()->titulo }}</div>
	@endif
	<div class="flex flex-col gap-3">
	@foreach ($cliente->menu()->orderBy('id', 'asc')->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
	<div>
		<div class="border relative borde rounded-3xl accordeon-link bg-client cursor-pointer text-white px-5 py-3 text-xl text-center uppercase font-bold">
			<div>{{ $menu_categoria }}</div>
			<div class="absolute top-3 right-5">
				<i class="fa fa-plus"></i>
			</div>
		</div>
		<div class="py-3 gap-2 grid grid-cols-1 lg:grid-cols-3 justify-evenly" style="display: none;">
			@foreach ($cliente->menu->where('categoria', $menu_categoria) as $menu)
			<div
				class="border borde px-2 py-2 flex flex-row lg:flex-col items-center shadow rounded-3xl relative menu-item-link"
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
				<div class="w-16 min-w-16 lg:min-w-full">
					<img alt="{{ $menu->nombre }}" class="w-16 h-16 lg:w-full lg:h-auto object-cover shadow rounded-xl" src="{{ ($menu->archivo !== NULL && trim($menu->archivo) !== '') ? asset('storage/'.$menu->archivo) : asset('images/blank.png') }}">
				</div>
				<div class="mx-2 lg:mt-2">
					<div class="font-semibold text-start lg:text-center">{{ $menu->nombre }}</div>
					<div class="text-xs text-start lg:text-center lg:text-base text-wrap">{{ $menu->descripcion }}</div>
					<div class="text-xs text-start lg:text-center hidden lg:block">{!! ($menu->cantidad !== NULL && trim($menu->cantidad) !== '') ? $menu->cantidad : '&nbsp;' !!}</div>
				</div>
				<div class="text-[15px] lg:text-base color font-bold">
					{{ $menu->precio }}
				</div>
				@if ($menu->canje_texto)
				<div class="absolute -top-3 right-0 bg-client text-[9px] text-white rounded-3xl px-3 py-2 uppercase font-semibold">{{ $menu->canje_texto }}</div>
				@endif
			</div>
			@endforeach
		</div>
	</div>
	@endforeach
	</div>
</section>
@endif
<script>
	window.addEventListener('load', function() {
		$('.menu-item-link').click(function(e) {
			e.preventDefault();
			const nombre = $(this).data('nombre');
			const imagen = $(this).data('imagen');
			const descripcion = $(this).data('descripcion');
			const canje = $(this).data('canje-texto');
			const precio = $(this).data('precio');
			const boton = $(this).data('boton');
			const link = $(this).data('link');
			const cantidad = ($(this).data('cantidad') !== null && jQuery.trim($(this).data('cantidad')) !== '') ? $(this).data('cantidad') : '';
			let media = `<img class="w-full h-auto" src="${imagen}">`;
			let canjeText = '';
			let botonHtml = '';
			if (canje !== '' && canje !== null) {
				canjeText = `<div class="absolute -bottom-3 right-0 bg-client text-[9px] text-white rounded-3xl px-3 py-2 uppercase font-semibold">${canje}</div>`;
			}
			if (boton !== '' && link !== '') {
				botonHtml = `<a href="${link}" target="_blank" class="btn-pill mt-3">${boton}</a>`;
			}
			Swal.fire({
				title: `<div class="font-bold uppercase text-xs color2">&nbsp;</div>`,
				icon: null,
				html: `
					<div class="relative">${media}${canjeText}</div>
					<div class="grow text-xl color2 mt-5 text-center w-full">
						<div class="font-semibold">${nombre}</div>
						<div class="text-xs">${cantidad}</div>
					</div>
					<div class="text-base color font-bold">${precio}</div>
					<div class="my-3 color2 text-[1rem]">${descripcion}</div>
					${botonHtml}
				`,
				showCloseButton: true,
				showCancelButton: false,
				showConfirmButton: false,
				focusConfirm: true,
				buttonsStyling: false,
				customClass: {
					popup: 'popup-menu',
					confirmButton: 'btn-pill',
				},
			});
		});
	});
</script>
