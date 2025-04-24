@php
	$rally = $cliente->rallys()->where('activo', true)->orderBy('id', 'desc')->first();
	list($r, $g, $b) = sscanf($cliente->color_bg, "#%02x%02x%02x");
	list($r2, $g2, $b2) = sscanf($cliente->color, "#%02x%02x%02x");
	$markers = $rally->ubicaciones->map->only(['id', 'titulo', 'rally_id', 'lat', 'lng', 'marker', 'ver_mapa', 'distancia', 'fuera_rango', 'descripcion', 'btn_titulo']);
	$completados = [];
	if (auth()->check()) {
		$completados = \App\Models\ClienteRallyUbicacionCompletados::where('user_id', auth()->user()->id)->pluck('ubicacion_id')->toArray();
	}
@endphp
@if ($rally !== NULL)
<section id="rally">
	<div class="bg-center bg-no-repeat bg-cover w-full h-[50vh]" style="background-image: url({{ asset('storage/'.$rally->banner) }});">

	</div>
	<div id="map" class="w-full h-[50vh]"></div>
</section>
<script>
	const rallyLogged = {{ auth()->check() ? 'true' : 'false' }};
	const rallyGeoOculto = {{ $rally->geo_oculto ? 'true' : 'false' }};
	const markers = @json($markers);
	const completadosRally = @json($completados);
	document.addEventListener('DOMContentLoaded', function load() {
		if (!window.jQuery) return setTimeout(load, 50);
		console.log(`rally load`);
		init()
	});
	const openMarker = (markerInfo) => {
		console.log(markerInfo);
		if (!rallyLogged) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '{{ __('arcaddy.rally1') }}',
					// prevent outside click
					allowOutsideClick: false,
					// custom button for register
					showCancelButton: true,
					confirmButtonText: '{{ __('Register') }}',
					cancelButtonText: '{{ __('Login') }}',
					customClass: 'quiz-swal',
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = '{{ route('register', ['cliente' => $cliente->id]) }}';
					} else {
						window.location.href = '{{ route('login', ['cliente' => $cliente->id]) }}';
					}
				});
				return;
			}
		if (!navigator.geolocation) {
			Swal.fire({
				title: 'ERROR',
				text: "{{ __('arcaddy.rally2') }}",
				icon: 'error',
				showConfirmButton: false,
				timer: 2500
			});
			return;
		}
		navigator.geolocation.getCurrentPosition(function(position) {
			const distancia = Math.round(geoDistancia(markerInfo.lat, markerInfo.lng, position.coords.latitude, position.coords.longitude), 2);
			console.log(markerInfo.lat, markerInfo.lng, position.coords.latitude, position.coords.longitude, distancia);
			if (distancia <= markerInfo.distancia) {
				axios.post(`{{ url('/') }}/{{ $cliente->slug }}/rally/${markerInfo.rally_id}/${markerInfo.id}/completed`, {
					lat: position.coords.latitude,
					lng: position.coords.longitude,
					distancia: distancia,
				})
				.then(response => {
					console.log(response.data);
					Swal.fire({
						html: `
							<div class="flex flex-row items-center gap-3">
								<div>
									<dotlottie-player src="https://lottie.host/d81808b2-b7e4-4020-971d-0eaf1c330533/3m6Na9wiNs.json" background="transparent" speed="1" style="width: 50px; height: 50px;" loop autoplay></dotlottie-player>
								</div>
								<div class="font-bold text-xl text-green-500">{{ __('arcaddy.rally3') }}</div>
							</div>
							<div class="text-center">
								<img src="{{ asset('storage/') }}/${response.data.image}" class="w-full h-auto inline-block">
							</div>
							<div class="flex flex-row items-center justify-center gap-3">
								<div>
									<img src="{{ asset('storage/') }}/${markerInfo.marker}" class="w-20 h-20">
								</div>
								<div class="font-bold text-xl color2">${markerInfo.titulo}</div>
							</div>
							<div class="mt-5 text-xs color2 font-semibold">${markerInfo.descripcion}</div>
							<div class="mt-8"><a href="${response.data.link}" target="_blank" class="btn-pill">${markerInfo.btn_titulo}</a></div>
						`,
						showConfirmButton: false,
						showCancelButton: true,
						cancelButtonText: 'X',
						focusConfirm: false,
						focusCancel: false,
						customClass: 'swal-rally',
					});
				}).catch(function(error) {
					console.log(error);
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.error-gral') }}',
						customClass: 'swal-rally',
					});
				});
			} else {
				let btn = ``;
				if (markerInfo.ver_mapa) {
					btn = `<div class="mt-8"><a href="https://www.google.com/maps/search/?api=1&query=${markerInfo.lat},${markerInfo.lng}" target="_blank" class="btn-pill"><i class="fas fa-map-marker-alt"></i> Ver en mapas</a></div>`;
				}
				Swal.fire({
					html: `
						<div class="flex flex-row items-center gap-3">
							<div>
								<img src="{{ asset('storage/') }}/${markerInfo.marker}" class="w-20 h-20">
							</div>
							<div class="font-bold text-xl color2">${markerInfo.titulo}</div>
						</div>
						<div class="text-center">
							<img src="{{ asset('images/rango.png') }}" class="w-3/4 h-auto inline-block">
						</div>
						<div class="mt-5 text-xs color2 font-semibold">${markerInfo.fuera_rango}</div>
						<div class="mt-5 text-xs color2 font-semibold">{{ __('arcaddy.rally4') }} ${distancia} {{ __('arcaddy.rally5') }}</div>
						${btn}
					`,
					showConfirmButton: false,
					showCancelButton: true,
					cancelButtonText: 'X',
					focusConfirm: false,
					focusCancel: false,
					customClass: 'swal-rally',
				});
			}
		}, function() {
			Swal.fire({
				title: 'ERROR',
				text: "{{ __('arcaddy.rally2') }}",
				icon: 'error',
				showConfirmButton: false,
				timer: 2500
			});
		}, {
			enableHighAccuracy: true,
			timeout: 5000,
			maximumAge: 0
		});
	}
	let map;
	async function init() {
		const { Map } = await google.maps.importLibrary("maps");

		map = new Map(document.getElementById("map"), {
			center: { lat: 22.909155, lng: -102.450886 },
			zoom: 5,
		});

		let bounds = new google.maps.LatLngBounds();

		markers.forEach(markerInfo => {
			const marker = new google.maps.Marker({
				position: { lat: markerInfo.lat, lng: markerInfo.lng },
				map,
				title: markerInfo.titulo,
				icon: {
					url: !completadosRally.includes(markerInfo.id) ? `{{ asset('storage/') }}/${markerInfo.marker}` : `{{ asset('images/marker-completed.png') }}`,
					scaledSize: new google.maps.Size(60, 60),
				},
			});
			marker.addListener("click", () => {
				openMarker(markerInfo)
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
<style>
	.swal-rally .swal2-actions .swal2-cancel {
		position: absolute;
		top: 0;
		right: 0;
		width: 2rem;
		height: 2rem;
		line-height: 2rem;
		text-align: center;
		font-size: 1.2rem;
		color: white;
		background-color: rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},1);
		border-radius: 50%;
		margin: -0.8rem -0.8rem 0 0;
		padding: 0;
		font-weight: bold;
		border: none!important;
		box-shadow: none!important;
	}
	.swal-rally {
		background-color: rgba({{ $r }},{{ $g }},{{ $b }},1)!important;
		color: {{ $cliente->color }} !important;
	}
</style>
@endif
