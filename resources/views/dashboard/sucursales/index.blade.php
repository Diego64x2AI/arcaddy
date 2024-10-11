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
											<img src="{{ ($cliente->sucursales_pin !== NULL) ? asset('storage/'.$cliente->sucursales_pin) : asset('images/sucursal-pin.png') }}" alt="{{ $sucursal->nombre }}" class="inline-block w-16 h-auto">
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
							<div id="map" class="w-full h-[50vh]"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@section('js')
	<!-- prettier-ignore -->
	<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
		({key: "AIzaSyDl98_79CXXgbwn8UQflos9q_QAJO44Mlw", v: "weekly"});</script>
	<script>
		const url = '{{ url('dashboard/cliente/'.$cliente->id.'/quiz') }}';
		window.addEventListener('load', function() {
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
