<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Editar punto GEO / Rally
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.rally.markers', ['cliente' => $cliente->id, 'rally' => $rally->id]) }}"
					class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<form method="POST" action="{{route('cliente.rally.markers.update', ['cliente' => $cliente->id, 'rally' => $rally->id, 'ubicacion' => $ubicacion->id])}}"
		enctype="multipart/form-data">
		@csrf
		@method('PUT')
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
						<input type="text" name="titulo" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('titulo', $ubicacion->titulo) }}" placeholder="Ejemplo: Misterio en el centro" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="fuera_rango">
							Contenido fuera de rango:
						</label>
						<input type="text" name="fuera_rango" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('fuera_rango', $ubicacion->fuera_rango) }}"
							placeholder="Ejemplo: Para descubrir el contenido debes ubicarte por lo menos a 50 mts de la ubicación."
							required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="descripcion">
							Descripción:
						</label>
						<input type="text" name="descripcion" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('descripcion', $ubicacion->descripcion) }}"
							placeholder="Ejemplo: Descubre la palabra secreta en la realidad aumentada" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="btn_titulo">
							Título del botón:
						</label>
						<input type="text" name="btn_titulo" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('btn_titulo', $ubicacion->btn_titulo) }}" placeholder="Ejemplo: Ver realidad aumentada" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="btn_link">
							Link del botón:
						</label>
						<input type="text" name="btn_link" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('btn_link', $ubicacion->btn_link) }}" placeholder="Ejemplo: https://arcaddy.com/" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="distancia">
							Distancia máxima permitida (mts):
						</label>
						<input type="number" step="1" pattern="\d*" name="distancia" min="0"
							class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" placeholder="En metros"
							value="{{ old('distancia', $ubicacion->distancia) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="imagen">
							Imagen
						</label>
						<div id="preview-container"></div>
						<input type="file" id="imagen" name="imagen" multiple accept="image/*">
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="marker">
							Marker
						</label>
						<div id="preview-container"></div>
						<input type="file" id="marker" name="marker" multiple accept="image/*">
					</div>
					<div class="font-bold col-span-2">
						<label for="ver_mapa" class="flex items-center cursor-pointer">
							<div class="relative mr-5">
								<input id="ver_mapa" name="ver_mapa" type="checkbox" class="sr-only" @checked(old('ver_mapa', $ubicacion->ver_mapa)) />
								<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
								<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
							</div>
							Ver en mapa
						</label>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="lat">
							Latitud
						</label>
						<input type="text" name="lat" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('lat', $ubicacion->lat) }}" required>
					</div>
					<div>
						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="lng">
							Longitud
						</label>
						<input type="text" name="lng" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700"
							value="{{ old('lng', $ubicacion->lng) }}" required>
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
