<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Cupones
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
								<th class="p-3 text-center">Estado</th>
								<th class="p-3 text-center">Fecha de canje</th>
								<th class="p-3 text-center">Producto</th>
								<th class="p-3 text-center" width="110px">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($cupones as $cupon)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $cupon->id }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									@if ($cupon->canjeado)
									<span class="bg-lime-500 text-white px-3 py-2 rounded-md">Canjeado</span>
									@else
									<span class="bg-red-500 text-white px-3 py-2 rounded-md">Sin canjeado</span>
									@endif
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $cupon->canjeado_at ?? '--' }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<img src="{{ asset('storage/'.$cupon->producto->imagenes[0]->archivo) }}" alt="{{ $cupon->producto->imagenes[0]->titulo }}" class="object-fill w-10 h-auto inline-block">
									{{ $cupon->producto->nombre }}
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ route('digital_share', ['cupon' => $cupon->id]) }}" target="_blank" class="mr-2 text-purple-400 hover:text-purple-600"><i class="fa fa-qrcode"></i></a>
									<a href="{{ route('cupones.destroy', ['cupon' => $cupon->id]) }}" class="text-red-400 hover:text-red-600"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div>
						{{ $cupones->links() }}
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
				$('form.delete-form button').on('click', function(e) {
					e.preventDefault();
					console.log('delete?')
					const $form = $(this).parent();
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Una ves que eliminar el cliente no podrás recuperar la información.",
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
