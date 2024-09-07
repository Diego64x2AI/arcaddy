<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Grupos
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('grupos.index') }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>
	<form id="image-form" method="POST" action="{{route('grupos.store')}}" enctype="multipart/form-data">
		@csrf
		<div class="py-5">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100 py-10">
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
				<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-8">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Nombre
						</label>
						<input type="text" name="nombre" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('nombre') }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Logo
						</label>
						<div id="preview-container"></div>
						<input type="file" id="image-input" name="logo" accept="image/*">
					</div>
					<div class="col-span-2">
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
							Selecciona los miembros del grupo
						</label>
						<select name="cliente_id" class="shadow select2 appearance-none border-0 w-full !py-2 !px-3 text-gray-700 input-underline">
							<option value="">Clientes</option>
						</select>
					</div>
				</div>
				<div id="miembros" class="grid grid-cols-2 lg:grid-cols-6 justify-center items-center gap-3 mt-10">

				</div>
				<div class="mt-10">
					<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
				</div>
			</div>
		</div>
	</form>
</x-app-layout>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
	#preview-container {
		display: flex;
		flex-wrap: wrap;
	}

	#preview-container img {
		max-width: 100px;
		max-height: 100px;
		margin: 5px;
	}

	#preview-container-imageback {
		display: flex;
		flex-wrap: wrap;
	}

	#preview-container-imageback img {
		max-width: 100px;
		max-height: 100px;
		margin: 5px;
	}
</style>
<script>
	let baseUrl = "{{ url('/storage') }}";
	function formatState (item) {
		let $state = $(
			'<span><img src="' + baseUrl + '/' + item.logo + '" class="w-auto h-10 inline-block" /> ' + item.text + '</span>'
		);
		return $state;
	};
	document.addEventListener('DOMContentLoaded', function load() {
		if (!window.jQuery) return setTimeout(load, 50);
		$.getScript( "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js", function( data, textStatus, jqxhr ) {
			$('.select2').select2({
				placeholder: 'Selecciona un cliente',
  			allowClear: true,
				closeOnSelect: true,
				templateResult: formatState,
				ajax: {
					url: '{{ route('grupos.clientes') }}',
					dataType: 'json',
					delay: 250,
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
				}
			}).on('select2:select', function (e) {
				var data = e.params.data;
				console.log(data);
				// $('.select2').select2('close');
				$('#miembros').append(`<div class="text-center">
					<div class=text-center>
						<img src="${baseUrl}/${data.logo}" class="w-auto h-7 inline-block" alt="${data.text}">
					</div>
					<div class="text-sm">
						${data.text}
					</div>
					<div>
						<a href="javascript:void(0);" class="text-red-500 delete-miembro"><i class="fa fa-trash"></i></a>
					</div>
					<input type="hidden" name="miembro[]" value="${data.id}" >
				</div>`);
				return false;
			});
		});
		$('body').on('click', '.delete-miembro', function(e) {
				e.preventDefault();
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Una ves que elimines el quiz no podrás recuperar la información.",
					icon: null,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'SI, eliminarlo',
					cancelButtonText: 'Cancelar',
					allowOutsideClick: false,
				}).then((result) => {
					if (result.isConfirmed) {
						$(this).parent().parent().remove();
					}
				})
			});
		$('#image-input').on('change', function () {
			var files = this.files;
			var previewContainer = $('#preview-container');
			previewContainer.empty();
			for (var i = 0; i < files.length; i++) {
				var reader = new FileReader();
				reader.onload = function (e) {
					previewContainer.append('<img src="' + e.target.result + '" class="w-20 h-auto">');
				};
				reader.readAsDataURL(files[i]);
			}
		});
});
</script>
