<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					QR´s Sección
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.qrlinks.create', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
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
								<th class="p-3 !text-center">QR</th>
								<th class="p-3 !text-center">Título</th>
								<th class="p-3 !text-center">Botón Texto</th>
								<th class="p-3 !text-center">Botón Link</th>
								<th class="p-3 !text-center">Banners</th>
								<th class="p-3 !text-center">Lecturas</th>
								<th class="p-3 !text-center" style="min-width: 100px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($links as $link)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $link->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ asset('storage/qrcodes_secciones/'.$link->slug.'.png?'.time()) }}" download="qr-{{ $link->slug }}" target="_blank" title="Código QR">
										<img src="{{ asset('storage/qrcodes_secciones/'.$link->slug.'.png?'.time()) }}" alt="Código QR" class="w-20 h-auto inline-block">
									</a>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									{{ $link->titulo }}
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									{{ $link->boton_texto }}
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ $link->boton_link }}" target="_blank" title="Botón Link">{{ $link->boton_link }}</a>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									{{ $link->banners2->count() }}
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									{{ $link->lecturas }}
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ route('cliente_seccion', ['slug' => $link->cliente->slug, 'slug2' => $link->slug]) }}" class="text-black" target="_blank"><i class="fas fa-link"></i></a>
									<a href="{{ route('cliente.qrlinks.edit', ['cliente' => $cliente->id, 'qrlink' => $link->id]) }}" class="text-black"><i class="fas fa-edit"></i></a>
									<form action="{{ route('cliente.qrlinks.destroy', ['cliente' => $cliente->id, 'qrlink' => $link->id]) }}" method="POST" class="inline delete-form">
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
					{ responsivePriority: 3, targets: -1 }
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
					window.location.reload();
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
					text: "Una ves que elimines el rally no podrás recuperar la información.",
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
