<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Pedidos
		</h2>
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
					<table class="w-full rounded-lg overflow-hidden sm:shadow-lg my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 text-center">ID</th>
								<th class="p-3 text-center">ID de pago</th>
								<th class="p-3 text-center">Estado</th>
								<th class="p-3 text-center">Usuario</th>
								<th class="p-3 text-center">Total</th>
								<th class="p-3 text-center">Pagado</th>
								<th class="p-3 text-center">Fecha de pago</th>
								<th class="p-3 text-center">Fecha de pedido</th>
								<th class="p-3 text-center" width="110px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pedidos as $pedido)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $pedido->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $pedido->payment_id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									@if ($pedido->status === 'succeeded')
									<span class="bg-lime-500 text-white px-3 py-2 rounded-md">Pagado</span>
									@else
									<span class="bg-red-500 text-white px-3 py-2 rounded-md">Sin pagar</span>
									@endif
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $pedido->user->name }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">${{ number_format($pedido->total, 2) }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">${{ number_format($pedido->recibido, 2) }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $pedido->payed_at ?? '--' }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $pedido->created_at ?? '--' }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">

									<a href="{{ route('pedidos.destroy', ['pedido' => $pedido->id]) }}" class="text-red-400 hover:text-red-600 delete-form"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div>
						{{ $pedidos->links() }}
					</div>
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
		window.addEventListener('load', function() {
				$('a.delete-form').on('click', function(e) {
					e.preventDefault();
					console.log('delete?')
					const $a = $(this);
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Una ves que elimines el pedido no podrás recuperar la información.",
						icon: null,
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, eliminarla',
						cancelButtonText: 'Cancelar',
						allowOutsideClick: false,
					}).then((result) => {
						if (result.isConfirmed) {
							window.top.location.href = $a.attr('href');
						}
					})
				});
			});
	</script>
	@endsection
</x-app-layout>
