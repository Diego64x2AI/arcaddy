<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ ($cliente->id !== NULL) ? 'Editar' : 'Agregar' }} cliente
		</h2>
	</x-slot>
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
				<form action="{{ $cliente->id === NULL ? route('clientes.store') : route('clientes.update', ['cliente' => $cliente->id]) }}" name="cliente-form" method="POST" enctype="multipart/form-data">
					@csrf
					@if ($cliente->id !== NULL)
					@method('PUT')
					@endif
					<div class="p-6 bg-gray-100 border border-white">
						<div class="flex flex-wrap items-center -mx-3">
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
									ar-caddy.com/
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="slug" id="slug"
									type="text" value="{{ ($cliente->id !== NULL) ? $cliente->slug : old('slug') }}" placeholder="Ejemplo: redbull" required>
							</div>
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
									Nombre cliente
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="cliente" id="cliente"
									type="text" value="{{ ($cliente->id !== NULL) ? $cliente->cliente : old('cliente') }}" placeholder="Ejemplo: Red Bull" required>
							</div>
							<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="color">
									Color de contraste
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="color" id="color"
									value="{{ ($cliente->id !== NULL) ? $cliente->color : old('color') }}" type="color" placeholder="#FF4E00" @if($cliente->id === NULL) required @endif>
							</div>
						</div>
						<div class="flex flex-wrap -mx-3 justify-center">
							<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
									Logo cliente
								</label>
								<img src="{{ ($cliente->id !== NULL) ? asset('storage/'.$cliente->logo) : asset('images/1000x1000.png') }}"
														class="img-general object-cover w-100 border border-secondary">
								<div class="text-center mt-3">
									<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									<div class="examinar-size text-xs mt-2 text-gray-400">(1000x1000px)</div>
								</div>
								<input name="logo" id="logo" type="file" class="file-general" accept="image/*" style="display: none">
							</div>
							@if($cliente->id !== NULL)
							<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
									QR cliente
								</label>
								<img src="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}"
														class="object-cover w-100 border border-secondary">
								<div class="text-center mt-3">
									<a role="button" href="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}" target="_blank" class="rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Descargar QR</a>
								</div>
							</div>
							@endif
						</div>

						<div id="secciones-container">
							@php
								$secciones = ($cliente->id !== NULL) ? $cliente->secciones()->select('seccion')->pluck('seccion')->toArray() : ['banners', 'descriptivos', 'colaboradores', 'patrocinadores', 'blog', 'galeria', 'playlist', 'experiencia', 'libres', 'live', 'social'];
							@endphp
							@foreach($secciones as $seccion)
								@includeIf('dashboard.clientes.secciones.'.$seccion)
							@endforeach
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
				new Sortable(document.getElementById('colaboradores-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('patrocinadores-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('blog-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('galeria-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('playlist-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('experiencia-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('libres-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('secciones-container'), {
					handle: '.handler2', // handle's class
					animation: 150,
					direction: 'vertical',
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
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
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
				// agregar colaborador
				$('a#add_artista').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/artista.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="colaboradores_old[]" value="" />
									<input type="file" name="colaboradores_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Nombre:
								</label>
								<input
									class="input-underline"
									name="colaboradores_titulo[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Talento / Título / Participación:
								</label>
								<input
									class="input-underline"
									name="colaboradores_talento[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Descripción:
								</label>
								<textarea class="input-border" name="colaboradores_descripcion[]"
									rows="5"></textarea>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#colaboradores-container').append(html);
				});
				// agregar patrocinador
				$('a#add_patrocinador').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/patrocinador.png') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="patrocinadores_old[]" value="" />
									<input type="file" name="patrocinadores_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input
									class="input-underline" name="patrocinadores_titulo[]" type="text" required>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#patrocinadores-container').append(html);
				});
				// agregar blog
				$('a#add_blog').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/blog.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="blog_old[]" value="" />
									<input type="file" name="blog_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título:
								</label>
								<input class="input-underline" name="blog_titulo[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Link externo:
								</label>
								<input class="input-underline" name="blog_link[]" type="url">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Descripción:
								</label>
								<textarea class="input-border" name="blog_descripcion[]" rows="5"></textarea>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#blog-container').append(html);
				});
				// agregar galeria
				$('a#add_galeria').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/galeria-1.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="galeria_old[]" value="" />
									<input type="file" name="galeria_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input
									class="input-underline"
									name="galeria_titulo[]" type="text" required>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#galeria-container').append(html);
				});
				// agregar playlist
				$('a#add_playlist').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/spotify.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="playlist_old[]" value="" />
									<input type="file" name="playlist_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Plataforma:
								</label>
								<input
									class="input-underline"
									name="playlist_plataforma[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Link:
								</label>
								<input
									class="input-underline"
									name="playlist_link[]" type="url">
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#playlist-container').append(html);
				});
				// agregar experiencia
				$('a#add_experiencia').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/experiencia.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="experiencia_old[]" value="" />
									<input type="file" name="experiencia_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título:
								</label>
								<input
									class="input-underline"
									name="experiencia_titulo[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Link:
								</label>
								<input
									class="input-underline"
									name="experiencia_link[]" type="url">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Instrucciones:
								</label>
								<textarea class="input-border" name="experiencia_instrucciones[]"
									rows="5"></textarea>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#experiencia-container').append(html);
				});
				// agregar libres
				$('a#add_libres').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="libres_old[]" value="" />
									<input type="file" name="libres_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input
									class="input-underline"
									name="libres_titulo[]" type="text" required>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#libres-container').append(html);
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
