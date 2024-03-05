<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $cliente->cliente}} | Games Memory</title>
	<meta name="description" content="Games Memory">
	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap"
		rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-40ZEQ4JZ0Y"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-40ZEQ4JZ0Y');
	</script>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
	<style>
		.alx-btn-add-calendario {
			padding: 0px 10px;
			line-height: 30px;
			border-radius: 30px;
			border: 1px solid #FFFFFF;
			display: block;
			width: 200px;
			margin-left: 20px;
			font-weight: bold;
		}
	</style>



	<style>
		body {
			background-color: #b6dfe3;
			font-family: Arial;
			color: #FFFFFF;
			font-weight: bold;
			font-size: 16px;
		}

		.card {
			width: 100%;
			perspective: 1000px;
			cursor: pointer;
			border: 0px solid #000000;
			position: relative;
			float: left;
		}

		.card .flipper {
			width: 100%;
			height: 100%;
			transform-style: preserve-3d;
			transition: transform 0.5s;
		}

		.card.flipped .flipper {
			transform: rotateY(180deg);
		}

		.card .front,
		.card .back {
			width: 100%;
			height: 100%;
			position: absolute;
			backface-visibility: hidden;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.card .front {
			transform: rotateY(180deg);
		}


		.card .front {
			background-color: #000000;
			background-repeat: no-repeat;
			background-position: center center;
			background-size: cover;
		}

		.card .back {
			background: #a409e7 url('logo.png') no-repeat center center;
			background-size: 80% auto;
		}

		#restart-button {
			/*width: 100px;
            height: 40px;
            background-color: #00b8de;
            display: block;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
            line-height: 40px;
            border-radius: 5px;
            */
			cursor: pointer;
			float: right;
		}


		#maximo {
			width: 600px;
			margin: 0px auto;
			position: relative;
		}

		.etiquetas {
			width: 200px;
			color: #000000;
		}

		#stats-container {
			color: {
					{
					$cliente->color
				}
			}

			;
		}

		.datos {
			float: left;
			margin-right: 20px;
			line-height: 40px;
		}

		.l {
			clear: both;
			margin-bottom: 40px;
		}

		.der {
			margin-right: 10px;
		}

		.en-mobile {
			display: none;
		}

		@media screen and (max-width: 599px) {

			body {
				font-size: 12px;
			}

			#maximo {
				width: 100%;
				padding: 0 10px;
			}

			.datos {
				width: 150px;
				line-height: 20px;
			}

			.en-mobile {
				display: block;
			}

			.l {

				margin-bottom: 10px;
			}
		}

		#game-container::after {
			content: "";
			/* Contenido vacío */
			display: table;
			clear: both;
		}

		#btn-regresar-de-juego {
			margin: 10px;
		}
		.swal2-container.swal2-backdrop-show, .swal2-container.swal2-noanimation {
    background: rgba(255,255,255,.4)!important;
    backdrop-filter: blur(10px);
}
	</style>



</head>

