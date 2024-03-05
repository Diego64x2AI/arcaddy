@php
$quiz = $cliente->quiz->where('activa', true)->first();
list($r, $g, $b) = sscanf($cliente->color_bg, "#%02x%02x%02x");
list($r2, $g2, $b2) = sscanf($cliente->color, "#%02x%02x%02x");
$preguntas = $quiz->preguntas;
if ($quiz->random) {
	$preguntas = $preguntas->shuffle();
}
@endphp
@if ($quiz !== NULL)
<section id="quiz" class="container mx-auto py-10 max-w-xl">
	<div class="titulo-modulo">{{ $quiz->nombre }}</div>
	@if($quiz->imagen !== NULL)
	<div class="text-center py-10">
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
			<a href="javascript:void(0);" class="btn-pill quiz-again">Volver a jugar</a>
		</div>
	</div>
	<!-- Slider main container -->
	<div id="quiz-slider" class="swiper swiper-quiz">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			@foreach($preguntas as $pregunta)
			<div class="swiper-slide px-5 py-5" data-tipo="{{ $pregunta->tipo }}" data-quiz="{{ $quiz->id }}" data-pregunta="{{ $pregunta->id }}">
				<div class="py-5 text-xl font-extrabold color">{{ $loop->iteration }}.- {{ $pregunta->pregunta }}</div>
				@includeIf('secciones.quiz.'.$pregunta->tipo)
			</div>
			@endforeach
		</div>
	</div>
	<div id="quiz-controls" class="grid grid-cols-2 items-center mt-5">
		<div class="font-bold text-center">
			<span id="current-quiz-question">1</span> de <span id="total-quiz-question">{{ $preguntas->count() }}</span> preguntas
		</div>
		<div class="flex flex-row justify-center">
			<a href="javascript:void(0);" class="btn-pill quiz-next">Siguiente</a>
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
					title: 'Al parecer aún no eres usuario registrado',
					text: 'Regístrate para participar en esta y otras increíbles dinámicas',
					// custom button for register
					showCancelButton: true,
					confirmButtonText: 'Registrarme',
					cancelButtonText: 'Cancelar',
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
						text: 'Debes seleccionar una respuesta',
						customClass: 'quiz-swal',
					});
					return;
				}
				if (otra === 1 && jQuery.trim($(`input[name=respuesta-${preguntaId}-otra`).val()) === '') {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Debes escribir una respuesta',
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
						text: 'Debes seleccionar una respuesta',
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
						text: 'Debes escribir una respuesta',
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
						text: 'Debes seleccionar una respuesta',
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
						text: 'Debes seleccionar una respuesta',
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
						text: 'Debes escribir una respuesta',
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
					$('#quiz-congratulations').show();
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
					text: 'Ocurrió un error, por favor intenta de nuevo',
					customClass: 'quiz-swal',
				});
			});
		});
	});
</script>
<style>
	.quiz-swal {
		background-color: rgba({{ $r }},{{ $g }},{{ $b }},1)!important;
		color: {{ $cliente->color }} !important;
	}
</style>
@endif
