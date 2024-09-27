<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Crear Sucursal
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.sucursales.index', ['cliente' => $cliente->id]) }}"
					class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<form method="POST" action="{{route('cliente.sucursales.store', ['cliente' => $cliente->id])}}"
		enctype="multipart/form-data">
		@csrf
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
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="nombre">
							Sucursal:
						</label>
						<input type="text" name="nombre" id="nombre" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('nombre') }}" placeholder="Ejemplo: Enrique ladrón de guevara" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="telefono">
							Teléfono:
						</label>
						<input type="text" name="telefono" id="telefono" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('telefono') }}"
							placeholder="Ejemplo: +52123456789"
							required>
					</div>
					<div class="col-span-2">
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="direccion">
							Domicilio:
						</label>
						<input type="text" name="direccion" id="direccion" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('direccion') }}"
							placeholder="Ejemplo: Enrique ladrón de guevara #155" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="ciudad">
							Ciudad:
						</label>
						<input type="text" name="ciudad" id="ciudad" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('ciudad') }}" placeholder="Ejemplo: Zapopan" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="horario">
							Horario:
						</label>
						<input type="text" name="horario" id="horario" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('horario') }}" placeholder="Ejemplo: 9am a 6pm">
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="link_titulo">
							Título del link:
						</label>
						<input type="text" name="link_titulo" id="link_titulo"
							class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="Ejemplo: Visita nuestra página"
							value="{{ old('link_titulo') }}">
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="link">
							Link:
						</label>
						<input type="text" name="link" id="link"
							class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="Ejemplo: https://laflordecordoba.com"
							value="{{ old('link') }}">
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="lat">
							Latitud
						</label>
						<input type="text" name="lat" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('lat', 0) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="lng">
							Longitud
						</label>
						<input type="text" name="lng" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('lng', 0) }}" required>
					</div>
					<div class="col-span-2">
						<div class="text-xs">
							Si no conoces la latitud y longitud del lugar, puedes buscar la dirección en el siguiente mapa y se
							actualizara sola.
						</div>
						<gmpx-api-loader key="AIzaSyDl98_79CXXgbwn8UQflos9q_QAJO44Mlw"
							solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
						<gmp-map center="23.1518108, -110.3610418" zoom="5" map-id="DEMO_MAP_ID">
							<div slot="control-block-start-inline-start" class="place-picker-container">
								<gmpx-place-picker id="q-map" placeholder="Escribe la dirección que buscas"></gmpx-place-picker>
								<div class="!absolute !top-20 !left-5">
									<a href="javascript:void(0);" id="gps-link" class="bg-pink-600 text-white px-5 py-2 rounded-3xl"><i
											class="fas fa-location-arrow"></i> Utilizar mi ubicación</a>
								</div>
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
			position: relative;
		}
	</style>
	<script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script>
	<script>
		window.addEventListener('load', function() {
			init()
			$('a#gps-link').on('click', function() {
				if (!navigator.geolocation) {
					Swal.fire({
						title: 'ERROR',
						text: "Tu navegador no soporta la geolocalización",
						icon: 'error',
						showConfirmButton: false,
						timer: 2500
					});
					return;
				}
				navigator.geolocation.getCurrentPosition(function(position) {
					$('input[name=lat]').val(position.coords.latitude);
					$('input[name=lng]').val(position.coords.longitude);
					marker.position = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					map.center = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					map.zoom = 17;
					infowindow.setContent(`
						<strong>Mi ubicación actual</strong><br>
						<span>Puede ser imprecisa si no te encuentras en un dispositivo móvil.</span>
					`);
					infowindow.open(map.innerMap, marker);
				}, function() {
					Swal.fire({
						title: 'ERROR',
						text: "No se pudo obtener tu ubicación",
						icon: 'error',
						showConfirmButton: false,
						timer: 2500
					});
				}, {
					enableHighAccuracy: true,
					timeout: 5000,
					maximumAge: 0
				});
			});
		});
		let map;
		let marker;
		let placePicker;
		let infoWindow;

		async function init() {
			await customElements.whenDefined('gmp-map');

			map = document.querySelector('gmp-map');
			marker = document.querySelector('gmp-advanced-marker');
			placePicker = document.querySelector('gmpx-place-picker');
			infowindow = new google.maps.InfoWindow();

			map.innerMap.setOptions({
				mapTypeControl: false
			});

			placePicker.addEventListener('gmpx-placechange', () => {
				const place = placePicker.value;

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
