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

					<form action="{{ route('clientes.search') }}" method="GET">
						@csrf
						<div id="buscar" class="text-gray-500 flex flex-row relative items-center w-full lg:w-1/3 lg:ml-auto lg:max-w-xs mb-10">
							<div><button type="submit"><i class="fa fa-search text-xl"></i></button></div>
							<div class="ml-2 grow">
								<input type="text" name="q" value="{{ $q }}" class="border-l-0 border-t-0 border-r-0 w-full focus:ring-black !border-gray-500" placeholder="Buscar cliente">
							</div>
						</div>
					</form>
					<div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-1 md:gap-5 pb-5 md:pb-10">
						@foreach($clientes as $cliente)
						<x-cliente @delete-cliente.window="title = $event.detail" :id="$cliente->id" :name="$cliente->cliente" :slug="$cliente->slug" :logo="asset('storage/'.$cliente->logo)" />
						@endforeach
					</div>
					<div class="flex flex-col justify-center items-center mb-10">
						<a href="{{ route('clientes.create') }}" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center items-center p-5 text-xs lg:text-base w-[6rem] h-[6rem] lg:w-[9rem] lg:h-[9rem]">
							<div class="text-2xl lg:text-5xl font-bold">+</div>
							<div>Agregar</div>
							<div>cliente</div>
						</a>
					</div>
					<div class="flex flex-col items-center justify-center">
						{{ $clientes->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
	@section('js')
		<script>
			document.addEventListener('DOMContentLoaded', function load() {
    		if (!window.jQuery) return setTimeout(load, 50);
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
