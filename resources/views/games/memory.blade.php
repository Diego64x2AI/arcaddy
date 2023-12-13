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
			width: 130px;
			height: 180px;
			perspective: 1000px;
			margin: 10px;
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
				width: 300px;
			}

			.card {

				/*width: 65px;
                height: 90px;
                margin: 5px;*/

				width: 90px;
				height: 130px;
				margin: 5px;
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
	</style>



</head>

<body class="font-sans antialiased">
	<main>

		<a class="btn-pill" id="btn-regresar-de-juego" href="{{route('cliente', $cliente->slug)}}">Regresar</a>
		<h1 class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl" style="color: {{ $cliente->color }};">{!!
			$juego->nombre !!}</h1>

		<div class="text-center" style="font-weight: 400;">
			{!! $juego->descripcion !!}
		</div>
		<br><br>


		<div id="maximo">
			<div id="stats-container">
				<div class="datos">
					<span class="etiquetas">Aciertos:</span> <span id="correct-count" class="der">0</span>
					<div class="en-mobile"></div>
					<span class="etiquetas">Errores:</span> <span id="error-count" class="der">0</span>
					<div class="en-mobile"></div>
					<span class="etiquetas">Tiempo:</span> <span id="timer" class="der">0</span>seg.
				</div>
				<div id="restart-button" class="btn-pill">Reiniciar</div>
				<div class="l"></div>
			</div>

			<div id="game-container"></div>
			<br><br>

		</div>

	</main>

	<footer class="mt-5">
		<div class="flex items-center justify-center">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		@if ($cliente->secciones()->where('activa', 1)->where('seccion', 'social')->count() > 0)
		<div class="text-center mt-5">

			<div class="text-xl">{{($cliente->id != 82)?'Síguenos:':'Follow us:'}}</div>
			<div class="text-center mt-3 flex flex-row items-center justify-center">
				@if ($cliente->instagram !== '' && $cliente->instagram !== NULL)
				<a href="{{ $cliente->instagram }}" target="_blank" class="mr-2"><img
						src="{{ asset('images/instagram.png') }}?v=1" class="object-fit w-14 h-auto" alt="Instagram"></a>
				@endif
				@if ($cliente->facebook !== '' && $cliente->facebook !== NULL)
				<a href="{{ $cliente->facebook }}" target="_blank" class="mr-2"><img
						src="{{ asset('images/facebook.png') }}?v=1" class="object-fit w-14 h-auto" alt="Facebook"></a>
				@endif
				@if ($cliente->twitter !== '' && $cliente->twitter !== NULL)
				<a href="{{ $cliente->twitter }}" target="_blank" class="mr-2"><img src="{{ asset('images/twitter.png') }}?v=1"
						class="object-fit w-14 h-auto" alt="Twitter"></a>
				@endif
				@if ($cliente->tiktok !== '' && $cliente->tiktok !== NULL)
				<a href="{{ $cliente->tiktok }}" target="_blank" class="mr-2"><img src="{{ asset('images/tiktok.png') }}?v=1"
						class="object-fit w-14 h-auto" alt="Tiktok"></a>
				@endif
				@if ($cliente->whatsapp !== '' && $cliente->whatsapp !== NULL)
				<a href="{{ $cliente->whatsapp }}" target="_blank"><img src="{{ asset('images/whatsapp.png') }}?v=1"
						class="object-fit w-14 h-auto" alt="Whatsapp"></a>
				@endif
			</div>
		</div>
		@endif
		<div class="degradado px-5 py-6 mt-5 text-white">
			<div class="flex flex-row items-center justify-between">
				<div>
					<img src="{{ asset('images/logo@2x.png') }}" class="block h-6 w-auto fill-current text-gray-600">
				</div>
				<div class="text-lg">Reality is an illusion...</div>
			</div>
		</div>
	</footer>
	<div id="header" class="fixed top-0 right-0 w-full px-6 py-4 z-50 bg-white shadow-sm">
		<div class="flex flex-col md:flex-row items-center justify-center">
			<div class="flex flex-col md:flex-row items-center justify-center">
				<img src="{{ asset('storage/'.$cliente->logo) }}" style="height: 40px; width:auto"
					alt="{{ $cliente->cliente }}">
			</div>
			<div class="flex items-center justify-center mt-3 md:mt-0 md:ml-auto">
				@if ($cliente->registro)
				@auth
				<div class="text-base mr-4 font-bold">
					Hola {{ auth()->user()->name }}
					<?php /*<a href="{{ route('registro', ['cliente' => $cliente->id]) }}" class="text-base">
								Hola {{ auth()->user()->name }}
							</a> */?>
				</div>

				@role('admin')
				<a href="{{ route('dashboard') }}" class="text-base mr-4 hiddenalex md:inline-block">Dashboard</a>
				@endrole


				@role('client')
				<a href="{{ route('my-app-client.home') }}" class="text-base mr-4 hiddenalex md:inline-block">Mi App Client</a>
				@endrole

				@role('user')

				<a href="{{route('registro',['cliente' => $cliente->id])}}?ver=1"
					class="text-base mr-4 hiddenalex md:inline-block">Mi QR</a>

				@endrole

				<!-- Authentication -->
				<form method="POST" action="{{ route('logout', ['cliente' => $cliente->id]) }}">
					@csrf
					<a :href="route('logout', ['cliente' => $cliente->id])" class="text-base"
						onclick="event.preventDefault(); this.closest('form').submit();">
						{{ __('Log Out') }}
					</a>
				</form>
				@else

				@if (Route::has('register') && $cliente->id == 65 )
				<a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="text-base">{{ __('Register') }}</a>
				@endif
				<a href="{{ route('login', ['cliente' => $cliente->id]) }}" class="ml-2 text-base">{{ __('Login') }}</a>

				@endauth
				@else
				@role('admin')
				<div class="fixed top-0 right-0 px-6 py-4">
					<div class="flex">
						<a href="{{ route('dashboard') }}" class="text-base mr-4">Dashboard</a>
						<!-- Authentication -->
						<form method="POST" action="{{ route('logout', ['cliente' => $cliente->id]) }}">
							@csrf
							<a :href="route('logout', ['cliente' => $cliente->id])" class="text-base"
								onclick="event.preventDefault(); this.closest('form').submit();">
								{{ __('Log Out') }}
							</a>
						</form>
					</div>
				</div>
				@endrole
				@endif
			</div>
		</div>
	</div>
	@foreach ($cliente->flotantes as $flotante)
	<div class="fixed {{ $flotante->posicion }} m-5" style="z-index: 5000; font-size: 0.9em;">
		<div class="py-3 px-5 text-white rounded-full "
			style="background-color: {{ $flotante->color }}; font-weight: bold;">
			<a href="{{ $flotante->link }}" target="{{ $flotante->target }}">{{ $flotante->texto }} <i
					class="{{ $flotante->icono }}"></i></a>
		</div>
	</div>
	@endforeach
	<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
	<script src="{{ asset('assets/alx-jquery.js') }}"></script>
	<script>
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
				var card = $("<div>", { class: "card", "data-index": i, id: "carta-"+i });
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
				Swal.fire({
					icon: null,
					title: null,
					width: '22em',
					focusConfirm: false,
					returnFocus: false,
					html: `<div class="flex flex-row justify-center items-center">
						<dotlottie-player src="https://lottie.host/8098cf36-fe3e-4181-b9f5-1bf97918a3ee/9KuD05DkOl.json" background="transparent" speed="1" style="width: 150px; height: auto;" loop autoplay></dotlottie-player>
						</div>
						<div class="font-extrabold text-4xl">¡Felicidades!</div>
						<div class="mt-5 flex flex-row justify-center font-bold">
							<div class="mr-4">
								<div class="color">Tiempo:</div>
								<div class="">${timer} seg</div>
							</div>
							<div>
								<a href="#" class="btn-pill restart-game">Reiniciar</a>
							</div>
						</div>
						`,
					showConfirmButton: false
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
				console.log('sdfsdf');
				restartGame();
			});
			// Iniciar el juego al cargar la página
			startGame();
		});
	</script>
	<style>
		.swiper {
			width: 100%;
			height: auto;
			overflow: hidden;
		}

		.swiper-pagination-bullet {
			width: 16px !important;
			height: 16px !important;
			background: #E6E6E6 !important;
			opacity: 1 !important;
		}

		.slide-bg {
			height: calc(100vh - 72px)!important;
		}

		@media (max-width: 800px) {
			.slide-bg {
				height: calc(60vh)!important;
			}
		}

		body {
			background-color: {{ $cliente->color_bg }} !important;
			color: {{ $cliente->color_base }} !important;

			@if($cliente->imagen_background != '')
			background-image: url('{{ asset('storage/'.$cliente->imagen_background) }}');
			background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
			@endif
		}

		#header {
			/*background-color: {{ $cliente->color_bg }} !important;*/
			background-color: transparent !important;
		}
		#header-back{
		    background-color: {{ $cliente->color_bg }};
		    height: 100%;
		    width: 100%;
		    display: block;
		    position: absolute;
		    z-index: -1;
		    opacity: 0.8;
		    left: 0px;
		    top: 0px;

		}

		.btn-pill {
			background-color: {{ $cliente->color }} !important;
		}

		.color {
			color: {{ $cliente->color }} !important;
		}

		.bg-client {
			background-color: {{ $cliente->color }} !important;
		}

		.current-cat {
			color: #FFF;
			background-color: {{ $cliente->color }} !important;
		}

		.swiper-pagination-bullet-active {
			background: {{ $cliente->color }} !important;
		}

		.card .back {
			background: #000000 url('{{asset('storage/clientes/games/memory/'.trim($imgBack))}}') no-repeat center center;
			background-size: cover;
		}

		.isotope-menu-item:hover{
		    color: #000000;
		}
		@media (min-width: 1024px){
			.lg\:text-8xl {
			    font-size: 3rem;
			}
		}
		.swal2-popup {
			width: 95%!important;
			max-width: 520px!important;
		}
	</style>
</body>

</html>
