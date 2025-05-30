<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					{{ $rally->titulo }}
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.rally.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<div class="py-4">
		<div class="max-w-7xl mx-auto px-4 bg-gray-100 py-10">
			@if ($errors->any())
			<div class="py-3">
				<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
			</div>
			@endif
			@if (session('success'))
			<div class="py-3">
				<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
			</div>
			@endif
			<div class="flex flex-col">
				<div class="grow">
					@if ($rally->ubicaciones->count() === 0)
						<div class="my-20">
							<div class="text-center text-xl font-bold">No hay ubicaciones</div>
						</div>
					@else
						<div class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-6 gap-5">
						@foreach ($rally->ubicaciones as $ubicacion)
							<div class="bg-white shadow p-5 flex flex-col">
								<div class="text-center">
									<img src="{{ asset('storage/'.$ubicacion->marker) }}" alt="{{ $ubicacion->titulo }}" class="w-auto h-16 inline-block">
								</div>
								<div class="text-center mt-1">
									<span class="text-pink-600 font-bold">{{ $ubicacion->completados }}</span> Completadas
								</div>
								<div class="text-center mt-1 font-extrabold text-xl mb-3">
									{{ $ubicacion->titulo }}
								</div>
								<div class="flex flex-row items-center justify-center gap-2 mt-auto">
									<a href="javascript:void(0);" data-lat="{{ $ubicacion->lat }}" data-lng="{{ $ubicacion->lng }}" class="distancia-actual" title="Distancia actual"><i class="fas fa-ruler-combined"></i></a>
									<a href="{{ route('cliente.rally.markers.edit', ['cliente' => $cliente->id, 'ubicacion' => $ubicacion->id, 'rally' => $rally->id]) }}" title="Editar"><i class="fa fa-edit"></i></a>
									<form class="delete-form" action="{{ route('cliente.rally.markers.destroy', ['cliente' => $cliente->id, 'ubicacion' => $ubicacion->id, 'rally' => $rally->id]) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" title="Eliminar" class="text-red-600"><i class="fa fa-trash"></i></button>
									</form>
								</div>
							</div>
						@endforeach
						</div>
					@endif
					<div class="flex flex-col justify-center items-center my-10">
						<a href="{{ route('cliente.rally.markers.create', ['cliente' => $cliente->id, 'rally' => $rally->id]) }}" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center items-center p-5 text-xs lg:text-base w-[6rem] h-[6rem] lg:w-[8rem] lg:h-[8rem]">
							<div class="text-xl lg:text-3xl font-bold">+</div>
							<div>Agregar</div>
							<div>ubicación</div>
						</a>
					</div>
				</div>
				<div class="grow">
					<div id="map"></div>
				</div>
			</div>

		</div>
	</div>
	@section('js')
	<style>
		#map {
			width: 100%;
			min-width: 350px;
			height: 500px;
		}
	</style>
	<!-- prettier-ignore -->
	<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
		({key: "AIzaSyBxLFY8L9duiFmTS_zqgTPywfW4iiwMUVM", v: "weekly"});</script>
	<script>
		@php
		$markers = $rally->ubicaciones->map->only(['id', 'titulo', 'lat', 'lng', 'marker']);
		@endphp
		const markers = @json($markers);
		window.addEventListener('load', function() {
			init()
			$('.distancia-actual').on('click', function(e){
				e.preventDefault();
				const lat = $(this).data('lat');
				const lng = $(this).data('lng');
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
					const distancia = Math.round(geoDistancia(lat, lng, position.coords.latitude, position.coords.longitude), 2);
					console.log(lat, lng, position.coords.latitude, position.coords.longitude, distancia);
					Swal.fire({
						title: 'Distancia',
						text: `Estás a ${distancia} metros de la ubicación`,
						icon: 'info',
						showConfirmButton: false,
						timer: 2500
					});
				});
			});
			$('form.delete-form button').on('click', function(e) {
				e.preventDefault();
				console.log('delete?')
				const $form = $(this).parent();
				Swal.fire({
					title: '¿Estás seguro?',
					text: "Una ves que elimines el marker no podrás recuperar la información.",
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
		let map;
		let infoWindow;
		async function init() {
			const { Map } = await google.maps.importLibrary("maps");

			map = new Map(document.getElementById("map"), {
				center: { lat: 22.909155, lng: -102.450886 },
				zoom: 5,
			});

			infoWindow = new google.maps.InfoWindow();

			let bounds = new google.maps.LatLngBounds();
			let infowindow = new google.maps.InfoWindow();

			markers.forEach(markerInfo => {
				const marker = new google.maps.Marker({
					position: { lat: markerInfo.lat, lng: markerInfo.lng },
					map,
					title: markerInfo.titulo,
					icon: {
						url: `{{ asset('storage/') }}/${markerInfo.marker}`,
						scaledSize: new google.maps.Size(60, 60),
					},
				});
				marker.addListener("click", () => {
					infowindow.setContent(`
						<strong>${markerInfo.titulo}</strong><br>
						<span>Latitud: ${markerInfo.lat}</span><br>
						<span>Longitud: ${markerInfo.lng}</span><br>
						<a href="https://www.google.com/maps/search/?api=1&query=${markerInfo.lat},${markerInfo.lng}" target="_blank" class="text-blue-600">Ver en google</a>
					`);
					infowindow.open(map, marker);
				});
				bounds.extend({ lat: markerInfo.lat, lng: markerInfo.lng });
			});

			map.fitBounds(bounds);
			let listener = google.maps.event.addListener(map, "idle", function () {
				map.setZoom(13);
				google.maps.event.removeListener(listener);
			});
		}
	</script>
	@endsection
</x-app-layout>
