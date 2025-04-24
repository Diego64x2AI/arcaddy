@php
$quiz = $cliente->quiz()->where('activa', true)->orderBy('id', 'desc')->first();
list($r, $g, $b) = sscanf($cliente->color_bg, "#%02x%02x%02x");
list($r2, $g2, $b2) = sscanf($cliente->color, "#%02x%02x%02x");
$preguntas = $quiz->preguntas;
if ($quiz->random) {
	$preguntas = $preguntas->shuffle();
}
// if the quiz exists lets grab the ranking
if ($quiz !== NULL && $quiz->score) {
 $scores = \App\Models\QuizRespuestas::select('id', 'user_id', DB::raw('SUM(puntos) as total'))->where('quiz_id', $quiz->id)->whereNotNull('user_id')->orderBy('total', 'desc')->groupBy('user_id')->paginate(10);
 $scoresAll = \App\Models\QuizRespuestas::select('id', 'user_id', DB::raw('SUM(puntos) as total'))->where('quiz_id', $quiz->id)->whereNotNull('user_id')->orderBy('total', 'desc')->groupBy('user_id')->get();
 $mPosicion = -1;
 if (auth()->check()) {
 	$mPosicion = (array_search(auth()->user()->id, $scoresAll->pluck('user_id')->toArray()) === false) ? -1 : array_search(auth()->user()->id, $scoresAll->pluck('user_id')->toArray());
 }
}
$beneficio = \App\Models\UserBeneficio::where('cliente_id', $cliente->id)->where('user_id', auth()->user()?->id)->where('quiz_id', $quiz->id)->orderBy('id', 'asc')->first();
@endphp
@if ($quiz !== NULL && $beneficio === NULL)
	<section id="quiz" class="container mx-auto py-10 px-5 max-w-xl">
		@if ($cliente->secciones()->where('seccion', 'quiz')->first()->mostrar_titulo)
		<div class="titulo-modulo color">{{ $quiz->nombre }}</div>
		@endif
		<div class="border-2 borde py-10 rounded-3xl">
			@if($quiz->imagen !== NULL)
			<div class="text-center mb-10">
				<img src="{{ asset('storage/'.$quiz->imagen) }}" alt="{{ $quiz->nombre }}" class="w-100 h-auto object-cover inline-block">
			</div>
			@endif
			<div id="quiz-congratulations" class="px-5" style="display:none;">
				<div class="text-center flex flex-row justify-center items-center">
					<dotlottie-player src="https://lottie.host/c0b45a5c-d12c-48b4-9587-943a4565c74f/ZkF7i1SCUK.json" background="transparent" speed="1" style="width: 150px; height: auto;" loop autoplay></dotlottie-player>
				</div>
				@if($quiz->felicidades_text !== NULL && trim($quiz->felicidades_text) !== '')
				<div class="text-center mt-1 font-bold text-3xl">{{ $quiz->felicidades_text }}</div>
				@endif
				@auth
				<div id="nombre-quiz" class="text-center mt-1 font-semibold text-xl">{{ auth()->user()->name }}</div>
				@endauth
				<div class="text-center flex flex-row justify-center items-center mt-5">
					<a href="javascript:void(0);" class="btn-pill quiz-again">{{ $quiz->boton_text }}</a>
				</div>
			</div>
			<div id="quiz-beneficios" class="px-5" style="display:none;">
				<div class="text-center flex flex-row justify-center items-center">
					<dotlottie-player src="https://lottie.host/8098cf36-fe3e-4181-b9f5-1bf97918a3ee/9KuD05DkOl.json" background="transparent" speed="1" style="width: 150px; height: auto;" loop autoplay></dotlottie-player>
				</div>
				@auth
				<div id="nombre-quiz" class="text-center mt-1 font-semibold text-xl">{{ auth()->user()->name }}</div>
				@endauth
				<div class="text-center mt-1 font-bold text-xl">{{ __('arcaddy.beneficio1') }}</div>
				<div class="text-center flex flex-row justify-center items-center mt-5">
					<a href="{{ route('beneficios', ['cliente' => $cliente->id]) }}" class="btn-pill">{{ __('arcaddy.beneficio2') }}</a>
				</div>
			</div>
			<!-- Slider main container -->
			<div id="quiz-slider" class="swiper swiper-quiz">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					@foreach($preguntas as $pregunta)
					<div class="swiper-slide px-5" data-tipo="{{ $pregunta->tipo }}" data-quiz="{{ $quiz->id }}" data-pregunta="{{ $pregunta->id }}">
						<div class="mb-5 text-xl font-extrabold">{{ $loop->iteration }}.- {{ $pregunta->pregunta }}</div>
						@includeIf('secciones.quiz.'.$pregunta->tipo)
					</div>
					@endforeach
				</div>
			</div>
			<div id="quiz-controls" class="grid grid-cols-2 items-center mt-5">
				<div class="font-bold text-center">
					<span id="current-quiz-question">1</span> {{ __('arcaddy.of') }} <span id="total-quiz-question">{{ $preguntas->count() }}</span> {{ __('arcaddy.questions') }}
				</div>
				<div class="flex flex-row justify-center">
					<a href="javascript:void(0);" class="btn-pill quiz-next">{{ __('arcaddy.next') }}</a>
				</div>
			</div>
		</div>
