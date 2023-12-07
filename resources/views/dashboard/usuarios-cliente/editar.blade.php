<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Editar Administrador cliente
				</h2>
			</div>
		</div>
	</x-slot>

	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100">
			<div class="">


			<div class="p-3 mt-3">
			<div class="w-full md:w-1/3 px-3 mb-6 ">
			<form method="POST" action="{{route('usuarios-cliente.update',$usuario->id)}}">
				@csrf
				@method('PUT')
				<input type="hidden" name="usuarioid" value="{{$usuario->id}}">


				<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
					Cliente
				</label>
				<select name="cliente_id" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6">
                    <option value="0">Cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{$cliente->id}}" 
                        	{{($usuario->cliente_id == $cliente->id)?'selected':''}}>{{$cliente->cliente}} </option>
                    @endforeach
                </select>

                <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
					Nombre
				</label>
				<input value="{{$usuario->name}}" type="text" name="name" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6" required>

				<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
					Email
				</label>
				<input value="{{$usuario->email}}" type="text" name="email" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6" required>

				<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
					Password
				</label>
				<input type="password" name="password" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6">
				<div class="flex justify-end">
					<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
				</div>

			</form>
			</div>
			</div>
				
			</div>
		</div>
	</div>

	
	
</x-app-layout>