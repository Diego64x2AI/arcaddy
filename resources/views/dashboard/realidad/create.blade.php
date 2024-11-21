<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					AR
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.realidad.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<form method="POST" action="{{route('cliente.realidad.store', ['cliente' => $cliente->id])}}" enctype="multipart/form-data">
		@csrf
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
						<input type="text" name="titulo" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="Ejemplo: Términos y condiciones" value="{{ old('titulo') }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							ar-caddy.com/{{ $cliente->slug }}/ar/
						</label>
						<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="slug" id="slug"
							type="text" value="{{ old('slug') }}" placeholder="Ejemplo: terminos-y-condiciones" required>
					</div>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8 mt-3">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="boton_texto">
							Texto Botón
						</label>
						<input type="text" name="boton_texto" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="Ejemplo: Misterio 3D Centro" value="{{ old('boton_texto') }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="boton_link">
							Descripción
						</label>
						<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="descripcion" id="descripcion"
							type="text" value="{{ old('descripcion') }}" placeholder="Ejemplo: Tómate la foto">
					</div>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-8 mt-3">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="imagen">
							Portada
						</label>
						<div id="preview-container"></div>
						<input type="file" id="imagen" name="imagen" multiple accept="image/*" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="glb">
							Modelo GLB
						</label>
						<div id="preview-container"></div>
						<input type="file" id="glb" name="glb" multiple accept=".glb" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="usdz">
							Modelo USDZ
						</label>
						<div id="preview-container"></div>
						<input type="file" id="usdz" name="usdz" multiple accept=".usdz" required>
					</div>
				</div>
				<div class="mt-3">
					<label class="block tracking-wide text-gray-900 text-xl font-bold mb-2" for="texto">
						Contenido
					</label>
					<textarea class="input-border alx-editor" name="texto" id="texto"
						rows="5">{{ str_replace(["../../../../storage", "../https"], [url("storage"), "https"], old('texto')) }}</textarea>
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

		});
	</script>
	<script type="text/javascript">
		tinymce.init({
			// disable menubar
			menubar: false,
			height: 300,
			selector: 'textarea.alx-editor',
			plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
			toolbar: 'styles | bold italic | forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
			image_title: true,
			automatic_uploads: true,
			file_picker_types: 'image media file',
			images_upload_url: '{{ route('clientes.upload.editor') }}',
			file_picker_callback: (cb, value, meta) => {
				console.log(value, meta);
				const input = document.createElement('input');
				input.setAttribute('type', 'file');
				if (meta.filetype === 'image') {
					input.setAttribute('accept', 'image/*');
				} else if (meta.filetype === 'media') {
					input.setAttribute('accept', 'video/*');
				} else if (meta.filetype === 'file') {
					// accept only pdf and docx
					input.setAttribute('accept', '.pdf,.docx');
				}

				input.addEventListener('change', (e) => {
					const file = e.target.files[0];

					const reader = new FileReader();
					reader.addEventListener('load', () => {
						/*
							Note: Now we need to register the blob in TinyMCEs image blob
							registry. In the next release this part hopefully won't be
							necessary, as we are looking to handle it internally.
						*/
						const id = 'blobid' + (new Date()).getTime();
						const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
						const base64 = reader.result.split(',')[1];
						const blobInfo = blobCache.create(id, file, base64);
						blobCache.add(blobInfo);

						/* call the callback and populate the Title field with the file name */
						cb(blobInfo.blobUri(), { title: file.name });
					});
					reader.readAsDataURL(file);
				});
				input.click();
			},
		});
</script>
	@endsection
</x-app-layout>
