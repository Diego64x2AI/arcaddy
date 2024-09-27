@if($cliente->sucursales->count() > 0)
<section id="sucursales" class="mt-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'sucursales')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'sucursales')->first()->titulo }}</div>
	@endif
	@if ($cliente->sucursales_mapa)
	<div id="map" class="w-full h-[50vh]"></div>
	@else
	<div class="flex flex-col gap-3 px-5">
		@foreach ($cliente->sucursales()->limit($cliente->sucursales_max)->get() as $sucursal)
		<div class="shadow border bg-white rounded-lg">
			<div class="relative rounded-3xl accordeon-link cursor-pointer px-5 py-3 uppercase font-bold flex flex-row items-center">
				<div class="flex flex-row items-center grow">
					<div>{{ $sucursal->nombre }}</div>
					<div class="ml-auto">
						<a href="https://www.google.com/maps/dir/?api=1&destination={{ $sucursal->lat }},{{ $sucursal->lng }}" target="_blank"><img src="{{ asset('images/sucursal-mapa.png') }}" alt="¿Cómo llegar?" class="w-14 h-auto"></a>
					</div>
					<div class="mr-5">
						<a href="tel:{{ $sucursal->telefono }}"><img src="{{ asset('images/sucursal-phone.png') }}" alt="¿Cómo llegar?" class="w-14 h-auto"></a>
					</div>
				</div>
				<div class="absolute top-4 right-5">
					{!! $loop->first ? '<i class="fa fa-minus"></i>' : '<i class="fa fa-plus"></i>' !!}
				</div>
			</div>
			<div class="px-5 pb-3 font-semibold text-sm text-left justify-evenly"{!! $loop->first ? '' : ' style="display:none;"' !!}>
				<div>{{ $sucursal->direccion }}</div>
				<div>{{ $sucursal->ciudad }}</div>
				<div>{{ $sucursal->horario }}</div>
			</div>
		</div>
		@endforeach
	</div>
	@endif
</section>
<script>
	window.addEventListener('load', function() {
		@if ($cliente->sucursales_mapa)
		init();
		let map;
		let marker;
		let infoWindow;
		let pinIMG;

		const openMarker = (markerInfo) => {
			console.log(markerInfo);
			Swal.fire({
				title: markerInfo.titulo,
				html: `
					<div class="text-left text-black">
						<div class="font-bold line-clamp-2 leading-4">${markerInfo.direccion}</div>
						<div>${markerInfo.ciudad}</div>
						<div><a href="tel:${markerInfo.telefono}">${markerInfo.telefono}</a></div>
					</div>
					<div class="mt-3">
						<a href="https://www.google.com/maps/dir/?api=1&destination=${markerInfo.lat},${markerInfo.lng}" target="_blank" class="btn btn-pill">Cómo llegar</a>
					</div>
				`,
				showConfirmButton: false,
				showCloseButton: true,
			});
		};

		async function init() {
			console.log('init');
			const { Map } = await google.maps.importLibrary("maps");

			map = new Map(document.getElementById("map"), {
				center: { lat: 22.909155, lng: -102.450886 },
				zoom: 5,
			});
			let bounds = new google.maps.LatLngBounds();
			@foreach ($cliente->sucursales()->limit($cliente->sucursales_max)->get() as $sucursal)
			marker = new google.maps.Marker({
				position: { lat: {{ $sucursal->lat }}, lng: {{ $sucursal->lng }} },
				map,
				title: `{{ $sucursal->nombre }}`,
				icon: {
					url: `{{ ($cliente->sucursales_pin !== NULL) ? asset('storage/'.$cliente->sucursales_pin) : asset('images/sucursal-pin.png') }}`,
					scaledSize: new google.maps.Size(60, 60),
				},
			});
			marker.addListener("click", () => {
				openMarker({
					lat: {{ $sucursal->lat }},
					lng: {{ $sucursal->lng }},
					titulo: `{{ $sucursal->nombre }}`,
					telefono: `{{ $sucursal->telefono }}`,
					direccion: `{{ $sucursal->direccion }}`,
					ciudad: `{{ $sucursal->ciudad }}`,
				})
			});
			bounds.extend({ lat: {{ $sucursal->lat }}, lng: {{ $sucursal->lng }} });
			@endforeach
			map.fitBounds(bounds);
			let listener = google.maps.event.addListener(map, "idle", function () {
				map.setZoom(13);
				google.maps.event.removeListener(listener);
			});
		}
		@else
		@endif
	});
</script>
@endif
