<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Quiz
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
				<div class="text-center">
					<img src="{{ asset('storage/'.$cliente->logo) }}" alt="{{ $cliente->cliente }}" class="inline-block w-full h-auto max-w-xs">
				</div>
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
								<th class="p-3 !text-center">Nombre</th>
								<th class="p-3 !text-center">Activa</th>
								<th class="p-3 !text-center">Score</th>
								<th class="p-3 !text-center">Random</th>
								<th class="p-3 !text-center">Calificación</th>
								<th class="p-3 !text-center" style="min-width: 100px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($cliente->quiz as $quiz)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $quiz->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="edit-inline-text" data-id="{{ $quiz->id }}" data-campo="nombre">{{ $quiz->nombre }}</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="activa_{{ $quiz->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="activa_{{ $quiz->id }}" name="activa_{{ $quiz->id }}" data-id="{{ $quiz->id }}" data-campo="activa" type="checkbox" class="update-quiz sr-only" @if($quiz->activa) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="score_{{ $quiz->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="score_{{ $quiz->id }}" name="score_{{ $quiz->id }}" data-id="{{ $quiz->id }}" data-campo="score" type="checkbox" class="update-quiz sr-only" @if($quiz->score) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="random_{{ $quiz->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="random_{{ $quiz->id }}" name="random_{{ $quiz->id }}" data-id="{{ $quiz->id }}" data-campo="random" type="checkbox" class="update-quiz sr-only" @if($quiz->random) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<div class="flex items-center justify-center w-full mb-2">
										<label for="calificacion_{{ $quiz->id }}" class="flex items-center cursor-pointer">
											<div class="relative">
												<input id="calificacion_{{ $quiz->id }}" name="calificacion_{{ $quiz->id }}" data-id="{{ $quiz->id }}" data-campo="calificacion" type="checkbox" class="update-quiz sr-only" @if($quiz->calificacion) checked @endif />
												<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
												<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
											</div>
										</label>
									</div>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ route('cliente.quiz.edit', ['cliente' => $cliente->id, 'quiz' => $quiz->id]) }}" class="text-black"><i class="fas fa-edit"></i></a>
									<form action="{{ route('cliente.quiz.destroy', ['cliente' => $cliente->id, 'quiz' => $quiz->id]) }}" method="POST" class="inline delete-form">
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
	<form action="{{ route('cliente.quiz.store', ['cliente' => $cliente->id]) }}" name="cliente-form" method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
		<div id="modal-votacion-crear" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
			<div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
			<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
				<!-- Add margin if you want to see some of the overlay behind the modal-->
				<div class="modal-content py-4 text-left px-6">
					<!--Title-->
					<div class="flex justify-between items-center pb-3">
						<p class="text-2xl font-bold">Crear quiz</p>
						<div class="modal-close cursor-pointer z-50">
							<svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
								<path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
							</svg>
						</div>
					</div>
					<!--Body-->
					<div>
						<input class="shadow appearance-none border border-blue-500 w-full py-2 px-3 text-gray-700" name="nombre" id="nombre" type="text" placeholder="Nombre del quiz" required>
					</div>
					<div class="mt-4">
						<div>
							<input type="checkbox" name="activa" id="activa" class="accent-pink-600 appearance-none" value="on">
							<label for="activa" class="inline-block">Activa</label>
						</div>
						<div class="mt-1">
							<input type="checkbox" name="score" id="score" value="on">
							<label for="score" class="inline-block">Score</label>
						</div>
						<div class="mt-1">
							<input type="checkbox" name="random" id="random" value="on">
							<label for="random" class="inline-block">Random</label>
						</div>
						<div class="mt-1">
							<input type="checkbox" name="calificacion" id="calificacion" value="on">
							<label for="calificacion" class="inline-block">Calificación</label>
						</div>
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
		const url = '{{ url('dashboard/cliente/'.$cliente->id.'/quiz') }}';
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
					url: '{{ asset("es-ES.json") }}'
				}
			});
			$('.update-quiz').change(function(){
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
						$form.submit();
					}
				})
			});
		});
	</script>
	@endsection
</x-app-layout>
