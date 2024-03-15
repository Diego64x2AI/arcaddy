<x-app-layout>
	<x-slot name="header">
		<div class="flex flex-row items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Games
				</h2>
			</div>
			<div class="ml-auto">
				<select id="nuevo-juego" class="input-underline" onchange="redirigir()">
					<option value="" disabled selected>Nuevo juego</option>
					@foreach($juegoCategorias as $cat)
							<option value="{{route('games.create')}}?cat={{$cat->id}}">
									{{$cat->nombre}}
							</option>
					@endforeach
				</select>
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
					<form method="GET" action="{{route('games.index')}}" class="mb-20">
						<select name="cliente_id" class="input-underline opc-filtro">
							<option value="0" >Cliente</option>
							@foreach($clientes as $cliente)
									<option value="{{$cliente->id}}"
										{{(isset($parametros['cliente_id']) && $parametros['cliente_id'] == $cliente->id)?'selected':''}}>{{$cliente->cliente}} </option>
							@endforeach
						</select>
						<select name="categoria_id" class="input-underline opc-filtro">
							<option value="0" >Categoria</option>
							@foreach($juegoCategorias as $cat)
									<option value="{{$cat->id}}"
										{{(isset($parametros['categoria_id']) && $parametros['categoria_id'] == $cat->id)?'selected':''}}>{{$cat->nombre}} </option>
							@endforeach
						</select>
						<button type="submit" class="bg-lime-500 text-white px-5 py-2 rounded-md">Filtrar</button>
						<div class="separador"></div>
					</form>
					<table id="games" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 !text-center">Cliente</th>
								<th class="p-2 !text-center">Categoría</th>
								<th class="p-3 !text-center">Nombre</th>
								<th class="p-3 !text-center">Link</th>
								<th class="p-3 !text-center">Activo</th>
								<th class="p-3 !text-center">Opciones
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($juegos as $juego)
							<tr>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $juego->cliente->cliente }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $juego->categoria->nombre}}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $juego->nombre }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
									<a href="{{ route('cliente.start-game', [$juego->cliente_id, $juego->clave]) }}" target="_blank">
										Visitar
									</a>
								</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">{{ $juego->activo ? 'SI' : 'NO' }}</td>
								<td class="border-grey-light border hover:bg-gray-100 p-3 text-center">
								  <a href="{{route('games.edit', $juego->id)}}" class="text-sky-500">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</a>
									<form action="{{ route('games.destroy', ['game' => $juego->id]) }}" method="POST" class="inline delete-form">
										@csrf
										@method('DELETE')
										<button type="submit" class="text-red-400 hover:text-red-600 delete-form"><i class="fa fa-trash"></i></button>
									</form>
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
		window.addEventListener('load', function() {
			$('table#games').DataTable({
				paging: true,
				searching: true,
				ordering:  true,
				responsive: true,
				pageLength: 25,
				columnDefs: [
					{ responsivePriority: 1, targets: 0 },
					{ responsivePriority: 2, targets: 1 },
					{ responsivePriority: 3, targets: 2 }
        ],
				language: {
					url: '{{ asset("es-ES.json") }}'
				}
			});
			$('form.delete-form button').on('click', function(e) {
				e.preventDefault();
				console.log('delete?')
				const $form = $(this).parent();
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Una ves que elimines el juego no podrás recuperar la información.",
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