</section>
<script>
	const quizLogged = {{ auth()->check() ? 'true' : 'false' }};
	const quizLogin = {{ $quiz->login ? 'true' : 'false' }};
	document.addEventListener('DOMContentLoaded', function load() {
		if (!window.jQuery) return setTimeout(load, 50);
		console.log(`quiz load`);
		$('body').on('click', '.like-click', function(e){
			e.preventDefault();
			$('.like-click').removeClass('border-white').addClass('border-gray-500');
			$('.dislike-click').addClass('border-white').removeClass('border-gray-500');
			$('#like-dislike').val($(this).data('respuesta'));
		});
		$('body').on('click', '.dislike-click', function(e){
			e.preventDefault();
			$('.dislike-click').removeClass('border-white').addClass('border-gray-500');
			$('.like-click').addClass('border-white').removeClass('border-gray-500');
			$('#like-dislike').val($(this).data('respuesta'));
		});
		$('body').on('click', 'a.quiz-again', function(e){
			e.preventDefault();
			$('#quiz-congratulations').hide();
			$('#quiz-slider, #quiz-controls').show();
			document.querySelector('.swiper-quiz').swiper.slideTo(0);
			$('#current-quiz-question').text('1');
		});
		$('body').on('click', 'a.quiz-next', function(e){
			e.preventDefault();
			if (quizLogin && !quizLogged) {
				Swal.fire({
					icon: 'error',
					title: '{{ __('arcaddy.modal-nologin-title') }}',
					text: '{{ __('arcaddy.modal-nologin-text') }}',
					// custom button for register
					showCancelButton: true,
					confirmButtonText: '{{ __('Register') }}',
					cancelButtonText: '{{ __('arcaddy.cancel') }}',
					customClass: 'quiz-swal',
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = '{{ route('register', ['cliente' => $cliente->id]) }}';
					}
				});
				return;
			}
			$activeSlide = $('#quiz-slider .swiper-slide-active');
			const quizId = Number($activeSlide.data('quiz'));
			const preguntaId = Number($activeSlide.data('pregunta'));
			const tipo = $activeSlide.data('tipo');
			const swiper = document.querySelector('.swiper-quiz').swiper;
			let formData = new FormData();
			console.log(`quizId: ${quizId}, preguntaId: ${preguntaId}, tipo: ${tipo}`, $(`input[name=respuesta-${preguntaId}]:checked`), $activeSlide, $activeSlide.data('quiz'));
			if (tipo === 'option') {
				let otra = Number($(`input[name=respuesta-${preguntaId}]:checked`).data('otra'));
				if ($(`input[name=respuesta-${preguntaId}]:checked`).length === 0) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.select-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				if (otra === 1 && jQuery.trim($(`input[name=respuesta-${preguntaId}-otra`).val()) === '') {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.text-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				formData.append('respuesta', $(`input[name=respuesta-${preguntaId}]:checked`).val());
				if (otra === 1) {
					formData.append('otra', $(`input[name=respuesta-${preguntaId}-otra`).val());
				}
			} else if (tipo === 'multi') {
				if ($(`input[name=respuesta-${preguntaId}]:checked`).length === 0) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.select-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				let firstId = 0;
				let otra = false;
				$(`input[name=respuesta-${preguntaId}]:checked`).each(function(item, x){
					console.log(item, x);
					if (firstId === 0) {
						firstId = Number($(this).val());
					}
					if (Number($(this).data('otra')) === 1) {
						otra = true;
					}
					formData.append('multi[]', $(this).val());
				});
				console.log(firstId, otra);
				if (otra && jQuery.trim($(`input[name=respuesta-${preguntaId}-otra`).val()) === '') {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.text-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				formData.append('respuesta', firstId);
				if (otra) {
					formData.append('otra', $(`input[name=respuesta-${preguntaId}-otra`).val());
				}
			} else if (tipo === 'like') {
				if (jQuery.trim($('#like-dislike').val()) === '') {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.select-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				formData.append('respuesta', $('#like-dislike').val());
			} else if (tipo === 'versus') {
				let respuestaId = Number($('input[name="respuesta-versus"]:checked').val());
				if (respuestaId === 0 || isNaN(respuestaId)) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.select-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				formData.append('respuesta', respuestaId);
			} else if (tipo === 'open') {
				if (jQuery.trim($(`#open-answer-${preguntaId}`).val()) === '') {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.text-error') }}',
						customClass: 'quiz-swal',
					});
					return;
				}
				formData.append('respuesta', $(`#open-answer-${preguntaId}`).data('respuesta'));
				formData.append('otra', $(`#open-answer-${preguntaId}`).val());
			} else if (tipo === 'level') {
				formData.append('range', $(`#steps-range-${preguntaId}`).val());
				formData.append('respuesta', $(`#steps-range-${preguntaId}`).data('respuesta'));
			}
			formData.append('quiz', quizId);
			formData.append('pregunta', preguntaId);
			axios.post('{{ route("cliente.quiz.respuesta", ["cliente" => $cliente->id]) }}', formData)
			.then(function(response) {
				console.log(response);
				if (!response.data.status) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.data.message,
						customClass: 'quiz-swal',
					});
					return;
				}
				const current = (swiper.activeIndex + 2);
				const total = Number($('#total-quiz-question').text());
				swiper.slideNext();
				if (current > total) {
					if (response.data.beneficio && response.data.beneficios_count > 0) {
						$('#quiz-beneficios').show();
					} else {
						$('#quiz-congratulations').show();
					}
					$('#quiz-slider, #quiz-controls').hide();
					return;
				}
				$('#current-quiz-question').text(current);

			})
			.catch(function(error) {
				console.log(error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: '{{ __('arcaddy.error-gral') }}',
					customClass: 'quiz-swal',
				});
			});
		});
	});
