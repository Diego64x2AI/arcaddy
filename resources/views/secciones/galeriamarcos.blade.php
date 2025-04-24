@if($cliente->galeriamarcos->count() > 0)
<section id="galeriamarcos" class="mt-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'galeriamarcos')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->titulo }}</div>
	@endif
	<div class="w-full max-w-[190px] mx-auto mb-8">
		<a href="{{ route('cliente.marco', ['slug' => $cliente->slug]) }}" class="btn-pill !py-2 !px-4 !font-semibold !text-sm uppercase">
			<div class="flex flex-row items-center">
				<div class="mr-3"><i class="fa fa-user-circle text-2xl"></i></div>
				<div>{{ __('arcaddy.marco2') }}</div>
			</div>
		</a>
	</div>
	<div class="isotope-galeriamarcos grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
		{{--
		@foreach($cliente->galeriamarcos()->paginate(25) as $banner)
		<div
			class="isotope-item isotope-galeriamarcos-item border-transparent w-full"
			data-imagen="{{ asset('storage/'.$banner->archivo) }}"
			data-titulo="{{ $banner->titulo }}"
			data-key="{{ $loop->index }}"
		>
			<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
		</div>
		@endforeach
		--}}
	</div>
	<div id="hasMorePagesGaleriasMarcos" class="mt-5">
		<a id="load-galeriasmarcos" href="#" class="btn-pill">{{ __('arcaddy.loadmore') }}</a>
	</div>
</section>
@endif
<script>
	let currentPageGaleriasMarcos = 0;
	let perPageGaleriasMarcos = {{ ($cliente->secciones()->where('seccion', 'galeriamarcos')->first()->timer > 0) ? $cliente->secciones()->where('seccion', 'galeriamarcos')->first()->timer : 24 }};
	let hasMorePagesGaleriasMarcos = true;
	let lastPageGaleriasMarcos = 1;
	let galeriasMarcosLoading = false;
	const loadGaleriaMarcos = () => {
		if (!hasMorePagesGaleriasMarcos || galeriasMarcosLoading) {
			return
		}
		currentPageGaleriasMarcos++;
		galeriasMarcosLoading = true;
		axios.get(`{{ url('/') }}/{{ $cliente->slug }}/galeriamarcos?page=${currentPageGaleriasMarcos}`)
		.then(response => {
			console.log(response.data);
			perPageGaleriasMarcos = response.data.per_page;
			lastPageGaleriasMarcos = response.data.last_page;
			hasMorePagesGaleriasMarcos = response.data.current_page < lastPageGaleriasMarcos;
			let galeriamarcos = response.data.data;
			if (!hasMorePagesGaleriasMarcos) {
				$('#hasMorePagesGaleriasMarcos').hide();
			}
			if (galeriamarcos.length > 0) {
				let key = response.data.from - 1;
				galeriamarcos.forEach(galeriamarco => {
					$('.isotope-galeriamarcos').append(`
					<div
						class="isotope-item isotope-galeriamarcos-item border-transparent w-full"
						data-imagen="{{ asset('storage/') }}/${galeriamarco.archivo}"
						data-titulo="${galeriamarco.titulo}"
						data-key="${key}"
					>
						<img src="{{ asset('storage/') }}/${galeriamarco.archivo}" alt="${galeriamarco.titulo}" class="object-fill w-full h-auto">
					</div>
					`);
					key++;
				});
			}
			galeriasMarcosLoading = false;
		})
		.catch(error => {
			console.error(error);
		});
	};
	window.addEventListener('load', function() {
		loadGaleriaMarcos();
		$('a#load-galeriasmarcos').click(function(e){
			e.preventDefault();
			loadGaleriaMarcos();
		});
		$('body').on('click', '.galeriamarcos-prev', function(e) {
			e.preventDefault();
			let current = parseInt($('#current-galeriamarcos').data('key'));
			current--;
			if (current < 0) {
				current = $('section#galeriamarcos').find('.isotope-galeriamarcos-item').length - 1;
			}
			$item = $('section#galeriamarcos').find('.isotope-galeriamarcos-item').eq(current);
			if ($item.length > 0) {
				$item.click();
			}
		});
		$('body').on('click', '.galeriamarcos-next', function(e) {
			e.preventDefault();
			let current = parseInt($('#current-galeriamarcos').data('key'));
			current++;
			if (current >= $('section#galeriamarcos').find('.isotope-galeriamarcos-item').length) {
				current = 0;
			}
			$item = $('section#galeriamarcos').find('.isotope-galeriamarcos-item').eq(current);
			if ($item.length > 0) {
				$item.click();
			}
		});
		$('body').on('click', '.isotope-galeriamarcos-item', function(e) {
			e.preventDefault();
			const nombre = $(this).data('titulo');
			const imagen = $(this).data('imagen');
			const key = parseInt($(this).data('key'));
			let media = `<img class="w-full h-auto" src="${imagen}">`;
			const buttons = `
			<a href="javascript:void(0);" class="galeriamarcos-prev absolute z-50 top-1/2 left-3 text-3xl color"><i class="fa fa-chevron-left"></i></a>
			<a href="javascript:void(0);" class="galeriamarcos-next absolute z-50 top-1/2 right-3 text-3xl color"><i class="fa fa-chevron-right"></i></a>
			`;
			Swal.fire({
				title: (nombre !== '' && nombre !== null) ? `<div class="font-bold uppercase mt-5 text-base color">${nombre}</div>` : `<div class="font-bold uppercase mt-5 text-base color">&nbsp;</div>`,
				icon: null,
				html: `<div id="current-galeriamarcos" data-key="${key}"><div class="relative">${media}${buttons}</div></div>`,
				showCloseButton: true,
				showCancelButton: false,
				showConfirmButton: false,
				focusConfirm: true,
				buttonsStyling: false,
				customClass: {
					confirmButton: 'btn-pill',
				},
			});
		});
	});
</script>
