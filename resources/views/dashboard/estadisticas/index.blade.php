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
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
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
										<div>{{ number_format($totales['admisiones']) }}</div>
									</div>
									<div class="border-gray-300 p-2 text-center">
										<div class="text-pink-600 font-bold uppercase">Activaciones QR</div>
										<div>{{ number_format($totales['activaciones']) }}</div>
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
								<div class="grid grid-cols-4 items-center font-semibold text-sm mt-5">
									<div class="font-bold truncate col-span-3">
										<a href="{{ $visita->url }}" class="underline" target="_blank">{{ $visita->url }}</a>
									</div>
									<div class="ml-auto">
										<span class="text-pink-600">{{ $visita->total }}</span> visitas
									</div>
								</div>
								@endforeach
							</div>
							<div class="bg-white w-full p-5 mt-5 xl:mt-10 border border-white rounded-3xl">
								<h1 class="text-3xl font-extrabold">Usuarios más activos</h1>
								<div class="grid-cols-1 lg:grid-cols-6 items-center font-semibold text-sm mt-5 hidden lg:grid">
									<div class="font-bold text-xl text-pink-600 truncate lg:col-span-3 text-center lg:text-left">
										Usuario
									</div>
									<div class="font-bold text-xl text-pink-600 text-center">
										Visitas
									</div>
									<div class="font-bold text-xl text-pink-600 text-center">
										Canjes
									</div>
									<div class="font-bold text-xl text-pink-600 text-center">
										Beneficios
									</div>
								</div>
								@foreach ($top_users as $visita)
								@php
									$redencioens_stats = $visita->user->beneficios($visita->cliente_id);
								@endphp
								<div class="grid grid-cols-3 gap-5 lg:grid-cols-6 items-center font-semibold text-sm mt-5">
									<div class="font-bold truncate col-span-3 text-center lg:text-left">
										{{ $visita->user->name }}
									</div>
									<div class="text-center">
										<div>{{ $visita->total }}</div>
										<div class="text-pink-600 lg:hidden">visitas</div>
									</div>
									<div class="text-center">
										<div>{{ $visita->user->canjeados($visita->cliente_id) }}</div>
										<div class="text-pink-600 lg:hidden">canjeos</div>
									</div>
									<div class="text-center">
										<div>{{ $redencioens_stats['ganados'] }} / {{ $redencioens_stats['canjeados'] }}</div>
										<div class="text-pink-600 lg:hidden">beneficios</div>
									</div>
								</div>
								@endforeach
							</div>
							<div class="bg-white w-full p-5 mt-5 xl:mt-10 border border-white rounded-3xl">
								<h1 class="text-3xl font-extrabold mb-5">Canjes</h1>
								@foreach ($canjes as $producto)
								<div class="grid grid-cols-4 gap-5 items-start border-b border-gray-300 py-3">
									<div class="col-span-1 font-bold text-xl">
										<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" alt="{{ $producto->nombre }}" class="w-full h-auto shadow border">
									</div>
									<div class="col-span-3 font-semibold text-xl">
										<div>{{ $producto->nombre }}</div>
										<div class="text-sm text-gray-500">{{ $producto->descripcion }}</div>
										<div class="mt-4 text-sm">
											<span class="text-pink-600">Canjes totales:</span> {{ $producto->canjeados->count() }}
										</div>
										@if ($producto->canjeados()->orderBy('id', 'desc')->take(3)->count() > 0)
											<div class="mt-2 text-sm">Últimos canjes:</div>
											<ul>
												@foreach ($producto->canjeados()->orderBy('id', 'desc')->take(3)->get() as $canje)
													<li class="text-sm">
														{{ $canje->user->name }} - {{ $canje->created_at->format('d/m/Y H:i') }}
													</li>
												@endforeach
											</ul>
										@endif
									</div>
								</div>
								@endforeach
							</div>
							<div class="bg-white w-full p-5 mt-5 xl:mt-10 border border-white rounded-3xl">
								<h1 class="text-3xl font-extrabold mb-5">Beneficios</h1>
								@foreach ($beneficios as $producto)
								<div class="grid grid-cols-4 gap-5 items-start border-b border-gray-300 py-3">
									<div class="col-span-1 font-bold text-xl">
										<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" alt="{{ $producto->nombre }}" class="w-full h-auto shadow border">
									</div>
									<div class="col-span-3 font-semibold text-xl">
										<div>{{ $producto->nombre }}</div>
										<div class="text-sm text-gray-500">{{ $producto->descripcion }}</div>
										<div class="mt-4 text-sm">
											<span class="text-pink-600">Stock actual:</span> {{ ($producto->cantidad === -1) ? 'Ilimitado' : $producto->cantidad }}
										</div>
										<div class="mt-0 text-sm">
											<span class="text-pink-600">Canjes totales:</span> {{ $producto->beneficios()->where('canjeado', 1)->count() }}
										</div>
										@if ($producto->beneficios()->where('canjeado', 1)->orderBy('id', 'desc')->take(3)->count() > 0)
											<div class="mt-2 text-sm">Últimos canjes:</div>
											<ul>
												@foreach ($producto->beneficios()->where('canjeado', 1)->orderBy('id', 'desc')->take(3)->get() as $canje)
													<li class="text-sm">
														{{ $canje->user->name }} - {{ $canje->created_at->format('d/m/Y H:i') }}
													</li>
												@endforeach
											</ul>
										@endif
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
							@if($sucursales->count() > 0)
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
							@endif
						</div>
					</div>
					@if ($quiz !== NULL)
					<h1 class="text-3xl font-extrabold my-5 lg:my-10">Quiz Actual:</h1>
					<h3 class="text-xl font-extrabold my-5">{{ $quiz->nombre }} <span class="text-pink-600">({{ $quiz_totales }} respuestas)</span></h3>
					<div id="pdf-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
						@foreach ($quiz_respuestas as $respuesta)
							<div class="bg-gray-200 px-5 py-8 shadow">
								<div class="font-bold text-end mb-8">{{ str_replace(['open', 'level', 'option', 'like', 'multi', 'versus'], ['Abierta', 'Level Satisfaction', 'Opción', 'Like or Not', 'Multiple', 'VS'], $respuesta['pregunta']->tipo) }}</div>
								<div class="text-pink-600 font-bold text-xl text-center mb-10">
									{{ $respuesta['pregunta']->pregunta }}
								</div>
								@if ($respuesta['pregunta']->tipo == 'open')
									<div class="divide-y divide-zinc-500">
										@foreach ($respuesta['respuestas'] as $item)
											<div class="text-start font-bold py-2">
												{{ $item['respuesta'] }}
											</div>
										@endforeach
									</div>
								@elseif ($respuesta['pregunta']->tipo == 'like')
								<div class="flex flex-col gap-3">
									<div>
										<img src="{{ asset('storage/'.$respuesta['pregunta']->archivo) }}" alt="{{ $respuesta['pregunta']->pregunta }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
									</div>
									<dib class="grid grid-cols-2 items-center gap-1 mt-3 font-semibold">
										<div class="flex flex-row justify-center">
											<a href="javascript:void(0);" class="rounded-full cursor-default border-0 border-white like-click bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-3xl items-center p-4">
												<i class="far fa-thumbs-up"></i>
											</a>
										</div>
										<div class="flex flex-row justify-center">
											<a href="javascript:void(0);" class="rounded-full cursor-default border-0 border-white dislike-click bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-3xl items-center p-4">
												<i class="far fa-thumbs-down"></i>
											</a>
										</div>
										<div class="flex flex-col items-center text-center justify-center">
											<div>{{ $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->respuesta }}</div>
											<div class="mt-3 font-extrabold text-4xl">
												{{ (float) round($respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id)->first()?->porcentaje, 2) }}%
											</div>
											<div class="font-extrabold text-xl">
												{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id)->first()?->total }}
											</div>
										</div>
										<div class="flex flex-col items-center text-center justify-center">
											<div>{{ $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->respuesta }}</div>
											<div class="mt-3 font-extrabold text-4xl">
												{{ (float) round($respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id)->first()?->porcentaje, 2) }}%
											</div>
											<div class="font-extrabold text-xl">
												{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id)->first()?->total }}
											</div>
										</div>
									</dib>
								</div>
								@elseif ($respuesta['pregunta']->tipo == 'level')
								<div class="flex flex-col gap-3">
									@if($respuesta['pregunta']->archivo !== NULL)
									<div>
										<img src="{{ asset('storage/'.$respuesta['pregunta']->archivo) }}" alt="{{ $respuesta['pregunta']->pregunta }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
									</div>
									@endif
									<div>
										<div data-value="{{ round($respuesta['promedio'], 2) }}" class="mt-5 slider-level"></div>
									</div>
									<dib class="grid grid-cols-3 items-center gap-3 mt-6 font-semibold">
										<div class="text-start">
											{{ $respuesta['pregunta']->respuestas->where('tipo', 'low')->first()?->respuesta }}
										</div>
										<div class="font-extrabold text-4xl text-center">
											{{ round(($respuesta['promedio'] * 10), 2) }}%
										</div>
										<div class="text-end">
											{{ $respuesta['pregunta']->respuestas->where('tipo', 'high')->first()?->respuesta }}
										</div>
									</dib>
								</div>
								@elseif ($respuesta['pregunta']->tipo == 'versus')
								<div class="flex flex-col gap-3">
									<dib class="grid grid-cols-2 items-center gap-3 font-semibold">
										<div class="flex flex-row justify-center">
											<div class="mb-3 relative">
												<img src="{{ asset('storage/'.$respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->archivo) }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
											</div>
										</div>
										<div class="flex flex-row justify-center">
											<div class="mb-3 relative">
												<img src="{{ asset('storage/'.$respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->archivo) }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
											</div>
										</div>
										<div class="flex flex-col items-center text-center justify-center">
											<div>{{ $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->respuesta }}</div>
											<div class="mt-3 font-extrabold text-4xl">
												{{ (float) round($respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id)->first()?->porcentaje, 2) }}%
											</div>
											<div class="font-extrabold text-xl">
												{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id)->first()?->total }}
											</div>
										</div>
										<div class="flex flex-col items-center text-center justify-center">
											<div>{{ $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->respuesta }}</div>
											<div class="mt-3 font-extrabold text-4xl">
												{{ (float) round($respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id)->first()?->porcentaje, 2) }}%
											</div>
											<div class="font-extrabold text-xl">
												{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id)->first()?->total }}
											</div>
										</div>
									</dib>
								</div>
								@elseif ($respuesta['pregunta']->tipo == 'option' || $respuesta['pregunta']->tipo == 'multi')
								<div class="">
									<div class="flex flex-row items-center gap-5 font-bold">
										<div class="grow">&nbsp;</div>
										<div class="w-[100px] text-center">Cantidad</div>
										<div class="w-[60px] text-center">%</div>
									</div>
									<div class="divide-y divide-zinc-500">
									@foreach ($respuesta['respuestas'] as $item)
									<div class="flex flex-row items-center gap-5 font-bold">
										<div class="text-start font-bold py-2 grow truncate">
											{{ $item['respuesta'] }}
										</div>
										<div class="w-[100px] text-center font-bold py-2">
											{{ $item['total'] }}
										</div>
										<div class="w-[60px] text-center font-bold py-2">
											{{ round($item['porcentaje'], 2) }}%
										</div>
									</div>
									@endforeach
									</div>
									<div>
										<canvas class="pie-chart" data-json="{{ json_encode($respuesta['dataset'] ?? []) }}"></canvas>
									</div>
								</div>
								@endif
							</div>
						@endforeach
					</div>
					@endif
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
	<style>
		.slider-level {
    	height: 15px;
			border-radius: 25px;
			border: 1px solid #D3D3D3;
			background-color: #cfd2d8;
			box-shadow: inset 0 1px 1px #F0F0F0, 0 3px 6px -5px #BBB;
		}
		.noUi-handle:before {
			content: "";
			display: block;
			position: absolute;
			height: 20px;
			width: 1px;
			background: #E8E7E6;
			left: 15px;
			top: 8px;
		}
		.noUi-connects {
			border-radius: 25px;
			overflow: hidden;
		}
		.noUi-handle:after {
			content: "";
			display: block;
			position: absolute;
			height: 20px;
			width: 1px;
			background: #E8E7E6;
			left: 20px;
			top: 8px;
		}
		.slider-level .noUi-connect {
			background: #db2777;
			border-radius: 25px;
		}
		.slider-level .noUi-handle {
			height: 38px;
			width: 38px;
			top: -15px;
			right: -17px; /* half the width */
			border-radius: 50%;
		}
		[disabled].noUi-target, [disabled].noUi-handle, [disabled] .noUi-handle {
    	cursor: default;
		}
	</style>
	<!-- prettier-ignore -->
	<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
		({key: "AIzaSyBxLFY8L9duiFmTS_zqgTPywfW4iiwMUVM", v: "weekly"});</script>
	 <script>
		document.addEventListener('DOMContentLoaded', function load() {
			if (!window.jQuery) return setTimeout(load, 50);
			console.log(`stats load`);
			$('.pie-chart').each(function(){
				const pieChart = this;
				const ctx = pieChart.getContext('2d');
				const data = JSON.parse(pieChart.dataset.json);
				const labels = data.labels;
				const values = data.data;
				new Chart(ctx, {
					type: 'doughnut',
					data: {
						labels: labels,
						datasets: [{
							data: values,
							// backgroundColor: colors
						}]
					},
					options: {
						responsive: true,
						plugins: {
							legend: {
								display: true,
								position: 'bottom',
							}
						}
					}
				});
			});
			$('.slider-level').each(function(){
				const levelSlider = this;
				noUiSlider.create(levelSlider, {
					start: 0,
					// step: 1,
					connect: 'lower',
					tooltips: false,
					range: {
						'min': 0,
						'max': 10
					}
				});
				levelSlider.noUiSlider.disable();
				setTimeout(() => {
					levelSlider.noUiSlider.set($(levelSlider).data('value'));
				}, 100);
				/*
				levelSlider.noUiSlider.on('update', function (values, handle) {
					console.log(values[handle]);
				});
				*/
			});
			@if ($sucursales->count() > 0)

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
			@endif
		});
	</script>
	@endsection
</x-app-layout>
