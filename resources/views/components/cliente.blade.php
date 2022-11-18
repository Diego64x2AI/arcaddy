@props(['name', 'slug', 'logo', 'id'])

<div {{ $attributes->merge(['class' => 'flex flex-col justify-center p-4 items-center border-b mb-5 md:border-b-0 md:border-r border-gray-700']) }}>
	<div><img src="{{ $logo }}" class="block h-15 w-auto fill-current" alt="{{ $name }}"></div>
	<div class="uppercase font-bold text-base mt-4">
		{{ $name }}
		<a href="{{ route('usuarios.index', ['cliente' => $id]) }}" class="text-purple-500"><i class="fa fa-user"></i></a>
		<a href="{{ route('clientes.edit', ['cliente' => $id]) }}" class="text-sky-500"><i class="fa fa-edit"></i></a>
		<form action="{{ route('clientes.destroy', ['cliente' => $id]) }}" method="POST" class="inline delete-form">
			@csrf
			@method('DELETE')
			<button href="{{ route('clientes.destroy', ['cliente' => $id]) }}" type="button" wire:click="$emit('confirmDelete')" class="text-red-500">
				<i class="fas fa-trash-alt"></i>
			</button>
		</form>
	</div>
	<div class="mt-3">
		<a href="{{ url("/{$slug}") }}" target="_blank">ar-caddy/<span class="font-bold">{{ $slug }}</span></a>
	</div>
	<div class="mt-2">
		<a href="{{ asset('storage/qrcodes/'.$slug.'.png?'.time()) }}" target="_blank" class="rounded-full bg-pink-600 text-white px-5 py-2 block">Descargar QR</a>
	</div>
</div>
