<x-app-layout>
	<x-slot name="header">
		<div class="flex flex-row items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Estadísticas
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('dashboard') }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<div class="py-6 bg-gray-50">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div>
				<div class="text-center">
					<img src="{{ asset('storage/'.$cliente->logo) }}" alt="{{ $cliente->cliente }}" class="inline-block w-full h-auto max-w-xs">
				</div>
				<div class="text-center font-semibold">
					{{ $cliente->cliente }}
				</div>
				<div>
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
					<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 xl:gap-16 mt-10">
						<div>
							<div class="bg-white w-full p-5 border border-white rounded-3xl">
								<h1 class="text-3xl font-extrabold">General perfomance</h1>
								<div class="grid grid-cols-2 font-semibold text-sm mt-5">
									<div class="border-b border-gray-300 p-2 border-r px-2 text-center">
										<div class="text-pink-600 font-bold uppercase">Visitas</div>
										<div>{{ number_format($totales['visitas']) }}</div>
									</div>
									<div class="border-b border-gray-300 p-2 text-center">
										<div class="text-pink-600 font-bold uppercase">Usuarios</div>
										<div>{{ number_format($totales['usuarios']) }}</div>
									</div>
									<div class="border-b border-gray-300 p-2 border-r text-center">
										<div class="text-pink-600 font-bold uppercase">Redenciones</div>
										<div>{{ number_format($totales['redenciones']) }}</div>
									</div>
									<div class="border-b border-gray-300 p-2 text-center">
										<div class="text-pink-600 font-bold uppercase">Productos</div>
										<div>{{ number_format($totales['productos']) }}</div>
									</div>
									<div class="border-gray-300 p-2 border-r text-center">
										<div class="text-pink-600 font-bold uppercase">Admisiones</div>
										<div>1,130,000</div>
									</div>
									<div class="border-gray-300 p-2 text-center">
										<div class="text-pink-600 font-bold uppercase">Activaciones QR</div>
										<div>1,130,000</div>
									</div>
								</div>
							</div>

							<div class="bg-white w-full p-5 border border-white rounded-3xl mt-5 lg:mt-10">
								<h1 class="text-3xl font-extrabold text-center">Marcos</h1>
								<div class="my-5 grid grid-cols-2">
									<div>
										<div class="text-center font-bold text-pink-600 uppercase">Compartidos</div>
										<div class="text-center font-bold">{{ $marcos_compartidos }}</div>
									</div>
									<div>
										<div class="text-center font-bold text-pink-600 uppercase">Subidos</div>
										<div class="text-center font-bold">{{ $marcos_subidos }}</div>
									</div>
								</div>
								<div class="grid grid-cols-3">
									@foreach ($marcos as $galeria)
										<div>
											<img src="{{ asset('storage/'.$galeria->archivo) }}" alt="{{ $galeria->titulo }}" class="w-full h-auto">
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="lg:col-span-2">
							<div class="bg-white w-full p-5 border border-white rounded-3xl">
								<h1 class="text-3xl font-extrabold">Páginas más visitadas</h1>
								@foreach ($visitas as $visita)
								<div class="flex flex-row items-center font-semibold text-sm mt-5">
									<div class="font-bold">
										<a href="{{ $visita->url }}" class="underline" target="_blank">{{ $visita->url }}</a>
									</div>
									<div class="ml-auto">
										<span class="text-pink-600">{{ $visita->total }}</span> visitas
									</div>
								</div>
								@endforeach
							</div>
							<div class="grid grid-cols-1 lg:grid-cols-2 mt-5 xl:mt-10 gap-10 xl:gap-16">
								<div class="bg-white w-full p-5 border border-white rounded-3xl">
									<h1 class="text-3xl font-extrabold">Links QR's</h1>
									@foreach ($qrlinks as $link)
									<div class="flex flex-row items-center font-semibold text-sm mt-5">
										<div class="font-bold">
											<a href="{{ route('cliente_seccion', ['slug' => $link->cliente->slug, 'slug2' => $link->slug]) }}" class="underline" target="_blank">{{ $link->titulo }}</a>
										</div>
										<div class="ml-auto">
											<span class="text-pink-600">{{ $link->lecturas }}</span> lecturas
										</div>
									</div>
									@endforeach
								</div>
								<div class="bg-white w-full p-5 border border-white rounded-3xl">
									<h1 class="text-3xl font-extrabold">Secciones AR's</h1>
									@foreach ($realidades as $link)
									<div class="flex flex-row items-center font-semibold text-sm mt-5">
										<div class="font-bold">
											<a href="{{ route('cliente_ar', ['slug' => $link->cliente->slug, 'slug2' => $link->slug]) }}" class="underline" target="_blank">{{ $link->titulo }}</a>
										</div>
										<div class="ml-auto">
											<span class="text-pink-600">{{ $link->lecturas }}</span> lecturas
										</div>
									</div>
									@endforeach
								</div>
							</div>
							<div class="bg-white w-full p-5 border border-white rounded-3xl mt-5 xl:mt-10">
								<h1 class="text-3xl font-extrabold">Sucursales</h1>
								<div>
									<div class="lg:col-span-3">
										@foreach ($sucursales as $sucursal)
											<div class="flex flex-row items-center font-semibold text-sm mt-5">
												<div class="font-bold">
													{{ $sucursal->nombre }}
												</div>
												<div class="ml-auto">
													<span class="text-pink-600">{{ $sucursal->lecturas }}</span> lecturas
												</div>
											</div>
											@endforeach
									</div>
									<div class="mt-5">
										<div id="map" class="w-full h-[40vh]"></div>
									</div>
								</div>
							</div>

						</div>
					</div>
					@if(!empty($games))
					<h1 class="text-3xl font-extrabold my-5 lg:my-10">Score Games</h1>
					<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
						@foreach ($games as $game)
						<div class="bg-white w-full p-5 border border-white rounded-3xl">
							<div class="flex flex-row items-center">
								<div>
									<h1 class="text-xl font-extrabold">{{ $game['nombre'] }}</h1>
								</div>
								<div class="ml-auto">
									<span class="text-pink-600">{{ $game['visitas'] }}</span> visitas
								</div>
							</div>
							<div class="mt-5">
								@foreach ($game['scores'] as $score)
								@php
								$style = ($loop->iteration === 1) ? ' style="background-color: '.$cliente->color_base.'; color: '.$cliente->color_bg.';"' : '';
								@endphp
								<div class="flex flex-row items-center mb-2">
									<div class="color font-bold text-2xl text-center w-5">{{ $loop->iteration }}</div>
									<div class="flex flex-row grow ml-2 items-center px-3 py-2 rounded-3xl"{!! $style !!}>
										{{--<div><img src="{{ asset('images/Imagen 73.jpg') }}" class="w-10 h-10 rounded-full" alt="Juan Carlos Perez"></div>--}}
										<div class="grow text-left ml-2 font-semibold text-xs md:text-normal">{{ $score->user->name }}</div>
										<div class="ml-auto font-extrabold text-xl">{{ $score->tiempo }} {{ __('arcaddy.seconds') }}</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
						@endforeach
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	@section('js')
	<!-- prettier-ignore -->
	<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
		({key: "AIzaSyDl98_79CXXgbwn8UQflos9q_QAJO44Mlw", v: "weekly"});</script>
	 <script>
		window.addEventListener('load', function() {
			init();
			let map;
			let marker;

			async function init() {
				console.log('init');
				const { Map } = await google.maps.importLibrary("maps");

				map = new Map(document.getElementById("map"), {
					center: { lat: 22.909155, lng: -102.450886 },
					zoom: 5,
				});
				let bounds = new google.maps.LatLngBounds();

				@foreach ($sucursales as $sucursal)
					marker = new google.maps.Marker({
						position: { lat: {{ $sucursal->lat }}, lng: {{ $sucursal->lng }} },
						map,
						title: '{{ $sucursal->nombre }}',
						icon: {
							url: `{{ ($cliente->sucursales_pin !== NULL) ? asset('storage/'.$cliente->sucursales_pin) : asset('images/sucursal-pin.png') }}`,
							scaledSize: new google.maps.Size(60, 60),
						},
					});
					bounds.extend({ lat: {{ $sucursal->lat }}, lng: {{ $sucursal->lng }} });

				@endforeach
				map.fitBounds(bounds);
			}
		});
	</script>
	@endsection
</x-app-layout>
