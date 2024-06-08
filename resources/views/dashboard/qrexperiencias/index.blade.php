<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					QR´s Experiencias
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.qrexperiencias.create', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
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
				<div class="text-center font-semibold">
					{{ $cliente->cliente }}
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
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
						@foreach ($experiencias as $qrexperiencia)
						<div class="p-4 hover:bg-gray-50 shadow">
							<div>
								<img src="{{ asset("storage/qrexperiencias/{$qrexperiencia->id}.png") }}" class="w-full h-autos shadows">
							</div>
							<div class="text-center mt-2">
								<span class="font-bold color text-pink-600">{{ $qrexperiencia->visitas }}</span> Lecturas
							</div>
							<div class="text-center mt-2 font-bold">
								{{ $qrexperiencia->titulo }}
							</div>
							<div class="grid grid-cols-4 items-center justify-center gap-2 mt-2">
								<div class="flex flex-row items-center justify-center">
									<a href="{{ asset('storage/qrexperiencias/'.$qrexperiencia->id.'.png?'.time()) }}" download="qr-{{ $qrexperiencia->id }}" target="_blank"><i class="fa fa-qrcode"></i></a>
								</div>
								<div class="flex flex-row items-center justify-center">
									<a href="{{ route('cliente.qrexperiencias.edit', ['cliente' => $cliente->id, 'qrexperiencia' => $qrexperiencia->id]) }}"><i class="fa fa-edit"></i></a>
								</div>
								<div class="flex flex-row items-center justify-center">
									<a href="https://www.google.com/maps/search/?api=1&query={{ $qrexperiencia->lat }},{{ $qrexperiencia->lng }}" target="_blank"><i class="fa fa-map-marker"></i></a>
								</div>
								<div class="flex flex-row items-center justify-center">
									<form action="{{ route('cliente.qrexperiencias.destroy', ['cliente' => $cliente->id, 'qrexperiencia' => $qrexperiencia->id]) }}" method="POST" class="delete-form">
										@csrf
										@method('DELETE')
										<button class="">
											<i class="fa fa-trash-alt"></i>
										</button>
									</form>
								</div>
							</div>
						</div>
						@endforeach
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
					text: "Una ves que elimines el QR no podrás recuperar la información.",
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
