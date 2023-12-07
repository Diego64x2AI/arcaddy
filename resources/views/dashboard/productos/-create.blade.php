<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ ($producto->id !== NULL) ? 'Editar' : 'Agregar' }} producto | {{ $cliente->cliente }}
		</h2>
	</x-slot>
	<div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
		<a href="{{ route('clientes.edit', ['cliente' => $cliente->id]) }}" class="text-sky-500">Regresar</a>
	</div>
	<style>
		.container-draggable::after {
			display: block;
			clear: both;
			content: "";
		}

		.examinar-img {
			display: none;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -63.5px;
			margin-top: -40px;
			background-color: #FFF;
			padding: 10px;
		}

	</style>
	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white">
				@if ($errors->any())
				<div class="my-5">
					<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
				</div>
				@endif
				@if (session('success'))
					<div class="my-5">
						<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
					</div>
					@endif
				<form action="{{ $producto->id === NULL ? route('productos.store', ['cliente' => $cliente->id]) : route('productos.update', ['cliente' => $cliente->id, 'producto' => $producto->id]) }}" name="cliente-form" method="POST" enctype="multipart/form-data">
					@csrf
					@if ($producto->id !== NULL)
					@method('PUT')
					@endif
					<input type="hidden" name="cliente" value="{{ $cliente->id }}">
					<div class="p-6 bg-gray-100 border border-white">
						<div class="flex flex-wrap items-center -mx-3">
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="nombre">
									Nombre:
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="nombre" id="nombre"
									type="text" value="{{ ($producto->id !== NULL) ? $producto->nombre : old('nombre') }}" placeholder="Nombre del producto" required>
							</div>
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="sku">
									SKU / Código de producto:
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="sku" id="sku"
									type="text" value="{{ ($producto->id !== NULL) ? $producto->sku : old('sku') }}" placeholder="SKU" required>
							</div>
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="precio">
									Precio
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="precio" id="precio"
									type="number" value="{{ ($producto->id !== NULL) ? $producto->precio : old('precio') }}" placeholder="0.00" required>
							</div>
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="descuento">
									Descuento (%)
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="descuento" id="descuento"
									type="number" value="{{ ($producto->id !== NULL) ? $producto->descuento : old('descuento') }}" placeholder="0" required>
							</div>
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="descuento">
									Digital
								</label>
								<input type="checkbox" name="digital" value="on" @if($producto->id !== NULL && $producto->digital) checked @endif>
							</div>
						</div>

						<div class="flex flex-wrap -mx-3 justify-center">
							<div class="w-full px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="descripcion">
									Descripción:
								</label>
								<textarea class="shadow appearance-none resize-none h-40 border-0 w-full py-2 px-3 text-gray-700" name="descripcion" id="descripcion"
									type="text" placeholder="Descripción del producto" required>{{ ($producto->id !== NULL) ? $producto->descripcion : old('descripcion') }}</textarea>
							</div>
						</div>

						<div id="secciones-container">
							<div id="banners" class="bg-white p-3 mt-3">
								<input type="hidden" name="secciones[]" value="banners">
								<div class="flex flex-row items-center font-bold">
									<div class="text-xl md:text-3xl truncate mr-1">Imagenes del producto</div>
								</div>
								<div id="banners-container" class="container-draggable mt-5 section-box">
									@if ($producto->id !== NULL)
										@foreach ($producto->imagenes as $banner)
										<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
											<div class="p-3">
												<div class="mb-2 relative">
													<img src="{{ asset('storage/'.$banner->archivo) }}"
														class="img-general object-cover w-100 border border-secondary">
													<div class="examinar-img group-hover:block">
														<div><button type="button"
																class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
														</div>
														<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
														<input type="hidden" name="banners_old[]" value="{{$banner->archivo}}" />
														<input type="file" name="banners_img[]" class="file-general" accept="image/*" style="display:none" />
													</div>
												</div>
												<div class="mb-2">
													<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
														Título SEO:
													</label>
													<input
														class="input-underline"
														name="banners_titulo[]" value="{{ $banner->titulo }}" type="text" required>
												</div>
												<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
													<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
													<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
																class="fas fa-trash-alt"></i></a></div>
												</div>
											</div>
										</div>
										@endforeach
									@else
									<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
										<div class="p-3">
											<div class="mb-2 relative">
												<img src="{{ asset('images/banner.jpg') }}"
													class="img-general object-cover w-100 border border-secondary">
												<div class="examinar-img group-hover:block">
													<div><button type="button"
															class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
													</div>
													<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
													<input type="hidden" name="banners_old[]" value="" />
													<input type="file" name="banners_img[]" class="file-general" accept="image/*" style="display:none" />
												</div>
											</div>
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													Título SEO:
												</label>
												<input
													class="input-underline"
													name="banners_titulo[]" type="text" required>
											</div>
											<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
												<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
												<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
															class="fas fa-trash-alt"></i></a></div>
											</div>
										</div>
									</div>
									@endif
								</div>
								<div class="text-right mt-5">
									<a href="" id="add_banner" class="btn-pill">+ Agregar</a>
								</div>
							</div>
							<!-- /banners -->
						</div>
					</div>
					<div class="fixed top-20 right-0">
						<button type="submit" class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white w-12 h-12"><i class="fa fa-save"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@section('js')
	<script>
		window.addEventListener('load', function() {
				$('body').on('click', 'button.examinar-btn', function (e) {
					e.preventDefault();
					console.log('click')
					$(this).parent().parent().find('input[type=file]').trigger('click');
				});
				new Sortable(document.getElementById('banners-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				$('body').on('change', '.file-general', function () {
					const $esto = $(this);
					if (this.files && this.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$esto.parent().parent().find('img.img-general').attr('src', e.target.result);
						}
						reader.readAsDataURL(this.files[0]);
					}
				});
				// agregar banner
				$('a#add_banner').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="banners_old[]" value="" />
									<input type="file" name="banners_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input
									class="input-underline"
									name="banners_titulo[]" type="text" required>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#banners-container').append(html);
				});
				// eliminar bloques
				$('body').on('click', 'div.delete-fotometria a', function (e) {
					e.preventDefault();
					const esto = $(this);
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Este cambio se puede deshacer si actualizas la página sin guardar, en el momento que guardes tus cambios ya no podrás recuperar nada.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, eliminar',
						cancelButtonText: 'NO, cancelar'
					}).then((result) => {
						if (result.isConfirmed) {
							esto.parent().parent().parent().remove();
							// recordatorio();
							Swal.fire('Eliminado', 'Recuerda guardar tus cambios para que tengan efecto.', 'success')
						}
					})
				});
			});
	</script>
	@endsection
</x-app-layout>
