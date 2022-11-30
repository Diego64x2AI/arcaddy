<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Participantes
				</h2>
			</div>
			<div class="ml-auto">
				<a href="javascript:void(0);" data-id="modal-participantes-crear" class="open-modal rounded-full bg-pink-600 text-white px-5 py-2 block">
					Agregar
				</a>
			</div>
			<div class="ml-2">
				<a href="{{ route('votaciones.index') }}" class="rounded-full bg-gray-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white">
				<div class="p-6 bg-white border border-white">
					@if ($errors->any())
					<div class="mb-5">
						<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
					</div>
					@endif
					@if (session('success'))
					<div class="mb-5">
						<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
					</div>
					@endif
					<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg flex-nowrap !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 !text-center">ID</th>
								<th class="p-3 !text-center">Imagen</th>
								<th class="p-3 !text-center">Nombre</th>
								<th class="p-3 !text-center">Vídeo</th>
								<th class="p-3 !text-center">Activo</th>
								<th class="p-3 !text-center">Finalista</th>
								<th class="p-3 !text-center">Votos</th>
								<th class="p-3 !text-center" style="min-width: 100px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($votacion->participantes as $participante)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $participante->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<img src="{{ asset('storage/'.$participante->imagen) }}" class="img-general inline-block object-cover w-20 h-auto">
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $participante->user->name }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center break-all">
									<div class="edit-inline-text" data-id="{{ $participante->id }}" data-campo="link">{{ $participante->link }}</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="activa_{{ $participante->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="activa_{{ $participante->id }}" name="activa_{{ $participante->id }}" data-id="{{ $participante->id }}" data-campo="activa" type="checkbox" class="update-votacion sr-only" @if($participante->activa) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="finalista_{{ $participante->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="finalista_{{ $participante->id }}" name="finalista_{{ $participante->id }}" data-id="{{ $participante->id }}" data-campo="finalista" type="checkbox" class="update-votacion sr-only" @if($participante->finalista) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $participante->votos }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<form action="{{ route('votaciones.participantes.destroy', ['participante' => $participante->id]) }}" method="POST" class="inline delete-form">
										@csrf
										@method('DELETE')
										<button type="submit" class="text-red-400 hover:text-red-600 delete-form"><i class="fa fa-trash"></i></button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--Modal  opacity-0 pointer-events-none-->
	<form action="{{ route('votaciones.participantes.store', ['votacione' => $votacion->id]) }}" name="cliente-form" method="POST" enctype="multipart/form-data">
		@csrf
		<div id="modal-participantes-crear" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
			<div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
			<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
				<!-- Add margin if you want to see some of the overlay behind the modal-->
				<div class="modal-content py-4 text-left px-6">
					<!--Title-->
					<div class="flex justify-between items-center pb-3">
						<p class="text-2xl font-bold">Agregar participante</p>
						<div class="modal-close cursor-pointer z-50">
							<svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
								<path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
							</svg>
						</div>
					</div>
					<!--Body-->
					<div class="w-3/6 mx-auto px-3 text-center">
						<div>
							<label class="block tracking-wide text-gray-700 font-bold" for="logo">
								Imagen
							</label>
							<img src="{{ asset('images/1000x1000.png') }}" class="img-general object-cover w-100 border border-secondary">
							<div class="text-center mt-3">
								<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
								<div class="examinar-size text-xs mt-2 text-gray-400">(1000x1000px)</div>
							</div>
							<input name="imagen" id="imagen" type="file" class="file-general" accept="image/*" style="display: none">
						</div>
					</div>
					<div class="mt-4">
						<input class="!shadow appearance-none !placeholder-gray-500 !rounded-none !border !border-blue-500 !w-full py-2 px-3 !text-gray-700" name="autoComplete" id="autoComplete" type="text" placeholder="Nombre del participante" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="2048" tabindex="1">
					</div>
					<div class="mt-4">
						<input class="shadow appearance-none border border-blue-500 w-full py-2 px-3 text-gray-700" name="link" id="link" type="url" placeholder="Link del vídeo" required>
					</div>
					<div class="mt-4">
						<select class="shadow appearance-none border border-blue-500 w-full py-2 px-3 text-gray-700" name="categoria_id" id="categoria_id" required>
							<option value="">Seleccionar categoría</option>
							@foreach ($categorias as $categoria)
							<option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
							@endforeach
						</select>
					</div>
					<div class="mt-4">
						<div>
							<input type="checkbox" name="activa" id="activa" value="on" checked>
							<label for="activa" class="inline-block">Activo</label>
						</div>
					</div>
					<div class="mt-4">
						<div>
							<input type="checkbox" name="finalista" id="finalista" value="on">
							<label for="finalista" class="inline-block">Finalista</label>
						</div>
					</div>
					<input type="hidden" name="user_id" id="user_id" value="0">
					<!--Footer-->
					<div class="flex justify-end pt-4">
						<button class="rounded-full bg-pink-600 text-white px-5 py-2 block">Enviar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	@section('js')
	<style>
		@media (min-width: 640px) {
			table {
				display: inline-table !important;
			}

			thead tr:not(:first-child) {
				display: none;
			}
		}

		td:not(:last-child) {
			border-bottom: 0;
		}

		th:not(:last-child) {
			border-bottom: 2px solid rgba(0, 0, 0, .1);
		}
	</style>
	<script type="text/javascript" src="https://unpkg.com/@popperjs/core@2"></script>
	<script>
		const url = '{{ url('dashboard/votaciones/participantes') }}';
		const url_search = '{{ route('votaciones.participantes.search', ['votacione' => $votacion->id]) }}';
		window.addEventListener('load', function() {
			const inlineEditElements = document.querySelectorAll('.edit-inline-text')
			inlineEditElements.forEach(element => {
				console.log(element)
				Flyter.attach(element, {
					initialValue: element.innerHTML,
					emptyValueDisplay: 'Escribe el valor del campo...',
					submitOnEnter: true,
					type: { name: 'text' },
					onSubmit: async function(valor) {
						const formdata = new FormData()
						formdata.append($(element).data('campo'), valor)
						$.ajax({
							url: `${url}/${$(element).data('id')}/atributo`,
							type: "POST",
							method: 'POST',
							data: formdata,
							cache: false,
							processData: false,
							contentType: false
						}).done(function(data) {
							console.log(data);
							return true
						}).fail(function() {
							Swal.fire( "error" );
						});
					}
				})
			})
			const autoCompleteJS = new autoComplete({
				selector: "#autoComplete",
				placeHolder: "Buscar por nombre, id, email...",
				threshold: 4,
				searchEngine: 'loose', // strict or loose
				data: {
					src: async (query) => {
						try {
							result = await $.ajax({
								url: url_search,
								type: 'POST',
								data: {q: query},
							})
							return result.data
						} catch (error) {
							console.error(error)
							return []
						}
					},
					keys: ["name", "email", "id"],
					cache: false,
				},
				resultsList: {
					element: (list, data) => {
						if (!data.results.length) {
							// Create "No Results" message element
							const message = document.createElement("div");
							// Add class to the created element
							message.setAttribute("class", "no_result");
							// Add message text content
							message.innerHTML = `<span>No encontramos resultados para "${data.query}"</span>`;
							// Append message element to the results list
							list.prepend(message);
						}
					},
					noResults: true,
					maxResults: 15,
    			tabSelect: true
				},
				resultItem: {
					highlight: true,
				}
			})
			autoCompleteJS.input.addEventListener("selection", function (event) {
				const feedback = event.detail;
				console.log(event, feedback.selection.value)
				$('input#autoComplete').val(feedback.selection.value.name);
				$('input#user_id').val(feedback.selection.value.id);
			})
			$('body').on('click', 'button.examinar-btn', function (e) {
				e.preventDefault();
				console.log('click')
				$(this).parent().parent().find('input[type=file]').trigger('click');
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
			$('table#usuarios').DataTable({
				paging: true,
				searching: true,
				ordering:  true,
				responsive: true,
				pageLength: 25,
				columnDefs: [
					{ responsivePriority: 1, targets: 0 },
					{ responsivePriority: 2, targets: 1 },
					{ responsivePriority: 3, targets: 2 }
        ],
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
				}
			});
			$('.update-votacion').change(function(){
				const formdata = new FormData()
				formdata.append($(this).data('campo'), $(this).prop('checked'))
				$.ajax({
					url: `${url}/${$(this).data('id')}/atributo`,
					type: "POST",
					method: 'POST',
					data: formdata,
					cache: false,
					processData: false,
					contentType: false
				}).done(function(data) {
					console.log(data);
				}).fail(function() {
					Swal.fire( "error" );
				});
			});
			$('form.delete-form button').on('click', function(e) {
				e.preventDefault();
				console.log('delete?')
				const $form = $(this).parent();
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Una ves que elimines el participante no podrás recuperar la información.",
					icon: null,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'SI, eliminarla',
					cancelButtonText: 'Cancelar',
					allowOutsideClick: false,
				}).then((result) => {
					if (result.isConfirmed) {
						$form.submit();
					}
				})
			});
		});
	</script>
	@endsection
</x-app-layout>
