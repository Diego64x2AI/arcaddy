<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Clientes
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
					{{--
					<div class="overflow-x-auto relative sm:rounded-lg">
						<table id="clientes" class="w-full text-sm text-left border text-gray-500 dark:text-gray-400">
							<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
								<tr>
									<th class="p-3 !text-center">QR</th>
									<th class="p-3 !text-center">Cliente</th>
									<th class="p-3 !text-center">Link</th>
									<th class="p-3 !text-center">Registro Personalizado</th>
									<th class="p-3 !text-center" width="110px">Opciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($clientes as $cliente)
								<tr class="bg-white border-b hover:bg-gray-50">
									<td class="p-3 text-center"><img src="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}" class="inline-block" style="height: 40px; width: auto;"></td>
									<td class="p-3 text-center">
										<img src="{{ asset('storage/'.$cliente->logo) }}" class="inline-block" style="height: 30px; width: auto;">
									</td>
									<td class="p-3 text-center">
										<a href="{{ url("/{$cliente->slug}") }}" target="_blank">{{ \Request::server ("HTTP_HOST") }}/<span class="font-bold">{{ $cliente->slug }}</span></a>
									</td>
									<td class="p-3 text-center">
										@if ($cliente->registro)
										<span class="bg-lime-500 text-white px-3 py-2 rounded-md">SI</span>
										@else
										<span class="bg-red-500 text-white px-3 py-2 rounded-md">NO</span>
										@endif
									</td>
									<td class="p-3 text-center text-xl">
										<a href="{{ route('clientes.edit', ['cliente' => $cliente->id]) }}" class="text-sky-500"><i class="fa fa-edit"></i></a>
										<form action="{{ route('clientes.destroy', ['cliente' => $cliente->id]) }}" method="POST" class="inline delete-form">
											@csrf
											@method('DELETE')
											<button href="{{ route('clientes.destroy', ['cliente' => $cliente->id]) }}" type="button" class="text-red-500">
												<i class="fas fa-trash-alt"></i>
											</button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					--}}
					<div>
						{{ $clientes->links() }}
					</div>
					<div class="grid grid-cols-1 md:grid-cols-5 gap-5">
						@foreach($clientes as $cliente)
						<x-cliente @delete-cliente.window="title = $event.detail" :id="$cliente->id" :name="$cliente->cliente" :slug="$cliente->slug" :logo="asset('storage/'.$cliente->logo)" />
						@endforeach
						<div class="flex flex-col justify-center items-center">
							<a href="{{ route('clientes.create') }}" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center items-center p-5 w-[9rem] h-[9rem]">
								<div class="text-5xl font-bold">+</div>
								<div>Agregar</div>
								<div>cliente</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@section('js')
		<script>
			document.addEventListener('DOMContentLoaded', function load() {
    		if (!window.jQuery) return setTimeout(load, 50);
				/*
				$('table#clientes').DataTable({
					paging: true,
					searching: true,
    			ordering:  true,
					serverSide: true,
  				ajax: 'xhr.php',
					language: {
            url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
        	}
				});
				*/
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
