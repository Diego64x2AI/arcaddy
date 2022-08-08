<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Producto digital | {{ $producto->cliente->cliente }}
		</h2>
	</x-slot>
	<div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
		<a href="{{ route('clientes.edit', ['cliente' => $producto->cliente_id]) }}" class="text-sky-500">Regresar</a>
	</div>
	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white">
				@if ($errors->any())
				<div class="my-5">
					<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
				</div>
				@endif
				@if (session('success'))
				<div class="my-5">
					<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
				</div>
				@endif
				<div class="my-5">
					<div class="relative w-full text-center p-4 text-white bg-lime-500 rounded-lg">Utiliza la siguiente URL para compartir el cupón:</div>
				</div>
				<div class="my-5 text-center">
					<a href="{{ route('digital_share', ['cupon' => $cupon->id]) }}" target="_blank">{{ route('digital_share', ['cupon' => $cupon->id]) }}</a>
				</div>
				{{--
				<div class="text-center my-5">
					<img src="{{ asset("storage/qrcodes/{$cupon->id}.png") }}" class="object-cover w-100 h-auto max-w-sm border border-secondary inline-block">
				</div>
				--}}
			</div>
		</div>
	</div>
</x-app-layout>
