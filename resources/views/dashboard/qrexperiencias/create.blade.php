<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Crear QR´s Experiencias
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.qrexperiencias.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<form method="POST" action="{{route('cliente.qrexperiencias.store', ['cliente' => $cliente->id])}}" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="tipo" value="link">
		<div class="py-5">
			<div class="max-w-7xl mx-auto px-4 lg:px-8 bg-gray-100 py-10">
				@if ($errors->any())
				<div class="py-5">
					<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
				</div>
				@endif
				@if (session('success'))
				<div class="py-5">
					<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
				</div>
				@endif
				<div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-8">
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="titulo">
							Título
						</label>
						<input type="text" name="titulo" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('titulo') }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="url">
							URL
						</label>
						<input type="url" name="url" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('url', url("/{$cliente->slug}")) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="lat">
							Latitud
						</label>
						<input type="text" name="lat" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('lat', 0) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="lng">
							Longitud
						</label>
						<input type="text" name="lng" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" value="{{ old('lng', 0) }}" required>
					</div>
					<div class="col-span-2">
						<div class="text-xs">
							Si no conoces la latitud y longitud del lugar, puedes buscar la dirección en el siguiente mapa y se actualizara sola.
						</div>
						<gmpx-api-loader key="AIzaSyDl98_79CXXgbwn8UQflos9q_QAJO44Mlw" solution-channel="GMP_GE_mapsandplacesautocomplete_v1">
						</gmpx-api-loader>
						<gmp-map center="23.1518108,-110.3610418" zoom="5" map-id="DEMO_MAP_ID">
							<div slot="control-block-start-inline-start" class="place-picker-container">
								<gmpx-place-picker id="q-map" placeholder="Escribe la dirección que buscas"></gmpx-place-picker>
							</div>
							<gmp-advanced-marker></gmp-advanced-marker>
						</gmp-map>
					</div>
					<div class="lg:col-span-2">
						<button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	@section('js')
	<style>
		.place-picker-container {
			padding: 20px;
		}
		gmp-map {
			width: 100%;
			min-width: 350px;
			height: 500px;
		}
	</style>
	<script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script>
	<script>

		window.addEventListener('load', function() {
			init()
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
		async function init() {
			await customElements.whenDefined('gmp-map');

			const map = document.querySelector('gmp-map');
			const marker = document.querySelector('gmp-advanced-marker');
			const placePicker = document.querySelector('gmpx-place-picker');
			const infowindow = new google.maps.InfoWindow();

			map.innerMap.setOptions({
				mapTypeControl: false
			});

			placePicker.addEventListener('gmpx-placechange', () => {
				const place = placePicker.value;

				console.log(typeof $('#q-map').val())
				if (typeof $('#q-map').val() === 'string') {
					infowindow.close();
					marker.position = null;
					map.zoom = 5;
					return
				}

				if (typeof place === 'undefined' || !place.location) {
					Swal.fire({
						title: 'ERROR',
						text: "No se pudo encontrar el lugar: '" + place.name + "'",
						icon: 'error',
						showConfirmButton: false,
						timer: 2500
					});
					infowindow.close();
					marker.position = null;
					return;
				}
				console.log(place.location)
				if (place.viewport) {
					map.innerMap.fitBounds(place.viewport);
				} else {
					map.center = place.location;
					map.zoom = 17;
				}
				$('input[name=lat]').val(place.location.lat);
				$('input[name=lng]').val(place.location.lng);

				marker.position = place.location;
				infowindow.setContent(
					`<strong>${place.displayName}</strong><br>
						<span>${place.formattedAddress}</span>
				`);
				infowindow.open(map.innerMap, marker);
			});
		}
	</script>
	@endsection
</x-app-layout>
