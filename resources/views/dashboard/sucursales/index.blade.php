<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Sucursales
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.sucursales.create', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Crear
				</a>
			</div>
		</div>
	</x-slot>

	<div class="py-6">
		<div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white">
				<div class="text-center">
					<img src="{{ asset('storage/'.$cliente->logo) }}" alt="{{ $cliente->cliente }}" class="inline-block w-full h-auto max-w-xs">
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
					<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
						<div class="col-span-2">
							<div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
								@foreach ($sucursales as $sucursal)
									<div class="flex flex-row items-center gap-3 text-sm border-b py-5">
										<div>
											<img src="{{ asset('images/sucursal-pin.png') }}" alt="{{ $sucursal->nombre }}" class="inline-block w-16 h-auto">
										</div>
										<div class="text-center grow">
											<div class="font-bold line-clamp-2 text-basex leading-4">{{ $sucursal->nombre }}</div>
											<div>{{ $sucursal->ciudad }}</div>
										</div>
										<div>
											<div class="text-center">
												<span class="text-pink-600 font-bold">{{ $sucursal->lecturas }}</span> Lecturas
											</div>
											<div class="grid grid-cols-3 gap-3">
												<div class="text-center">
													<a href="{{ asset('storage/sucursales/'.$sucursal->id.'.png?'.time()) }}" download="qr-sucursal-{{ $sucursal->id }}" class="inline-block" target="_blank" title="Código QR"><i class="fa fa-qrcode"></i></a>
												</div>
												<div class="text-center">
													<a href="{{ route('cliente.sucursales.edit', ['cliente' => $sucursal->cliente_id, 'sucursale' => $sucursal->id]) }}" class="inline-block" title="Editar"><i class="fa fa-edit"></i></a>
												</div>
												<div class="text-center">
													<form action="{{ route('cliente.sucursales.destroy', ['cliente' => $sucursal->cliente_id, 'sucursale' => $sucursal->id]) }}" method="POST" class="delete-form inline-block m-0 b-0">
														@csrf
														@method('DELETE')
														<button href="{{ route('cliente.sucursales.destroy', ['cliente' => $sucursal->cliente_id, 'sucursale' => $sucursal->id]) }}" type="button" wire:click="$emit('confirmDelete')">
															<i class="fa fa-trash-alt"></i>
														</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
						<div>
							<gmpx-api-loader key="AIzaSyDl98_79CXXgbwn8UQflos9q_QAJO44Mlw"
							solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
							<gmp-map center="23.1518108, -110.3610418" zoom="5" map-id="DEMO_MAP_ID">

							</gmp-map>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		gmp-map {
			width: 100%;
			min-width: 350px;
			height: 500px;
			position: relative;
		}
	</style>
	@section('js')
	<script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script>
	<script>
		const url = '{{ url('dashboard/cliente/'.$cliente->id.'/quiz') }}';
		window.addEventListener('load', function() {
			init();
			let map;
			let marker;
			let infoWindow;
			let pinIMG;

			async function init() {
				await customElements.whenDefined('gmp-map');
				const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

				map = document.querySelector('gmp-map');
				infowindow = new google.maps.InfoWindow();



				map.innerMap.setOptions({
					mapTypeControl: false
				});

				// add markers
				@foreach ($sucursales as $sucursal)
					pinIMG = document.createElement("img");
					pinIMG.src = "{{ asset('images/sucursal-pin.png') }}";
					marker = new AdvancedMarkerElement({
						position: { lat: {{ $sucursal->lat }}, lng: {{ $sucursal->lng }} },
						title: '{{ $sucursal->nombre }}',
						map: map.innerMap,
						content: pinIMG,
						gmpClickable: true,
					});
					marker.addEventListener('gmp-click', () => {
						console.log('click');
						infowindow = new google.maps.InfoWindow({
							ariaLabel: '{{ $sucursal->nombre }}',
							content: `
								<div class="text-center">
									<div class="font-bold line-clamp-2 text-basex leading-4">{{ $sucursal->nombre }}</div>
									<div>{{ $sucursal->ciudad }}</div>
								</div>
							`,
						});
						infowindow.open(map.innerMap, marker.innerMarker);
					});
					map.appendChild(marker);

				@endforeach

				// fit map to markers
				const bounds = new google.maps.LatLngBounds();
				document.querySelectorAll('gmp-advanced-marker').forEach(marker => {
					bounds.extend(marker.position);
				});
				map.innerMap.fitBounds(bounds);

			}
			const inlineEditElements = document.querySelectorAll('.edit-inline-text')
			inlineEditElements.forEach(element => {
				Flyter.attach(element, {
					initialValue: element.innerHTML,
					emptyValueDisplay: 'Escribe el valor del campo...',
					submitOnEnter: true,
					type: { name: 'text' },
					okButton: {enabled: true,text: 'Guardar'},
					cancelButton: {enabled: true,text: 'Cancelar'},
					onSubmit: async function(valor) {
						const formdata = new FormData()
						formdata.append($(element).data('campo'), valor)
						$.ajax({
							url: `${url}/${$(element).data('id')}/atributo`,
							type: "POST",
							method: 'POST',
							data: formdata,
							cache: false,
							processData: false,
							contentType: false
						}).done(function(data) {
							console.log(data);
							return true
						}).fail(function() {
							Swal.fire( "error" );
						});
					}
				})
			})
			$('table#usuarios').DataTable({
				paging: true,
				searching: true,
				ordering:  true,
				responsive: true,
				pageLength: 25,
				columnDefs: [
					{ responsivePriority: 1, targets: 0 },
					{ responsivePriority: 2, targets: 1 },
					{ responsivePriority: 3, targets: -1 }
        ],
				language: {
					url: '{{ asset("es-ES.json") }}'
				}
			});
			$('.update-quiz').change(function(){
				const formdata = new FormData()
				formdata.append($(this).data('campo'), $(this).prop('checked'))
				$.ajax({
					url: `${url}/${$(this).data('id')}/atributo`,
					type: "POST",
					method: 'POST',
					data: formdata,
					cache: false,
					processData: false,
					contentType: false
				}).done(function(data) {
					console.log(data);
					window.location.reload();
				}).fail(function() {
					Swal.fire( "error" );
				});
			});
			$('form.delete-form button').on('click', function(e) {
				e.preventDefault();
				console.log('delete?')
				const $form = $(this).parent();
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Una ves que elimines el rally no podrás recuperar la información.",
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
