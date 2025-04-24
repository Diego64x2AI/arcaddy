<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Quiz / Resultados
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.quiz.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>

	<div class="py-6">
		<div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
			<div class="bg-white">
				<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-10 items-center mb-10">
					<div class="text-center">
						<img src="{{ asset('storage/'.$cliente->logo) }}" alt="{{ $cliente->cliente }}" class="inline-block w-full h-auto max-w-xs">
					</div>
					<div></div>
					<div>
						<div class="grid grid-cols-1 md:grid-cols-2 items-center">
							<div class="font-extrabold text-pink-600 xl:text-xl uppercase text-center xl:text-start">Total Encuestados</div>
							<div class="font-extrabold md:text-3xl xl:text-5xl text-center">
								{{ $totales }}
							</div>
						</div>
						<div class="flex-row items-center justify-start xl:justify-end mt-5 hidden">
							<a href="javascript:html2pdf(document.getElementById('pdf-container'));" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
								Descargar PDF
							</a>
						</div>
					</div>
				</div>
				<div id="pdf-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
					@foreach ($respuestas as $respuesta)
						<div class="bg-gray-200 px-5 py-8 shadow">
							<div class="font-bold text-end mb-8">{{ str_replace(['open', 'level', 'option', 'like', 'multi', 'versus'], ['Abierta', 'Level Satisfaction', 'Opción', 'Like or Not', 'Multiple', 'VS'], $respuesta['pregunta']->tipo) }}</div>
							<div class="text-pink-600 font-bold text-xl text-center mb-10">
								{{ $respuesta['pregunta']->pregunta }}
							</div>
							@if ($respuesta['pregunta']->tipo === 'open')
								<div class="divide-y divide-zinc-500">
									@foreach ($respuesta['respuestas'] as $item)
										<div class="text-start font-bold py-2">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $item['pregunta_id'], 'respuesta' => $item['respuesta_id']]) }}">{{ $item['respuesta'] }}</a>
										</div>
									@endforeach
								</div>
							@elseif ($respuesta['pregunta']->tipo === 'like')
							<div class="flex flex-col gap-3">
								<div>
									<img src="{{ asset('storage/'.$respuesta['pregunta']->archivo) }}" alt="{{ $respuesta['pregunta']->pregunta }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
								</div>
								<dib class="grid grid-cols-2 items-center gap-1 mt-3 font-semibold">
									<div class="flex flex-row justify-center">

										<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id]) }}" class="rounded-full border-0 border-white like-click bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-3xl items-center p-4">
											<i class="far fa-thumbs-up"></i>
										</a>
									</div>
									<div class="flex flex-row justify-center">
										<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id]) }}" class="rounded-full border-0 border-white dislike-click bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-3xl items-center p-4">
											<i class="far fa-thumbs-down"></i>
										</a>
									</div>
									<div class="flex flex-col items-center text-center justify-center">
										<div>
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id]) }}">
											{{ $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->respuesta }}
											</a>
										</div>
										<div class="mt-3 font-extrabold text-4xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id]) }}">
											{{ (float) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id)->first()?->porcentaje }}%
											</a>
										</div>
										<div class="font-extrabold text-xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id]) }}">
											{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'like')->first()?->id)->first()?->total }}
											</a>
										</div>
									</div>
									<div class="flex flex-col items-center text-center justify-center">
										<div>
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id]) }}">
											{{ $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->respuesta }}
											</a>
										</div>
										<div class="mt-3 font-extrabold text-4xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id]) }}">
											{{ (float) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id)->first()?->porcentaje }}%
											</a>
										</div>
										<div class="font-extrabold text-xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id]) }}">
											{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'dislike')->first()?->id)->first()?->total }}
											</a>
										</div>
									</div>
								</dib>
							</div>
							@elseif ($respuesta['pregunta']->tipo === 'level')
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
							@elseif ($respuesta['pregunta']->tipo === 'versus')
							<div class="flex flex-col gap-3">
								<dib class="grid grid-cols-2 items-center gap-3 font-semibold">
									<div class="flex flex-row justify-center">
										<div class="mb-3 relative">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id]) }}">
											<img src="{{ asset('storage/'.$respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->archivo) }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
											</a>
										</div>
									</div>
									<div class="flex flex-row justify-center">
										<div class="mb-3 relative">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id]) }}">
											<img src="{{ asset('storage/'.$respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->archivo) }}" class="object-cover w-full h-auto border border-secondary shadow rounded-3xl">
											</a>
										</div>
									</div>
									<div class="flex flex-col items-center text-center justify-center">
										<div>
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id]) }}">
											{{ $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->respuesta }}
											</a>
										</div>
										<div class="mt-3 font-extrabold text-4xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id]) }}">
											{{ (float) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id)->first()?->porcentaje }}%
											</a>
										</div>
										<div class="font-extrabold text-xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id]) }}">
											{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus1')->first()?->id)->first()?->total }}
											</a>
										</div>
									</div>
									<div class="flex flex-col items-center text-center justify-center">
										<div>
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id]) }}">
											{{ $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->respuesta }}
											</a>
										</div>
										<div class="mt-3 font-extrabold text-4xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id]) }}">
											{{ (float) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id)->first()?->porcentaje }}%
											</a>
										</div>
										<div class="font-extrabold text-xl">
											<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $respuesta['pregunta'], 'respuesta' => $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id]) }}">
											{{ (int) $respuesta['respuestas']->where('respuesta_id', $respuesta['pregunta']->respuestas->where('tipo', 'versus2')->first()?->id)->first()?->total }}
											</a>
										</div>
									</div>
								</dib>
							</div>
							@elseif ($respuesta['pregunta']->tipo === 'option' || $respuesta['pregunta']->tipo === 'multi')
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
										<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $item['pregunta_id'], 'respuesta' => $item['id']]) }}">{{ $item['respuesta'] }}</a>
									</div>
									<div class="w-[100px] text-center font-bold py-2">
										<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $item['pregunta_id'], 'respuesta' => $item['id']]) }}">{{ $item['total'] }}</a>
									</div>
									<div class="w-[60px] text-center font-bold py-2">
										<a href="{{ route('clientes.quiz.respuestas', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'pregunta' => $item['pregunta_id'], 'respuesta' => $item['id']]) }}">{{ round($item['porcentaje'], 2) }}%</a>
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
		});
	</script>
	@endsection
</x-app-layout>
