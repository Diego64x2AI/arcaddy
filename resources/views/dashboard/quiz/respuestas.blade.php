@php
$mostrarRespuesta = false;
if ( $pregunta->tipo === 'open' || (($pregunta->tipo === 'multi' || $pregunta->tipo === 'option') && $respuesta_original->respuesta === 'Otra...') ) {
  $mostrarRespuesta = true;
}
@endphp
<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Quiz / {{ $quiz->nombre }} / Respuestas
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('clientes.quiz.stats', ['cliente' => $cliente->id, 'quiz' => $quiz->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
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
						<img src="{{ asset('storage/'.$cliente->logo) }}" class="img-general inline-block object-cover max-w-xs">
					</div>
          <div class="text-center mb-2 font-bold text-2xl">
            {{ $pregunta->pregunta }}
          </div>
          <div class="text-center mb-5 font-normal text-xl">
            <span class="text-pink-600 font-bold">Respuesta:</span> {{ $respuesta_original?->respuesta }}
          </div>
					<table id="usuarios" class="w-full rounded-lg overflow-hidden sm:shadow-lg !my-5">
						<thead class="text-white">
							<tr class="bg-teal-400">
								<th class="p-3 !text-center">ID</th>
								<th class="p-3 !text-center">Nombre</th>
								<th class="p-3 !text-center">Email</th>
                @if ($mostrarRespuesta)
                <th class="p-3 !text-center">Respuesta</th>
                @endif
								<th class="p-3 !text-center">Fecha</th>
								<th class="p-3 !text-center" width="110px">Opciones</th>
							</tr>
						</thead>
						<tbody>

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
		td {
			text-align: center;
		}
		td:not(:last-child) {
			border-bottom: 0;
		}
		th:not(:last-child) {
			border-bottom: 2px solid rgba(0, 0, 0, .1);
		}
	</style>
	<script>
		window.addEventListener('load', function() {
			const table = $('table#usuarios').DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				ajax: "{{ route('clientes.quiz.respuestas.ajax', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'respuesta' => intval($respuesta_original?->id)]) }}",
				columns: [
          {data: 'id', name: 'id'},
          {data: 'name', name: 'name', orderable: true, searchable: true},
          {data: 'email', name: 'email', orderable: true, searchable: true},
          @if($mostrarRespuesta)
          {data: 'respuesta', name: 'respuesta', orderable: true, searchable: true},
          @endif
          {data: 'created_at', name: 'created_at', orderable: false, searchable: false, orderable: true, searchable: true},
          {data: 'action', name: 'action', orderable: false, searchable: false},
				],
				paging: true,
				searching: true,
				ordering:  true,
				pageLength: 10,
				language: {
					url: '{{ asset("es-ES.json") }}'
				},
				search: {
        	"regex": true
      	}
			});
			$('.dataTables_filter input')
       .off()
       .on('keyup', function() {
          table.draw();
       });
			 $('body').on('click', '.regalar-beneficio', function(e) {
				e.preventDefault();
				var form = $(this).parents('form');
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Estás a punto de regalar un beneficio.",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '¡Sí, regalar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						window.top.location = $(this).attr('href');
					}
				})
			});
		});
	</script>
	@endsection
</x-app-layout>
