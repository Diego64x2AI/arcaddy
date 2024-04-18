<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Usuarios
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('usuarios.export', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Exportar
				</a>
			</div>
			@if ($cliente->id !== NULL && $cliente->id === 99699999)
			<div class="ml-3">
				<a href="{{ route('usuarios.import', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Importar
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
					<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 !text-center">ID</th>
								<th class="p-3 !text-center">Nombre</th>
								<th class="p-3 !text-center">Email</th>
								@foreach ($fields as $field)
								<th class="p-3 !text-center">{{ $field->nombre  }}</th>
								@endforeach
								<th class="p-3 !text-center">Fecha de registro</th>
								<th class="p-3 !text-center" width="110px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							{{--
							@foreach ($usuarios as $usuario)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->name }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->email }}</td>
								@foreach ($fields as $field)
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
								    @if($field->campo_id != 4)
								    {{ ($usuario->campos()->where('campo_id', $field->campo_id)->first() !== null) ? $usuario->campos()->where('campo_id', $field->campo_id)->first()->valor : '' }}
								    @else
								    	{{ $usuario->nacimiento }}
								    @endif
								</td>
								@endforeach
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->created_at }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">

									<a href="{{ route('pedidos.destroy', ['pedido' => $usuario->id]) }}" class="text-red-400 hover:text-red-600 delete-form"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
							--}}
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
				ajax: "{{ route('usuarios.ajax', ['cliente' => $cliente->id]) }}",
				columns: [
					{data: 'id', name: 'id'},
					{data: 'name', name: 'name', orderable: true, searchable: true},
					{data: 'email', name: 'email', orderable: true, searchable: true},
					@foreach ($fields as $field)
					{data: 'campo_{{ $field->campo_id }}', name: 'campo_{{ $field->campo_id }}', orderable: true, searchable: true},
					@endforeach
					{data: 'created_at', name: 'created_at', orderable: false, searchable: false, orderable: true, searchable: true},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				],
				paging: true,
				searching: true,
				ordering:  true,
				pageLength: 10,
				language: {
					url: '{{ asset("es-ES.json") }}'
				},
				search: {
        	"regex": true
      	}
			});
			$('.dataTables_filter input')
       .off()
       .on('keyup', function() {
          table.draw();
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