</script>
@if($quiz !== NULL && $quiz->score && $scores->total() > 0)
<section id="ranking" class="py-5 text-center mx-auto w-full max-w-xl">
	<div class="flex flex-row items-center justify-center">
		<div class="titulo-modulo">{{ __('arcaddy.ranking') }}</div>
		<div class="color text-2xl font-extrabold lg:text-4xl ml-3 mt-1">{{ __('arcaddy.users') }}</div>
	</div>
	<div id="ranking-quiz-leaderboard" class="mt-5 lg:mt-10 px-5">
	</div>
	<div id="hasMorePagesQuiz" class="mt-5">
		<a id="load-ranking-quiz" href="#" class="btn-pill">{{ __('arcaddy.loadmore') }}</a>
	</div>
</section>
<script>
	let currentPageQuiz = 0;
	let perPageQuiz = {{ $scores->perPage() }};
	let hasMorePagesQuiz = true;
	let lastPageQuiz = {{ $scores->lastPage() }};
	let rakingLoadingQuiz = false;
	let rankingFromQuiz = 0;
	let rankingUIDQuiz = {{ auth()->check() ? auth()->user()->id : '0' }};
	const ranking_urlQuiz = '{{ route("api.rankings.quiz", ["cliente" => $cliente->id]) }}';
	let myUserPositionHtmlQuiz = '';
	const mPosicion = {{ $mPosicion + 1 }};
	@if ($mPosicion !== -1 && isset($scoresAll[$mPosicion]))
		myUserPositionHtmlQuiz = `
		<div class="flex flex-row items-center mb-2 tu-ranking-quiz-box">
			<div class="color font-bold text-2xl text-center w-5">{{ $mPosicion + 1 }}</div>
			<div class="flex flex-row grow ml-2 items-center px-3 py-2 rounded-3xl" style="background-color: {{ $cliente->color }}; color: {{ $cliente->color_bg }};">
				{{--<div><img src="{{ asset('images/Imagen 73.jpg') }}" class="w-10 h-10 rounded-full" alt="Juan Carlos Perez"></div>--}}
				<div class="grow text-left ml-2 font-semibold text-xs md:text-normal">
					<div>TÚ</div>
					<div>{{ $scoresAll[$mPosicion]['user']['name'] }}</div>
				</div>
				<div class="ml-auto font-extrabold text-xl">{{ $scoresAll[$mPosicion]['total'] }}</div>
			</div>
		</div>
		`;
	@endif
	window.addEventListener('load', function() {
		$('a#load-ranking-quiz').click(function(e){
			e.preventDefault();
			if (!hasMorePagesQuiz || rakingLoadingQuiz) {
				return
			}
			currentPageQuiz++;
			rakingLoadingQuiz = true;
			$.get(`${ranking_urlQuiz}?page=${currentPageQuiz}`, function(data){
				rankingFromQuiz = data.from;
				$('.tu-ranking-quiz-box').hide();
				data.data.forEach((item) => {
					let style = (rankingFromQuiz === 1) ? ` style="background-color: {{ $cliente->color_base }}; color: {{ $cliente->color_bg }};"` : ``;
					if (rankingUIDQuiz === item.user.id) {
						style = ` style="background-color: {{ $cliente->color }}; color: {{ $cliente->color_bg }};"`;
					}
					$('#ranking-quiz-leaderboard').append(`
					<div class="flex flex-row items-center mb-2">
						<div class="color font-bold text-2xl text-center w-5">${rankingFromQuiz}</div>
						<div class="flex flex-row grow ml-2 items-center px-3 py-2 rounded-3xl"${style}>
							{{--<div><img src="{{ asset('images/Imagen 73.jpg') }}" class="w-10 h-10 rounded-full" alt="Juan Carlos Perez"></div>--}}
							<div class="grow text-left ml-2 font-semibold text-xs md:text-normal">${item.user.name}</div>
							<div class="ml-auto font-extrabold text-xl">${item.total}</div>
						</div>
					</div>
					`);
					rankingFromQuiz++;
				});
				if (mPosicion >= rankingFromQuiz) {
					$('#ranking-quiz-leaderboard').append(myUserPositionHtmlQuiz);
				}
				if (data.next_page_url === null) {
					hasMorePagesQuiz = false;
					$('#hasMorePagesQuiz').hide(100);
				}
				rakingLoadingQuiz = false;
			}, 'json');
		}).trigger('click');
	});
</script>
@endif
<style>
	.quiz-swal {
		background-color: rgba({{ $r }},{{ $g }},{{ $b }},1)!important;
		color: {{ $cliente->color }} !important;
	}
</style>
@endif
