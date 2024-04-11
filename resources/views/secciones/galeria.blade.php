@if($cliente->galeria->count() > 0)
<section id="galeria" class="mt-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'galeria')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'galeria')->first()->titulo }}</div>
	@endif
	<div class="isotope-galeria grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
		@foreach($cliente->galeria as $banner)
		<div
			class="isotope-item isotope-galeria-item border-transparent w-full"
			data-imagen="{{ asset('storage/'.$banner->archivo) }}"
			data-titulo="{{ $banner->titulo }}"
			data-key="{{ $loop->index }}"
		>
			<div>
				<img src="{{ asset('storage/'.$banner->archivo) }}" alt="{{ $banner->titulo }}" class="object-fill w-full h-auto">
			</div>
		</div>
		@endforeach
	</div>
</section>
@endif
<script>
	window.addEventListener('load', function() {
		$('body').on('click', '.galeria-prev', function(e) {
			e.preventDefault();
			let current = parseInt($('#current-galeria').data('key'));
			current--;
			if (current < 0) {
				current = $('section#galeria').find('.isotope-galeria-item').length - 1;
			}
			$item = $('section#galeria').find('.isotope-galeria-item').eq(current);
			if ($item.length > 0) {
				$item.click();
			}
		});
		$('body').on('click', '.galeria-next', function(e) {
			e.preventDefault();
			let current = parseInt($('#current-galeria').data('key'));
			current++;
			if (current >= $('section#galeria').find('.isotope-galeria-item').length) {
				current = 0;
			}
			$item = $('section#galeria').find('.isotope-galeria-item').eq(current);
			if ($item.length > 0) {
				$item.click();
			}
		});
		$('.isotope-galeria-item').click(function(e) {
			e.preventDefault();
			const nombre = $(this).data('titulo');
			const imagen = $(this).data('imagen');
			const key = parseInt($(this).data('key'));
			let media = `<img class="w-full h-auto" src="${imagen}">`;
			const buttons = `
			<a href="javascript:void(0);" class="galeria-prev absolute z-50 top-1/2 left-3 text-3xl color"><i class="fa fa-chevron-left"></i></a>
			<a href="javascript:void(0);" class="galeria-next absolute z-50 top-1/2 right-3 text-3xl color"><i class="fa fa-chevron-right"></i></a>
			`;
			Swal.fire({
				title: `<div class="font-bold uppercase mt-5 text-base color">${nombre}</div>`,
				icon: null,
				html: `<div id="current-galeria" data-key="${key}"><div class="relative">${media}${buttons}</div></div>`,
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