<body class="font-sans antialiased pb-20">
	@include('componentes.header')
	<main class="pt-[100px]">
		<h1 class="text-center px-5 py-5 text-3xl font-extrabold lg:text-5xl" style="color: {{ $cliente->color }};">{!!
			$juego->nombre !!}</h1>
		<span id="correct-count" class="hidden">0</span>
		<span id="error-count" class="hidden">0</span>
		<div id="maximo">
			<div class="text-center font-bold">
				{!! $juego->descripcion !!}
			</div>
			<div class="flex flex-row justify-evenly items-center my-5">
				<div class="text-xl">
					<div class="color">Tiempo:</div>
					<div class="-mt-2">
						<span id="timer" class="der">0</span>seg.
					</div>
				</div>
				<div class="ml-auto">
					<div class="btn-pill restart-game">Reiniciar</div>
				</div>
			</div>

			<div id="game-container" class="grid grid-cols-4 gap-1"></div>
			<br><br>
		</div>
	</main>
	@include('componentes.footer')
	@foreach ($cliente->flotantes as $flotante)
	<div class="fixed {{ $flotante->posicion }} m-5" style="z-index: 5000; font-size: 0.9em;">
		<div class="py-3 px-5 text-white rounded-full "
			style="background-color: {{ $flotante->color }}; font-weight: bold;">
			<a href="{{ $flotante->link }}" target="{{ $flotante->target }}">{{ $flotante->texto }} <i
					class="{{ $flotante->icono }}"></i></a>
		</div>
	</div>
	@endforeach
	<script src="{{ asset('assets/alx-jquery.js') }}"></script>
	<script>
		let logged = {{ auth()->check() ? 'true' : 'false' }};
		let name = '{{ auth()->check() ? auth()->user()->name : '' }}';
		var cards = [];
		var flippedCards = [];
		var correctCount = 0;
		var errorCount = 0;
		var timer = 0;
		var timerInterval;

		let cardImg = [];
		let cardId = [];

		let path = "<?php echo asset('storage/clientes/games/memory/');?>";
		<?php
			$imgBack = "";
			foreach($juego->cartas as $key => $c){
				if($c->frente === 1){
					echo "cardId[".$key."] = ".$c->id."; \n";
					echo "cardImg[".$key."] = '".$c->imagen."'; \n";
				}
				else{
					$imgBack = $c->imagen;
				}
			}
		?>
		function startGame() {
			cards = generateCardPairs();
			renderGame();
			startTimer();
		}
		function generateCardPairs() {
			/*var icons = ["pin", "lentes", "robot", "astro", "oculus", "esfera"];*/
			var pairs = cardImg.concat(cardImg);
			return shuffleArray(pairs);
		}
		function shuffleArray(array) {
			return array.sort(() => Math.random() - 0.5);
		}
		function renderGame() {
			var gameContainer = $("#game-container");
			gameContainer.empty();

			for (var i = 0; i < cards.length; i++) {
				var card = $("<div>", { class: "card h-[120px] lg:h-[180px]", "data-index": i, id: "carta-"+i });
				var flipper = $("<div>", { class: "flipper" });
				var front = $("<div>", { class: "front", style: "background-image: url('"+path+"/"+cards[i]+"');" });
				var back = $("<div>", { class: "back" });
				/*front.append('<i class="fas ' + cards[i] + '"></i>');*/
				/*back.append('<i class="fas fa-question"></i>');*/
				flipper.append(front);
				flipper.append(back);
				card.append(flipper);
				card.click(function () {
					/*Sino tienen la clase resulta ejecuta el click*/
					if (!$(this).hasClass("flipped")){
						var index = $(this).data("index");
						if (!flippedCards.includes(index) && flippedCards.length < 2) {
							$(this).addClass("flipped");
							flippedCards.push(index);

							if (flippedCards.length === 2) {
								setTimeout(checkMatch, 1000);
							}
						}
					}
				});
				gameContainer.append(card);
			}
		}

		function checkMatch() {
			var card1 = cards[flippedCards[0]];
			var card2 = cards[flippedCards[1]];
			if (card1 === card2) {
				correctCount++;
				$("#correct-count").text(correctCount);
				$("#carta-"+flippedCards[0]).addClass('resuelta');
				$("#carta-"+flippedCards[1]).addClass('resuelta');
				flippedCards = [];
			} else {
				errorCount++;
				$("#error-count").text(errorCount);
				// Voltear las cartas de nuevo después de un breve tiempo
				setTimeout(function () {
					//$(".card.flipped").removeClass("flipped");
					$(".flipped").each(function () {
						// Verifica si el elemento tiene la clase "resulta"
						if (!$(this).hasClass("resuelta")) {
							// Si no tiene la clase "resulta", quita la clase "flipped"
							$(this).removeClass("flipped");
						}
					});
					flippedCards = [];
				}, 1000);
			}
			// Verificar si el juego ha terminado
			if (correctCount === cards.length / 2) {
				stopTimer();
				saveScore();
				let modalContent = `<div class="flex flex-row justify-center items-center">
						<dotlottie-player src="https://lottie.host/8098cf36-fe3e-4181-b9f5-1bf97918a3ee/9KuD05DkOl.json" background="transparent" speed="1" style="width: 150px; height: auto;" loop autoplay></dotlottie-player>
						</div>
						<div class="font-extrabold text-4xl color">¡Felicidades!</div>`;
					if (logged) {
						modalContent += `<div class="text-base">${name}</div>`;
					}
					modalContent += `<div class="mt-5 flex flex-row items-center justify-center font-bold">
							<div class="mr-4">
								<div class="color">Tiempo:</div>
								<div class="">${timer} seg</div>
							</div>
							<div>
								<a href="#" class="btn-pill2 restart-game">Volver a jugar</a>
							</div>
						</div>`;
					if (!logged) {
						modalContent += `<div class="mt-7 text-base">Al parecer no eres un usuario registrado, <span class="font-bold">si deseas aparecer en el Ranking:</span></div>
						<div class="mt-7"><a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="btn-pill">Regístrate aquí</a></div>
						`;
					}
					Swal.fire({
						icon: null,
						title: null,
						width: '22em',
						focusConfirm: false,
						returnFocus: false,
						html: modalContent,
						showConfirmButton: false,
						showCloseButton: true,
						closeButtonHtml: `{!! file_get_contents(public_path('images/cerrar.svg')) !!}`,
					});
			}
		}

		function saveScore() {
			const formData = new FormData();
			formData.append('tiempo', timer);
			formData.append('aciertos', correctCount);
			formData.append('errores', errorCount);
			axios.post('{{ route("cliente.save-game", ["claveJuego" => $claveJuego, "slug" => $slug]) }}', formData)
			.then((response) => {
				console.log(response);
			});
		}

		function startTimer() {
			timerInterval = setInterval(function () {
				timer++;
				$("#timer").text(timer);
			}, 1000);
		}

		function stopTimer() {
			clearInterval(timerInterval);
		}

		function restartGame() {
			Swal.close();
			stopTimer();
			correctCount = 0;
			errorCount = 0;
			timer = 0;
			flippedCards = [];
			$("#correct-count").text(correctCount);
			$("#error-count").text(errorCount);
			$("#timer").text(timer);
			startGame();
		}
		window.addEventListener('load', function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').on('click', '.restart-game', function(e){
				e.preventDefault();
				restartGame();
			});
			// Iniciar el juego al cargar la página
			startGame();
		});
	</script>
	@include('componentes.estilos')
</body>

</html>
