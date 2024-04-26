@if($cliente->cartelera->count() > 0)
<section id="cartelera" class="py-10 px-5 w-full max-w-5xl mx-auto">
	@if ($cliente->secciones()->where('seccion', 'cartelera')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'cartelera')->first()->titulo }}</div>
	@endif
	<div class="flex flex-col gap-3">
	@foreach ($cliente->cartelera()->orderBy('id', 'asc')->groupBy('categoria')->pluck('categoria') as $key => $cartelera_categoria)
	<div>
		<div class="border relative borde rounded-3xl accordeon-link bg-client cursor-pointer text-white px-5 py-3 text-xl text-center uppercase font-bold">
			<div>{{ $cartelera_categoria }}</div>
			<div class="absolute top-3 right-5">
				{!! $loop->first ? '<i class="fa fa-minus"></i>' : '<i class="fa fa-plus"></i>' !!}
			</div>
		</div>
		<div class="py-3 gap-2 grid grid-cols-1 justify-evenly"{!! $loop->first ? '' : ' style="display:none;"' !!}>
			@foreach ($cliente->cartelera->where('categoria', $cartelera_categoria) as $item)
			<div
				@class([
					'px-2', 'py-2', 'flex', 'flex-row', 'items-center', 'shadow', 'rounded-3xl', 'relative',
					'cartelera-item-link' => !$item->inter,
					'borde' => !$item->inter,
					'border' => !$item->inter,
					'bg-gray-200' => $item->inter,
				])
				data-imagen="{{ ($item->archivo !== NULL && trim($item->archivo) !== '') ? asset('storage/'.$item->archivo) : asset('images/blank.png') }}"
				data-nombre="{{ $item->titulo }}"
				data-descripcion="{{ $item->descripcion }}"
			>
				@if(!$item->inter)
				<div class="w-16 min-w-16">
					<img alt="{{ $item->titulo }}" class="w-16 h-16 object-cover shadow rounded-xl" src="{{ ($item->archivo !== NULL && trim($item->archivo) !== '') ? asset('storage/'.$item->archivo) : asset('images/blank.png') }}">
				</div>
				@endif
				<div class="mx-2">
					<div class="font-semibold text-start">
						{{ $item->titulo }}
						@if($item->inter)
						<span class="color">{{ $item->expositor }}</span>
						@endif
					</div>
					@if(!$item->inter)
					<div class="color text-start lg:text-base text-wrap">{{ $item->expositor }}</div>
					@endif
					<div class="text-xs text-start lg:text-base text-wrap">{{ $item->fecha->format('d-m-Y') }} {{ $item->hora }} - <span class="font-bold">{{ $item->lugar }}</span></div>
				</div>
				<div class="ml-auto text-center">
					<div class="color text-xs font-semibold">Recordarme</div>
					<div class="text-3xl">
						<a href="{{ route('cliente.download.event', ['ClienteCartelera' => $item->id, 'slug' => $cliente->slug]) }}"><i class="fa fa-calendar-plus"></i></a>
					</div>
				</div>
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
		$('.cartelera-item-link').click(function(e) {
			console.log(event.target);
			if ($(event.target).hasClass('fa-calendar-plus')) {
				return;
			}
			e.preventDefault();
			const nombre = $(this).data('nombre');
			const imagen = $(this).data('imagen');
			const descripcion = jQuery.trim($(this).data('descripcion'));
			if (descripcion === '') {
				return;
			}
			Swal.fire({
				title: `<div class="font-bold uppercase text-xs color2">&nbsp;</div>`,
				icon: null,
				html: `
					<div class="my-3 color2 text-[1rem]">${descripcion}</div>
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
