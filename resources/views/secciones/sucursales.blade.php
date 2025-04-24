@if($cliente->sucursales->count() > 0)
<section id="sucursales" class="mt-5 text-center lg:mt-10">
	@if ($cliente->secciones()->where('seccion', 'sucursales')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'sucursales')->first()->titulo }}</div>
	@endif
	<div id="sucursales-cercanas" class="flex flex-col gap-3 px-5">

	</div>
	@if ($cliente->sucursales_mapa)
	<div id="map" class="w-full h-[50vh] mt-10"></div>
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
						<a href="https://www.google.com/maps/dir/?api=1&destination=${markerInfo.lat},${markerInfo.lng}" target="_blank" class="btn btn-pill">{{ __('arcaddy.sucursales1') }}</a>
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

			navigator.geolocation.getCurrentPosition(function(position) {
				axios.post(`{{ url('/') }}/{{ $cliente->slug }}/sucursales-cercanas`, {
					lat: position.coords.latitude,
					lng: position.coords.longitude,
					cliente: {{ $cliente->id }},
				})
				.then(response => {
					let sucursales = response.data.sucursales;
					if (sucursales.length > 0) {
						sucursales.forEach(sucursal => {
							marker = new google.maps.Marker({
								position: { lat: sucursal.lat, lng: sucursal.lng },
								map,
								title: sucursal.nombre,
								icon: {
									url: `{{ ($cliente->sucursales_pin !== NULL) ? asset('storage/'.$cliente->sucursales_pin) : asset('images/sucursal-pin.png') }}`,
									scaledSize: new google.maps.Size(60, 60),
								},
							});
							marker.addListener("click", () => {
								openMarker({
									lat: sucursal.lat,
									lng: sucursal.lng,
									titulo: sucursal.nombre,
									telefono: sucursal.telefono,
									direccion: sucursal.direccion,
									ciudad: sucursal.ciudad,
								})
							});
							bounds.extend({ lat: sucursal.lat, lng: sucursal.lng });
						});
						map.fitBounds(bounds);
					}
				}).catch(function(error) {
					console.log(error);
				});
			});
		}
		@endif
		navigator.geolocation.getCurrentPosition(function(position) {
			axios.post(`{{ url('/') }}/{{ $cliente->slug }}/sucursales-cercanas`, {
				lat: position.coords.latitude,
				lng: position.coords.longitude,
				cliente: {{ $cliente->id }},
			})
			.then(response => {
				let sucursales = response.data.sucursales;
				if (sucursales.length > 0) {
					$('#sucursales-cercanas').empty();
					let x = 0;
					sucursales.forEach(sucursal => {
						let icon = (x === 0) ? 'fa-minus' : 'fa-plus';
						let style = (x === 0) ? 'block' : 'none';
						let telefono = (sucursal.telefono !== null && sucursal.telefono !== '') ? `<div class="mr-3">
											<a href="tel:${sucursal.telefono}"><img src="{{ asset('images/sucursal-phone.png') }}" alt="{{ __('arcaddy.sucursales1') }}" class="w-14 h-auto"></a>
										</div>` : '';
						let data = ``;
						if (sucursal.direccion !== null && sucursal.direccion !== '') {
							data += `<div>${sucursal.direccion}</div>`;
						}
						if (sucursal.ciudad !== null && sucursal.ciudad !== '') {
							data += `<div>${sucursal.ciudad}</div>`;
						}
						if (sucursal.horario !== null && sucursal.horario !== '') {
							data += `<div>${sucursal.horario}</div>`;
						}
						$('#sucursales-cercanas').append(`
							<div class="shadow border bg-white rounded-lg">
								<div class="relative rounded-3xl accordeon-link cursor-pointer px-5 py-3 uppercase font-bold">
									<div class="flex flex-row items-center">
										<div class="w-2/3 text-left text-sm">
											${sucursal.nombre}
											<div class="text-xs font-semibold color">${sucursal.distance.toFixed(2)} kms</div>
										</div>
										<div class="ml-auto mr-2">
											<a href="https://www.google.com/maps/dir/?api=1&destination=${sucursal.lat},${sucursal.lng}" target="_blank"><img src="{{ asset('images/sucursal-mapa.png') }}" alt="{{ __('arcaddy.sucursales1') }}" class="w-14 h-auto"></a>
										</div>
										${telefono}
										<div class="absolute top-5 right-3">
											<i class="fa ${icon}"></i>
										</div>
									</div>
								</div>
								<div class="px-5 pb-3 font-semibold text-sm text-left justify-evenly" style="display:${style};">
									${data}
								</div>
							</div>
						`);
						x++;
					});
				}
			}).catch(function(error) {
				console.log(error);
			});
		});
	});
</script>
@endif
