<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Games
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

					<?php /*<a href="{{route('games.create')}}?c=" class="bg-pink-600 text-white px-5 py-2 rounded-md" style="float: right;">Nuevo Memory</a> */?>
					
					
					<select id="nuevo-juego" style="float: right;" onchange="redirigir()">
                        <option value="" disabled selected>Nuevo juego</option>
                        
                        @foreach($juegoCategorias as $cat)
                            <option value="{{route('games.create')}}?cat={{$cat->id}}">
                                {{$cat->nombre}}
                            </option>
                        @endforeach
                    </select>
                    <div class="separador"></div>
					
					
					
					
					
					

					<form method="GET" action="{{route('games.index')}}">
						<select name="cliente_id" class="opc-filtro">
                        <option value="0" >Cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{$cliente->id}}" 
                            	{{(isset($parametros['cliente_id']) && $parametros['cliente_id'] == $cliente->id)?'selected':''}}>{{$cliente->cliente}} </option>
                        @endforeach
                    	</select>
                    	
                    	<select name="categoria_id" class="opc-filtro">
                        <option value="0" >Categoria</option>
                        @foreach($juegoCategorias as $cat)
                            <option value="{{$cat->id}}" 
                            	{{(isset($parametros['categoria_id']) && $parametros['categoria_id'] == $cat->id)?'selected':''}}>{{$cat->nombre}} </option>
                        @endforeach
                    	</select>
                    	<button type="submit" class="bg-lime-500 text-white px-5 py-2 rounded-md">Filtrar</button>
                    	<div class="separador"></div>
					</form>

					

					

					<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3">Cliente</th>
								<th class="p-2">Categría</th>
								<th class="p-3">Nombre</th>
								<th class="p-1">Activo</th>
								<th class="p-3" width="110px">Opciones
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($juegos as $juego)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3">{{ $juego->cliente->cliente }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-2">{{ $juego->categoria->nombre}}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3">{{ $juego->nombre }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-1 text-center">{{ $juego->activo }}</td>
							
								
									
								<td class="border-grey-light border hover:bg-gray-100 p-3">
								    	<a href="{{route('games.edit',$juego->id)}}" class="text-sky-500">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</a>
									
									<a href="{{ route('games.borrar',$juego->id) }}" class="text-red-400 hover:text-red-600 delete-form" onclick="return confirm('¿Estás seguro de que deseas eliminar este juego?')"><i class="fa fa-trash"></i></a>
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
	 <script>
        function redirigir() {
          var select = document.getElementById("nuevo-juego");
          var selectedOption = select.options[select.selectedIndex];
          if (selectedOption.value !== "") {
            window.location.href = selectedOption.value;
          }
        }
      </script>
	<style>
		#nuevo-juego{
			float: right;
			width: 200px;
			margin-bottom: 10px;
		}
		.opc-filtro{
			width: 200px;
		    float: left;
		    margin-right: 10px;
		}
		.separador{
			clear: both;
		}
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