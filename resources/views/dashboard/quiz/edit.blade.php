<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Quiz / Preguntas
				</h2>
			</div>
			<div class="ml-auto">
				<a href="{{ route('cliente.quiz.index', ['cliente' => $cliente->id]) }}" class="rounded-full bg-pink-600 text-white px-5 py-2 block">
					Regresar
				</a>
			</div>
		</div>
	</x-slot>
	<form id="quiz-form" action="{{ route('cliente.quiz.update', ['cliente' => $cliente->id, 'quiz' => $quiz->id]) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="py-6">
			<div class="max-w-7xl mx-auto px-5">
				<div class="bg-white">
					<div class="bg-white border border-white">
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
						<div id="preguntas-container" class="container-draggable mt-5 section-box">
							@if ($quiz->preguntas->count() > 0)
							@foreach ($quiz->preguntas as $key => $pregunta)
							@php
								$option_abierta = false;
								$option_abierta2 = false;
								$img = 'https://placehold.co/600x400/FFFFFF/acacac/png?text=Cargar%20imagen';
								$versus1 = 'https://placehold.co/600x400/FFFFFF/acacac/png?text=Cargar%20imagen';
								$versus2 = 'https://placehold.co/600x400/FFFFFF/acacac/png?text=Cargar%20imagen';
								if ($pregunta->archivo !== NULL && $pregunta->archivo !== '') {
									$img = asset('storage/'.$pregunta->archivo);
								}
								if ($pregunta->respuestas()->where('tipo', 'like', 'versus%')->count() > 0) {
									$versus1 = asset('storage/'.$pregunta->respuestas->where('tipo', 'versus1')->first()->archivo);
									$versus2 = asset('storage/'.$pregunta->respuestas->where('tipo', 'versus2')->first()->archivo);
								}
							@endphp
							<div class="w-2/4 md:w-1/3 float-left bg-white hover:bg-gray-100 hover:shadow pregunta-box h-fit group">
								<div class="p-3 flex flex-col h-full">
									<div class="flex flex-row items-center mb-3">
										<div class="font-bold text-2xl">Tipo</div>
										<div class="mx-auto">
											<input type="hidden" name="pregunta_id[{{ $key }}]" value="{{ $pregunta->id }}">
											<select name="tipo[{{ $key }}]" class="question-type input-underline !border !shadow !rounded-3xl !px-4 !min-w-[130px]" required>
												<option value="open" @if(old('tipo.'.$key, $pregunta->tipo) === 'open') selected @endif>Abierta</option>
												<option value="option" @if(old('tipo.'.$key, $pregunta->tipo) === 'option') selected @endif>Opción</option>
												<option value="multi" @if(old('tipo.'.$key, $pregunta->tipo) === 'multi') selected @endif>Multiple</option>
												<option value="like" @if(old('tipo.'.$key, $pregunta->tipo) === 'like') selected @endif>Like or Not</option>
												<option value="level" @if(old('tipo.'.$key, $pregunta->tipo) === 'level') selected @endif>Level Satisf</option>
												<option value="versus" @if(old('tipo0'.$key, $pregunta->tipo) === 'versus') selected @endif>VS</option>
											</select>
										</div>
										<div>
											<input type="text" name="valor[{{ $key }}]" value="{{ old('valor.'.$key, $pregunta->valor) }}" class="input-underline !border !shadow !rounded-3xl !px-4 !w-[80px] text-center" placeholder="Valor" required>
										</div>
									</div>
									<div class="mb-8">
										<input type="text" name="pregunta[{{ $key }}]" value="{{ old('pregunta.'.$key, $pregunta->pregunta) }}" class="input-underline !border !shadow !rounded-3xl !px-4 !py-2 !text-xl font-bold placeholder:!text-pink-600" placeholder="Pregunta" required>
									</div>
									<div class="mb-3 relative option-section question-section hidden">
										<div class="text-end font-bold text-sm">Correcta</div>
										<div class="respuestas mt-1 space-y-3">
											@foreach ($pregunta->respuestas->where('tipo', 'option') as $index => $respuesta)
											@php
												if (!$option_abierta && $respuesta->respuesta === 'Otra...') {
													$option_abierta = true;
												}
											@endphp
											<div class="flex flex-row items-center">
												<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
												<div class="ml-3 grow">
													<input type="text" name="respuesta[{{ $key }}][]" value="{{ old('respuesta.'.$key.'.'.$index, $respuesta->respuesta) }}" class="input-underline w-full" placeholder="Respuesta" @if($respuesta->respuesta === 'Otra...') disabled @endif required>
													<input type="hidden" name="respuesta_id[{{ $key }}][]" value="{{ $respuesta->id }}" class="input-underline w-full">
												</div>
												<div class="ml-3">
													<input type="radio" name="correcta[{{ $key }}]" class="accent-green-500 appearance-none" value="{{ $index }}" @if($respuesta->correcta) checked @endif>
												</div>
											</div>
											@endforeach
										</div>
										<div class="grid grid-cols-2 gap-4 mt-3">
											<div>
												<a href="javascript:void(0);" class="add-abierta btn-pill3 !bg-zinc-800 !text-white w-full text-center" @if($option_abierta) style="display:none;" @endif>+ OTRA (abierta)</a>
											</div>
											<div>
												<a href="javascript:void(0);" class="add-respuesta btn-pill3 !bg-pink-600 !text-white w-full text-center">+ RESPUESTA</a>
											</div>
										</div>
									</div>
									<div class="mb-3 relative multi-section question-section hidden">
										<div class="text-end font-bold text-sm">Correcta</div>
										<div class="respuestas mt-1 space-y-3">
											@foreach ($pregunta->respuestas->where('tipo', 'multi') as $index => $respuesta)
											@php
												if (!$option_abierta2 && $respuesta->respuesta === 'Otra...') {
													$option_abierta2 = true;
												}
											@endphp
											<div class="flex flex-row items-center">
												<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
												<div class="ml-3 grow">
													<input type="text" name="respuesta2[{{ $key }}][]" value="{{ old('respuesta.'.$key.'.'.$index, $respuesta->respuesta) }}" class="input-underline w-full" placeholder="Respuesta" @if($respuesta->respuesta === 'Otra...') disabled @endif required>
													<input type="hidden" name="respuesta2_id[{{ $key }}][]" value="{{ $respuesta->id }}" class="input-underline w-full">
												</div>
												<div class="ml-3">
													<input type="checkbox" name="correcta2[{{ $key }}][]" class="accent-green-500 appearance-none" value="{{ $index }}" @if($respuesta->correcta) checked @endif>
												</div>
											</div>
											@endforeach
										</div>
										<div class="grid grid-cols-2 gap-4 mt-3">
											<div>
												<a href="javascript:void(0);" class="add-abierta-multi btn-pill3 !bg-zinc-800 !text-white w-full text-center" @if($option_abierta2) style="display:none;" @endif>+ OTRA (abierta)</a>
											</div>
											<div>
												<a href="javascript:void(0);" class="add-respuesta-multi btn-pill3 !bg-pink-600 !text-white w-full text-center">+ RESPUESTA</a>
											</div>
										</div>
									</div>
									<div class="mb-3 relative like-section question-section level-section hidden px-8">
										<img src="{{ $img }}" class="img-general object-cover w-100 border border-secondary shadow rounded-3xl">
										<div class="examinar-img group-hover:block shadow">
											<div><button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 text-xs inline-block">Examinar...</button>
											</div>
											<small class="examinar-size text-gray-400 text-xs">(jpg 1000x1000px)</small>
											<input type="hidden" name="archivo_old[{{ $key }}]" value="{{ $pregunta->archivo }}" />
											<input type="file" name="archivo_img[{{ $key }}]" class="file-general" accept="image/*" style="display:none" />
										</div>
									</div>
									<div class="mb-3 level-section question-section hidden">
										<div>
											<input id="steps-range" type="range" min="0" max="10" value="5" step="1" disabled class="range-slider">
										</div>
										<div class="grid grid-cols-2 gap-5 mt-2">
											<div>
												<input type="text" name="level-low[{{ $key }}]" value="{{ old('level-low.'.$key, $pregunta->respuestas->where('tipo', 'low')->first()?->respuesta) }}" placeholder="Pésimo" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
											</div>
											<div>
												<input type="text" name="level-high[{{ $key }}]" value="{{ old('level-high.'.$key, $pregunta->respuestas->where('tipo', 'high')->first()?->respuesta) }}" placeholder="Excelente" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
											</div>
										</div>
									</div>
									<div class="mb-3 versus-section question-section hidden">
										<dib class="grid grid-cols-2 items-center gap-3">
											<div class="flex flex-row justify-center">
												<div class="mb-3 relative">
													<img src="{{ $versus1 }}" class="img-general object-cover w-full h-auto border border-secondary shadow rounded-3xl">
													<div class="examinar-img group-hover:block shadow !-ml-[50px] !-mt-[22px]">
														<div class="flex flex-row justify-center">
															<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-2 py-1 text-xs inline-block">Examinar...</button>
														</div>
														<input type="hidden" name="versus1_old[{{ $key }}]" value="{{ $pregunta->respuestas->where('tipo', 'versus1')->first()?->archivo }}" />
														<input type="file" name="versus1_img[{{ $key }}]" class="file-general" accept="image/*" style="display:none" />
													</div>
												</div>
											</div>
											<div class="flex flex-row justify-center">
												<div class="mb-3 relative">
													<img src="{{ $versus2 }}" class="img-general object-cover w-full h-auto border border-secondary shadow rounded-3xl">
													<div class="examinar-img group-hover:block shadow !-ml-[50px] !-mt-[22px]">
														<div class="flex flex-row justify-center">
															<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-2 py-1 text-xs inline-block">Examinar...</button>
														</div>
														<input type="hidden" name="versus2_old[{{ $key }}]" value="{{ $pregunta->respuestas->where('tipo', 'versus2')->first()?->archivo }}" />
														<input type="file" name="versus2_img[{{ $key }}]" class="file-general" accept="image/*" style="display:none" />
													</div>
												</div>
											</div>
											<div class="flex flex-row justify-center">
												<input type="text" name="versus1-text[{{ $key }}]" value="{{ old('versus1-text.'.$key, $pregunta->respuestas->where('tipo', 'versus1')->first()?->respuesta) }}" placeholder="Descripción" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
											</div>
											<div class="flex flex-row justify-center">
												<input type="text" name="versus2-text[{{ $key }}]" value="{{ old('versus2-text.'.$key, $pregunta->respuestas->where('tipo', 'versus2')->first()?->respuesta) }}" placeholder="Descripción" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
											</div>
											<div class="flex flex-row justify-center">
												<input type="radio" name="versus-correcta[{{ $key }}]" value="1" @if($pregunta->respuestas->where('tipo', 'versus1')->first()?->correcta)  checked @endif>
											</div>
											<div class="flex flex-row justify-center">
												<input type="radio" name="versus-correcta[{{ $key }}]" value="2" @if($pregunta->respuestas->where('tipo', 'versus2')->first()?->correcta)  checked @endif>
											</div>
										</dib>
									</div>
									<div class="mb-3 like-section question-section hidden">
										<dib class="grid grid-cols-3 items-center gap-3">
											<div class="flex flex-row justify-center">
												<label for="like-icons-{{ $key }}" class="flex items-center cursor-pointer">
													<div class="relative">
														<input id="like-icons-{{ $key }}" name="iconos[{{ $key }}]" type="checkbox" class="sr-only" @if(old('iconos.'.$key, $pregunta->iconos)) checked @endif />
														<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
														<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
													</div>
												</label>
											</div>
											<div class="flex flex-row justify-center">
												<a href="javascript:void(0);" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-xl items-center p-5 w-4 h-4">
													<i class="far fa-thumbs-up"></i>
												</a>
											</div>
											<div class="flex flex-row justify-center">
												<a href="javascript:void(0);" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-xl items-center p-5 w-4 h-4">
													<i class="far fa-thumbs-down"></i>
												</a>
											</div>
											<div class="text-sm font-bold flex flex-row justify-center">
												&nbsp;
											</div>
											<div class="flex flex-row justify-center">
												<input type="text" name="like-text[{{ $key }}]" value="{{ old('like-text.'.$key, $pregunta->respuestas->where('tipo', 'like')->first()?->respuesta) }}" placeholder="SÍ" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
											</div>
											<div class="flex flex-row justify-center">
												<input type="text" name="dislike-text[{{ $key }}]" value="{{ old('dislike-text.'.$key, $pregunta->respuestas->where('tipo', 'dislike')->first()?->respuesta) }}" placeholder="NO" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
											</div>
											<div class="text-sm font-bold flex flex-row justify-center">
												Correcta
											</div>
											<div class="flex flex-row justify-center">
												<input type="radio" name="like-correcta[{{ $key }}]" value="1" @if($pregunta->respuestas->where('tipo', 'like')->first()?->correcta) checked @endif>
											</div>
											<div class="flex flex-row justify-center">
												<input type="radio" name="like-correcta[{{ $key }}]" value="2" @if($pregunta->respuestas->where('tipo', 'dislike')->first()?->correcta) checked @endif>
											</div>
										</dib>
									</div>
									<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between mt-auto">
										<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
										<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
													class="fas fa-trash-alt"></i></a></div>
									</div>
								</div>
							</div>
							@endforeach
							@endif
						</div>
						<div class="flex flex-col justify-center items-center mt-10 mb-10">
							<a href="javascript:void(0);" class="add-question rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center items-center p-5 text-xs lg:text-base w-[6rem] h-[6rem] lg:w-[9rem] lg:h-[9rem]">
								<div class="text-2xl lg:text-5xl font-bold">+</div>
								<div>Agregar</div>
								<div>pregunta</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="fixed top-20 right-0">
			<button type="submit" class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white w-12 h-12"><i class="fa fa-save"></i></button>
		</div>
	</form>
	@section('js')
	<script>
		let currentQuestions = {{ $quiz->preguntas->count()-1 }};
		window.addEventListener('load', function() {
			new Sortable($('#preguntas-container')[0], {
				handle: '.handler',
				animation: 150,
				direction: 'horizontal',
			});
			$('#preguntas-container .respuestas').each(function (index, item) {
				new Sortable(item, {
					handle: '.handler2',
					animation: 150,
					direction: 'vertical',
					onEnd: function (evt) {
						console.log('onEnd', evt);
						// rearrange the radio buttons
						$(evt.from).find('input[type=radio]').each(function (index, item) {
							console.log('index', index, item);
							$(item).val(index);
						});
						// rearrange the checkbox buttons
						$(evt.from).find('input[type=checkbox]').each(function (index, item) {
							console.log('index', index, item);
							$(item).val(index);
						});
						console.log(evt.from);
					}
				});
			});
			$('form#quiz-form').submit(function(){
				// find disabled inputs, and remove the "disabled" attribute
				var disabled = $(this).find(':input:disabled').removeAttr('disabled');
			});
			$('body').on('click', '.add-respuesta', function(e) {
				e.preventDefault();
				const $container = $(this).parent().parent().parent().find('.respuestas');
				const index = $(this).parent().parent().parent().parent().parent().index();
				// mark the first as checked
				const checked = ($container.find('.option-answer').length === 0) ? ' checked' : '';
				let html = `
					<div class="flex flex-row items-center option-answer">
						<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="ml-3 grow">
							<input type="text" name="respuesta[${index}][]" class="input-underline w-full" placeholder="Respuesta">
							<input type="hidden" name="respuesta_id[${index}][]" value="0" class="input-underline w-full">
						</div>
						<div class="ml-3">
							<input type="radio" name="correcta[${index}]" class="accent-green-500 appearance-none" value="${$container.find('.flex').length}"${checked}>
						</div>
					</div>
				`;
				$container.append(html);
				// console.log('click2', $container, $container.find('.flex').length);
			});
			$('body').on('click', '.add-abierta', function(e) {
				e.preventDefault();
				// get the question index
				const index = $(this).parent().parent().parent().parent().parent().index();
				$(this).hide();
				const $container = $(this).parent().parent().parent().find('.respuestas');
				// mark the first as checked
				const checked = ($container.find('.option-answer').length === 0) ? ' checked' : '';
				let html = `
					<div class="flex flex-row items-center option-answer">
						<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="ml-3 grow">
							<input type="text" name="respuesta[${index}][]" disabled class="input-underline w-full" value="Otra...">
							<input type="hidden" name="respuesta_id[${index}][]" value="0" class="input-underline w-full">
						</div>
						<div class="ml-3">
							<input type="radio" name="correcta[${index}]" class="accent-green-500 appearance-none" value="${$container.find('.flex').length}"${checked}>
						</div>
					</div>
				`;
				$container.append(html);
			});
			$('body').on('click', '.add-respuesta-multi', function(e) {
				e.preventDefault();
				const $container = $(this).parent().parent().parent().find('.respuestas');
				const index = $(this).parent().parent().parent().parent().parent().index();
				let html = `
					<div class="flex flex-row items-center option-answer">
						<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="ml-3 grow">
							<input type="text" name="respuesta2[${index}][]" class="input-underline w-full" placeholder="Respuesta" required>
							<input type="hidden" name="respuesta2_id[${index}][]" value="0" class="input-underline w-full">
						</div>
						<div class="ml-3">
							<input type="checkbox" name="correcta2[${index}][]" class="accent-green-500 appearance-none" value="${$container.find('.flex').length}" checked>
						</div>
					</div>
				`;
				$container.append(html);
				// console.log('click2', $container, $container.find('.flex').length);
			});
			$('body').on('click', '.add-abierta-multi', function(e) {
				e.preventDefault();
				// get the question index
				const index = $(this).parent().parent().parent().parent().parent().index();
				console.log('index', index);
				$(this).hide();
				const $container = $(this).parent().parent().parent().find('.respuestas');
				let html = `
					<div class="flex flex-row items-center option-answer">
						<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="ml-3 grow">
							<input type="text" name="respuesta2[${index}][]" disabled class="input-underline w-full" value="Otra...">
							<input type="hidden" name="respuesta2_id[${index}][]" value="0" class="input-underline w-full">
						</div>
						<div class="ml-3">
							<input type="checkbox" name="correcta2[${index}][]" class="accent-green-500 appearance-none" value="${$container.find('.flex').length}" checked>
						</div>
					</div>
				`;
				$container.append(html);
			});
			$('body').on('click', '.add-question', function(e) {
				e.preventDefault();
				currentQuestions++;
				let html = `
				<div class="w-2/4 md:w-1/3 float-left bg-white hover:bg-gray-100 hover:shadow pregunta-box group">
					<div class="p-3 flex flex-col h-full">
						<div class="flex flex-row items-center mb-3">
							<div class="font-bold text-2xl">Tipo</div>
							<div class="mx-auto">
								<input type="hidden" name="pregunta_id[${currentQuestions}]" value="0">
								<select name="tipo[${currentQuestions}]" class="question-type input-underline !border !shadow !rounded-3xl !px-4 !min-w-[130px]" required>
									<option value="open" selected>Abierta</option>
									<option value="option">Opción</option>
									<option value="multi">Multiple</option>
									<option value="like">Like or Not</option>
									<option value="level">Level Satisf</option>
									<option value="versus">VS</option>
								</select>
							</div>
							<div>
								<input type="text" name="valor[${currentQuestions}]" class="input-underline !border !shadow !rounded-3xl !px-4 !w-[80px] text-center" placeholder="Valor" value="0" required>
							</div>
						</div>
						<div class="mb-8">
							<input type="text" name="pregunta[${currentQuestions}]" class="input-underline !border !shadow !rounded-3xl !px-4 !py-2 !text-xl font-bold placeholder:!text-pink-600" placeholder="Pregunta" required>
						</div>
						<div class="mb-3 relative option-section question-section hidden">
							<div class="text-end font-bold text-sm">Correcta</div>
							<div class="respuestas mt-1 space-y-3">

							</div>
							<div class="grid grid-cols-2 gap-4 mt-3">
								<div>
									<a href="javascript:void(0);" class="add-abierta btn-pill3 !bg-zinc-800 !text-white w-full text-center">+ OTRA (abierta)</a>
								</div>
								<div>
									<a href="javascript:void(0);" class="add-respuesta btn-pill3 !bg-pink-600 !text-white w-full text-center">+ RESPUESTA</a>
								</div>
							</div>
						</div>
						<div class="mb-3 relative multi-section question-section hidden">
							<div class="text-end font-bold text-sm">Correcta</div>
							<div class="respuestas mt-1 space-y-3">

							</div>
							<div class="grid grid-cols-2 gap-4 mt-3">
								<div>
									<a href="javascript:void(0);" class="add-abierta-multi btn-pill3 !bg-zinc-800 !text-white w-full text-center">+ OTRA (abierta)</a>
								</div>
								<div>
									<a href="javascript:void(0);" class="add-respuesta-multi btn-pill3 !bg-pink-600 !text-white w-full text-center">+ RESPUESTA</a>
								</div>
							</div>
						</div>
						<div class="mb-3 relative like-section question-section level-section hidden px-8">
							<img src="https://placehold.co/600x400/FFFFFF/acacac/png?text=Cargar%20imagen"
								class="img-general object-cover w-100 border border-secondary shadow rounded-3xl">
							<div class="examinar-img group-hover:block shadow">
								<div><button type="button"
										class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 text-xs inline-block">Examinar...</button>
								</div>
								<small class="examinar-size text-gray-400 text-xs">(jpg 1000x1000px)</small>
								<input type="hidden" name="archivo_old[${currentQuestions}]" value="" />
								<input type="file" name="archivo_img[${currentQuestions}]" class="file-general" accept="image/*" style="display:none" />
							</div>
						</div>
						<div class="mb-3 level-section question-section hidden">
							<div>
								<input id="steps-range" type="range" min="0" max="10" value="5" step="1" disabled class="range-slider">
							</div>
							<div class="grid grid-cols-2 gap-5 mt-2">
								<div>
									<input type="text" name="level-low[${currentQuestions}]" placeholder="Pésimo" value="Pésimo" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
								</div>
								<div>
									<input type="text" name="level-high[${currentQuestions}]" placeholder="Excelente" value="Excelente" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
								</div>
							</div>
						</div>
						<div class="mb-3 versus-section question-section hidden">
							<dib class="grid grid-cols-2 items-center gap-3">
								<div class="flex flex-row justify-center">
									<div class="mb-3 relative">
										<img src="https://placehold.co/600x400/FFFFFF/acacac/png?text=Cargar%20imagen" class="img-general object-cover w-full h-auto border border-secondary shadow rounded-3xl">
										<div class="examinar-img group-hover:block shadow !-ml-[50px] !-mt-[22px]">
											<div class="flex flex-row justify-center">
												<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-2 py-1 text-xs inline-block">Examinar...</button>
											</div>
											<input type="hidden" name="versus1_old[${currentQuestions}]" value="" />
											<input type="file" name="versus1_img[${currentQuestions}]" class="file-general" accept="image/*" style="display:none" />
										</div>
									</div>
								</div>
								<div class="flex flex-row justify-center">
									<div class="mb-3 relative">
										<img src="https://placehold.co/600x400/FFFFFF/acacac/png?text=Cargar%20imagen" class="img-general object-cover w-full h-auto border border-secondary shadow rounded-3xl">
										<div class="examinar-img group-hover:block shadow !-ml-[50px] !-mt-[22px]">
											<div class="flex flex-row justify-center">
												<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-2 py-1 text-xs inline-block">Examinar...</button>
											</div>
											<input type="hidden" name="versus2_old[${currentQuestions}]" value="" />
											<input type="file" name="versus2_img[${currentQuestions}]" class="file-general" accept="image/*" style="display:none" />
										</div>
									</div>
								</div>
								<div class="flex flex-row justify-center">
									<input type="text" name="versus1-text[${currentQuestions}]" placeholder="Descripción" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
								</div>
								<div class="flex flex-row justify-center">
									<input type="text" name="versus2-text[${currentQuestions}]" placeholder="Descripción" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
								</div>
								<div class="flex flex-row justify-center">
									<input type="radio" name="versus-correcta[${currentQuestions}]" value="1" checked>
								</div>
								<div class="flex flex-row justify-center">
									<input type="radio" name="versus-correcta[${currentQuestions}]" value="2">
								</div>
							</dib>
						</div>
						<div class="mb-3 like-section question-section hidden">
							<dib class="grid grid-cols-3 items-center gap-3">
								<div class="flex flex-row justify-center">
									<label for="like-icons-${currentQuestions}" class="flex items-center cursor-pointer">
										<div class="relative">
											<input id="like-icons-${currentQuestions}" name="iconos[${currentQuestions}]" type="checkbox" class="sr-only" checked />
											<div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
											<div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
										</div>
									</label>
								</div>
								<div class="flex flex-row justify-center">
									<a href="javascript:void(0);" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-xl items-center p-5 w-4 h-4">
										<i class="far fa-thumbs-up"></i>
									</a>
								</div>
								<div class="flex flex-row justify-center">
									<a href="javascript:void(0);" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center text-xl items-center p-5 w-4 h-4">
										<i class="far fa-thumbs-down"></i>
									</a>
								</div>
								<div class="text-sm font-bold flex flex-row justify-center">
									&nbsp;
								</div>
								<div class="flex flex-row justify-center">
									<input type="text" name="like-text[${currentQuestions}]" placeholder="SÍ" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
								</div>
								<div class="flex flex-row justify-center">
									<input type="text" name="dislike-text[${currentQuestions}]" placeholder="NO" class="input-underline !border !shadow !rounded-3xl !px-4 text-center">
								</div>
								<div class="text-sm font-bold flex flex-row justify-center">
									Correcta
								</div>
								<div class="flex flex-row justify-center">
									<input type="radio" name="like-correcta[${currentQuestions}]" value="1" checked>
								</div>
								<div class="flex flex-row justify-center">
									<input type="radio" name="like-correcta[${currentQuestions}]" value="2">
								</div>
							</dib>
						</div>
						<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between mt-auto">
							<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
							<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
										class="fas fa-trash-alt"></i></a></div>
						</div>
					</div>
				</div>
				`;
				$('#preguntas-container').append(html);
				$('#preguntas-container .pregunta-box').find('.respuestas').each(function (index, item) {
					new Sortable(item, {
						handle: '.handler2',
						animation: 150,
						direction: 'vertical',
						onEnd: function (evt) {
							console.log('onEnd', evt);
							// rearrange the radio buttons
							$(evt.from).find('input[type=radio]').each(function (index, item) {
								console.log('index', index, item);
								$(item).val(index);
							});
							// rearrange the checkbox buttons
							$(evt.from).find('input[type=checkbox]').each(function (index, item) {
								console.log('index', index, item);
								$(item).val(index);
							});
							console.log(evt.from);
						}
					});
				});
				$('.pregunta-box').matchHeight({
					byRow: false,
					property: 'height',
					target: null,
					remove: false
				});
				$.fn.matchHeight._update()
			});
			$('.pregunta-box').matchHeight({
				byRow: false,
				property: 'height',
				target: null,
				remove: false
			});
			// eliminar bloques
			$('body').on('click', 'div.delete-fotometria a', function (e) {
					e.preventDefault();
					const esto = $(this);
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Este cambio se puede deshacer si actualizas la página sin guardar, en el momento que guardes tus cambios ya no podrás recuperar nada.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, eliminar',
						cancelButtonText: 'NO, cancelar'
					}).then((result) => {
						if (result.isConfirmed) {
							esto.parent().parent().parent().parent().remove();
							// recordatorio();
							Swal.fire('Eliminado', 'Recuerda guardar tus cambios para que tengan efecto.', 'success')
						}
					})
				});
			$('body').on('click', 'button.examinar-btn', function (e) {
				e.preventDefault();
				$(this).parent().parent().find('input[type=file]').trigger('click');
			});
			$('body').on('change', '.question-type', function (e) {
				const value = $(this).val();
				const $parent = $(this).parent().parent().parent();
				console.log(value, $parent);
				$parent.find('.question-section').addClass('hidden');
				$parent.find(`.${value}-section`).removeClass('hidden');
				$('.pregunta-box').matchHeight({
					byRow: false,
					property: 'height',
					target: null,
					remove: false
				});
				$.fn.matchHeight._update()
			});
			// trigger the change event for each question type
			$('.question-type').each(function (index, item) {
				$(item).trigger('change');
			});
			$('body').on('change', '.file-general', function () {
				const $esto = $(this);
				if (this.files && this.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$esto.parent().parent().find('img.img-general').attr('src', e.target.result);
					}
					reader.readAsDataURL(this.files[0]);
				}
			});
		});
	</script>
	@endsection
</x-app-layout>
