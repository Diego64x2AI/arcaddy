@props(['name', 'slug', 'logo', 'id'])

<div {{ $attributes->merge(['class' => 'flex flex-row items-center border-b py-2 md:py-3 border-gray-700']) }}>
	<div class="w-1/3 flex flex-row justify-center items-center">
		<a href="{{ url("/{$slug}") }}" target="_blank" class="text-sm font-bold inline-block">
			<img src="{{ $logo }}" class="h-auto w-full md:w-16" alt="{{ $name }}">
		</a>
	</div>
	<div class="ml-2 w-2/3">
		<div class="mb-2 truncate">
			<a href="{{ url("/{$slug}") }}" target="_blank" class="text-sm font-bold">{{ $name }}</a>
		</div>
		<div class="flex flex-row justify-evenly items-center gap-3">
			<div>
				<a href="{{ asset('storage/qrcodes/'.$slug.'.png?'.time()) }}" download="qr-{{ $slug }}" target="_blank"><i class="fa fa-qrcode"></i></a>
			</div>
			<div>
				<a href="{{ route('clientes.edit', ['cliente' => $id]) }}"><i class="fa fa-edit"></i></a>
			</div>
			<div>
				<a href="{{ route('usuarios.index', ['cliente' => $id]) }}"><i class="fa fa-users"></i></a>
			</div>
			<div>
				<a href=""><i class="fa fa-chart-line"></i></a>
			</div>
			<div>
				<a href="{{ route('cliente.quiz.index', ['cliente' => $id]) }}"><i class="fa fa-question-circle"></i></a>
			</div>
			<div>
				<form action="{{ route('clientes.destroy', ['cliente' => $id]) }}" method="POST" class="delete-form m-0 b-0">
					@csrf
					@method('DELETE')
					<button href="{{ route('clientes.destroy', ['cliente' => $id]) }}" type="button" wire:click="$emit('confirmDelete')">
						<i class="fa fa-trash-alt"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
