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
