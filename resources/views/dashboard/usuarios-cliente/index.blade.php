<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Administrador cliente
				</h2>
			</div>
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
						
					</div>

					<a href="{{route('usuarios-cliente.create')}}" class="bg-pink-600 text-white px-5 py-2 rounded-md" style="float: right;">Nuevo</a>

					<form method="GET" action="{{route('usuarios-cliente.index')}}">
						<select name="cliente">
                        <option value="0" >Cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{$cliente->id}}" 
                            	{{(isset($parametros['cliente']) && $parametros['cliente'] == $cliente->id)?'selected':''}}>{{$cliente->cliente}} </option>
                        @endforeach
                    	</select>
                    	<button type="submit" class="bg-lime-500 text-white px-5 py-2 rounded-md">Filtrar</button>
					</form>

					

					

					<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 !text-center">Nombre</th>
								<th class="p-3 !text-center">Email</th>
								<th class="p-3 !text-center">Fecha de registro</th>
								<th class="p-3 !text-center" width="110px">Opciones
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($usuarios as $usuario)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->name }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->email }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $usuario->created_at }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{route('usuarios-cliente.edit',$usuario->id)}}" class="text-sky-500">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</a>
								<?php /*
									<a href="{{ route('pedidos.destroy', ['pedido' => $usuario->id]) }}" class="text-red-400 hover:text-red-600 delete-form"><i class="fa fa-trash"></i></a> */?>
								</td>
							</tr>
							@endforeach
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

		td:not(:last-child) {
			border-bottom: 0;
		}

		th:not(:last-child) {
			border-bottom: 2px solid rgba(0, 0, 0, .1);
		}
	</style>
	
	@endsection
</x-app-layout>