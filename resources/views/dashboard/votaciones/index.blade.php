<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Votaciones
				</h2>
			</div>
			<div class="ml-auto">
				<a href="javascript:void(0);" data-id="modal-votacion-crear" class="open-modal rounded-full bg-pink-600 text-white px-5 py-2 block">
					Crear
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
								<th class="p-3 !text-center">Concurso</th>
								<th class="p-3 !text-center">Cliente</th>
								<th class="p-3 !text-center">Activa</th>
								<th class="p-3 !text-center">Votar</th>
								<th class="p-3 !text-center">Finalistas</th>
								<th class="p-3 !text-center">Categorías</th>
								<th class="p-3 !text-center">Participantes</th>
								<th class="p-3 !text-center" style="min-width: 100px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($votaciones as $votacion)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $votacion->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="edit-inline-text" data-id="{{ $votacion->id }}" data-campo="nombre">{{ $votacion->nombre }}</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ route('cliente', ['slug' => $votacion->cliente->slug]) }}" target="_blank">
										<img src="{{ asset('storage/'.$votacion->cliente->logo) }}" class="img-general inline-block object-cover w-20 h-auto">
									</a>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="activa_{{ $votacion->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="activa_{{ $votacion->id }}" name="activa_{{ $votacion->id }}" data-id="{{ $votacion->id }}" data-campo="activa" type="checkbox" class="update-votacion sr-only" @if($votacion->activa) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="votar_{{ $votacion->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="votar_{{ $votacion->id }}" name="votar_{{ $votacion->id }}" data-id="{{ $votacion->id }}" data-campo="votar" type="checkbox" class="update-votacion sr-only" @if($votacion->votar) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
											{{--
											<div class="ml-3 text-gray-700 font-medium">
												Votar
											</div> --}}
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="finalistas_{{ $votacion->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="finalistas_{{ $votacion->id }}" name="finalistas_{{ $votacion->id }}" data-id="{{ $votacion->id }}" data-campo="finalistas" type="checkbox" class="update-votacion sr-only" @if($votacion->finalistas) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $votacion->categorias->count() }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $votacion->participantes->count() }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ route('votaciones.categorias', ['votacione' => $votacion->id]) }}" class="text-sky-400 hover:text-sky-600"><i class="fas fa-list-ul"></i></a>
									<a href="{{ route('votaciones.participantes', ['votacione' => $votacion->id]) }}" class="text-purple-400 hover:text-purple-600"><i class="fas fa-users"></i></a>
									<form action="{{ route('votaciones.destroy', ['votacione' => $votacion->id]) }}" method="POST" class="inline delete-form">
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
	<form action="{{ route('votaciones.store') }}" name="cliente-form" method="POST" enctype="multipart/form-data">
		@csrf
		<div id="modal-votacion-crear" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
			<div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
			<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
				<!-- Add margin if you want to see some of the overlay behind the modal-->
				<div class="modal-content py-4 text-left px-6">
					<!--Title-->
					<div class="flex justify-between items-center pb-3">
						<p class="text-2xl font-bold">Crear votación</p>
						<div class="modal-close cursor-pointer z-50">
							<svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
								<path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
							</svg>
						</div>
					</div>
					<!--Body-->
					<div>
						<input class="shadow appearance-none border border-blue-500 w-full py-2 px-3 text-gray-700" name="nombre" id="nombre" type="text" placeholder="Nombre del concurso" required>
					</div>
					<div class="mt-4">
						<select class="shadow appearance-none border border-blue-500 w-full py-2 px-3 text-gray-700" name="cliente_id" id="cliente_id" required>
							<option value="">Seleccionar cliente</option>
							@foreach ($clientes as $cliente)
							<option value="{{ $cliente->id }}">{{ $cliente->cliente }}</option>
							@endforeach
						</select>
					</div>
					<div class="mt-4">
						<div>
							<input type="checkbox" name="activa" id="activa" value="on">
							<label for="activa" class="inline-block">Activa</label>
						</div>
						<div>
							<input type="checkbox" name="votar" id="votar" value="on">
							<label for="votar" class="inline-block">Permitir votar</label>
						</div>
						<input type="hidden" name="finalistas" value="0">
					</div>
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
	<script>
		const url = '{{ url('dashboard/votaciones') }}';
		window.addEventListener('load', function() {
			const inlineEditElements = document.querySelectorAll('.edit-inline-text')
			inlineEditElements.forEach(element => {
				Flyter.attach(element, {
					initialValue: element.innerHTML,
					emptyValueDisplay: 'Escribe el valor del campo...',
					submitOnEnter: true,
					type: { name: 'text' },
					okButton: {enabled: true,text: 'Guardar'},
					cancelButton: {enabled: true,text: 'Cancelar'},
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
					text: "Una ves que elimines la votación no podrás recuperar la información.",
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
