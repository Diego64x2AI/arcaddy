<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Galerías de Marcos
				</h2>
			</div>
			@if (!$compartida)
			<div class="ml-auto">
				<a href="{{ route('cliente.galerias.index', ['cliente' => $cliente->id, 'compartida' => 1]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Compartidas
				</a>
			</div>
			@else
			<div class="ml-auto">
				<a href="{{ route('cliente.galerias.index', ['cliente' => $cliente->id, 'compartida' => 0]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Enviadas
				</a>
			</div>
			@endif
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
					<div class="text-center mb-5">
						<img src="{{ asset('storage/'.$cliente->logo) }}" class="img-general inline-block object-cover max-w-xs">
					</div>
					<div class="flex flex-col md:flex-row items-center justify-center gap-5 mb-5">
						<div>
							<a href="{{ route('cliente.galerias.zip', ['cliente' => $cliente->id]) }}" class="rounded-full bg-sky-600 text-white px-5 py-2 block">
								<i class="fa fa-download"></i> Descargar todo
							</a>
						</div>
						<div>
							<a href="{{ route('cliente.galerias.delete-all', ['cliente' => $cliente->id]) }}" class="delete-all rounded-full bg-red-600 text-white px-5 py-2 block">
								<i class="fa fa-trash"></i> Eliminar todo
							</a>
						</div>
					</div>
					<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 !text-center">ID</th>
								<th class="p-3 !text-center">Imagen</th>
								<th class="p-3 !text-center">Usuario</th>
								@if (!$compartida)
								<th class="p-3 !text-center">Aprobada</th>
								@endif
								<th class="p-3 !text-center" width="110px">Opciones</th>
							</tr>
						</thead>
						<tbody>

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
		td {
			text-align: center;
		}
		td:not(:last-child) {
			border-bottom: 0;
		}
		th:not(:last-child) {
			border-bottom: 2px solid rgba(0, 0, 0, .1);
		}
	</style>
	<script>
		window.addEventListener('load', function() {
			const table = $('table#usuarios').DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				ajax: {
					url: "{{ route('cliente.galerias.ajax', ['cliente' => $cliente->id]) }}",
					data: {
						compartida: {{ $compartida ? 'true' : 'false'}}
					}
				},
				columns: [
					{data: 'id', name: 'id'},
					{data: 'archivo', name: 'archivo', orderable: false, searchable: false},
					{data: 'user_id', name: 'user_id', orderable: true, searchable: true},
					@if (!$compartida)
					{data: 'aprobada', name: 'aprobada', orderable: true, searchable: true},
					@endif
					{data: 'action', name: 'action', orderable: false, searchable: false},
				],
				paging: true,
				searching: false,
				ordering:  true,
				order: [[3, 'desc']],
				pageLength: 50,
				language: {
					url: '{{ asset("es-ES.json") }}'
				},
				search: {
        	"regex": true
      	}
			});
			const url = '{{ url('dashboard/cliente/'.$cliente->id.'/galerias') }}';
			$('body').on('change', '.update-aprobada', function(e) {
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
			$('body').on('click', '.delete-all', function(e) {
				e.preventDefault();
				Swal.fire({
					title: '¿Estás seguro?',
					text: "¡No podrás revertir esto!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '¡Sí, eliminar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = $(this).attr('href');
					}
				})
			});
			$('body').on('click', '.regalar-beneficio', function(e) {
				e.preventDefault();
				var form = $(this).parents('form');
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Estás a punto de regalar un beneficio.",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '¡Sí, regalar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						window.top.location = $(this).attr('href');
					}
				})
			});
			$('body').on('click', '.delete-item', function(e) {
				e.preventDefault();
				var form = $(this).parents('form');
				Swal.fire({
					title: '¿Estás seguro?',
					text: "¡No podrás revertir esto!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '¡Sí, eliminar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						form.submit();
					}
				})
			});
		});
	</script>
	@endsection
</x-app-layout>
