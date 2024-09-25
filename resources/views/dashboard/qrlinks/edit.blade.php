<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Experiencias GEO / Rally
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.qrlinks.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<form method="POST" action="{{route('cliente.qrlinks.update', ['cliente' => $cliente->id, 'qrlink' => $qrlink->id])}}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="py-5">
			<div class="max-w-7xl mx-auto px-4 lg:px-8 bg-gray-100 py-10">
				@if ($errors->any())
				<div class="py-5">
					<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
				</div>
				@endif
				@if (session('success'))
				<div class="py-5">
					<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
				</div>
				@endif
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="titulo">
							Título
						</label>
						<input type="text" name="titulo" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="Ejemplo: Términos y condiciones" value="{{ old('titulo', $qrlink->titulo) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							ar-caddy.com/{{ $cliente->slug }}/
						</label>
						<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="slug" id="slug"
							type="text" value="{{ old('slug', $qrlink->slug) }}" placeholder="Ejemplo: terminos-y-condiciones" required>
					</div>
				</div>
				<div id="banners" class="bg-white p-3 mt-3">
					<input type="hidden" name="secciones[]" value="banners">
					<div class="flex flex-row items-center font-bold">
						<div class="text-xl md:text-3xl truncate mr-5 grow">
							Banners
						</div>
						<div class="ml-5">
							<span class="hidden md:inline-block mr-2">Módulo activo </span><input type="checkbox" name="banners-activo" value="on" @if($qrlink->banners) checked @endif>
						</div>
					</div>
					<div id="banners-container" class="container-draggable mt-5 section-box">
						@if ($cliente->id !== NULL)
							@foreach ($qrlink->banners2 as $banner)
							<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
								<div class="p-3">
									<div class="mb-2 relative">
										<img id="banners-{{ $banner->id }}" src="{{ asset('storage/'.$banner->archivo) }}" class="img-general object-cover w-100 border border-secondary">
										<div class="examinar-img group-hover:block">
											<div>
												<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">
													Examinar...
												</button>
											</div>
											<div class="mt-2 text-center text-xs">
												<a href="javascript:void(0);" class="text-dark crop-image" data-id="{{ $banner->id }}" data-tipo="banners" data-image="{{ asset('storage/'.$banner->archivo) }}" data-width="1903" data-height="1008">
													<i class="fas fa-crop"></i> Recortar
												</a>
											</div>
											<input type="hidden" name="banners_old[]" value="{{$banner->archivo}}" />
											<input type="file" name="banners_img[]" class="file-general" accept="image/*" style="display:none" />
										</div>
									</div>
									<div class="mb-2">
										<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
											Título SEO:
										</label>
										<input class="input-underline" name="banners_titulo[]" value="{{ $banner->titulo }}" type="text" >
									</div>
									<div class="mb-2">
										<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
											LINK:
										</label>
										<input class="input-underline" name="banners_link[]" value="{{ $banner->link }}" type="url">
									</div>
									<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
										<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
										<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
													class="fas fa-trash-alt"></i></a></div>
									</div>
								</div>
							</div>
							@endforeach
						@endif
					</div>
					<div class="text-right mt-5">
						<a href="" id="add_banner" class="btn-pill">+ Agregar</a>
					</div>
				</div>
				<!-- /banners -->
				<div class="mt-3">
					<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="texto">
						Contenido
					</label>
					<textarea class="input-border alx-editor" name="texto" id="texto"
						rows="5">{{ old('texto', $qrlink->texto) }}</textarea>
				</div>
				<div class="mt-3">
					<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2">
						Botón personalizado
					</label>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="boton_texto">
							Título
						</label>
						<input type="text" name="boton_texto" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="Ejemplo: Misterio 3D Centro" value="{{ old('boton_texto', $qrlink->boton_texto) }}">
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="boton_link">
							Link
						</label>
						<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="boton_link" id="boton_link"
							type="url" value="{{ old('boton_link', $qrlink->boton_link) }}" placeholder="Ejemplo: https://gioogle.com">
					</div>
				</div>
				<div class="mt-10">
					<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
				</div>
			</div>
		</div>
	</form>
	@section('js')
	<script src="{{ asset('assets/editor/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
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
							<input class="input-underline" name="banners_titulo[]" type="text">
						</div>
						<div class="mb-2">
							<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
								LINK:
							</label>
							<input class="input-underline" name="banners_link[]" type="url">
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
	<script type="text/javascript">
		tinymce.init({
			// disable menubar
			menubar: false,
			height: 700,
			selector: 'textarea.alx-editor',
			plugins: 'link code lists colorpicker textcolor image media',
			toolbar: 'styles | bold italic | forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code'
		});
</script>
	@endsection
</x-app-layout>
