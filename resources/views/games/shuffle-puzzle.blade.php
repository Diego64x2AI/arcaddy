<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $cliente->cliente}} | {{ $juego->categoria->nombre }}</title>
	<meta name="description" content="{{ $juego->descripcion }}">
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
		#puzzle-navigation {
	padding: 0;
	margin: 0;
}

#puzzle-navigation li{
    margin: 0;
}

#puzzle-navigation ul{
    margin: 0 0 0 -8px;
}

.sh_puzzle{
	-webkit-tap-highlight-color: rgba(0,0,0,0);
	display: inline-block;
	overflow: hidden;
	z-index: 0;
	position: relative !important;
	padding: 0 !important;
	margin: 0 !important;
	direction: ltr;
}

.sh_puzzle>div.anim.mixed:before {
	content: "";
	width: inherit;
	height: inherit;
	position: absolute;
	z-index: 3;
}

.sp_bg{
  position: absolute;
  overflow: hidden;
  transition: opacity 0.1s linear;
  background: rgba(0, 0, 0, 0.73);
}

.sp_bg.visible{
  opacity: 1;
  transition-delay: 0s;
}

.spmenu,
.spmenu ul,
.spmenu ul li,
.spmenu #menu-button {
	margin: 0;
	padding: 0;
	border: 0;
	list-style: none;
	line-height: 1;
	display: block;
	position: relative;
	box-sizing: border-box;
}
.spmenu img{
	width: 20px;
	display: inline-block;
	margin-left: 9px;
	position: absolute;
	top: 3px;
	left: -7px;
	background-color: #fff;
	border-radius: 3px;
	overflow: hidden;
	box-shadow: 0 0 4px rgba(0, 0, 0, 0.34);
}

.spmenu #menu-button {
	display: none;
}

.spmenu {
	width: auto;
	font-family: 'Open Sans', sans-serif;
	line-height: 1;
	box-shadow: 0 0 16px rgba(0, 0, 0, 0.3)
}
#menu-line {
	position: absolute;
	top: 0;
	left: 0;
	height: 3px;
	background: #009ae1;
	transition: all 0.25s ease-out;
}
.spmenu > ul > li {
	float: left;
	cursor: default;
}
.spmenu > ul > li {
	padding: 8px;
	font-size: 12px;
	text-decoration: none;
	text-transform: uppercase;
	color: #000000;
	background-color: #ffffff;
	transition: color .2s ease;
}
.spmenu > ul > li:not(:last-child) {
	border-right: 1px solid #AAA;
}
.spmenu > ul > li:hover{
	color: #DDD;
	background-color: #333;
}
.spmenu ul ul {
	position: absolute;
	padding-top: 8px;
	left: -9999px;
	margin-left: -8px;
}
.spmenu li:hover > ul {
	left: auto;
}
.spmenu ul ul ul {
	margin-left: 100%;
	top: 0;
}
.spmenu ul li:hover > ul > li {
	height: 26px;
}
.spmenu ul ul li {
	white-space: nowrap;
	padding: 8px;
	font-size: 12px;
	background: #333333;
	text-decoration: none;
	color: #dddddd;
	transition: color .2s ease;
}
.spmenu ul ul li span {
	padding-left: 16px;
}

.spmenu ul ul li:hover {
	color: #ffffff;
	background-color: #000;
}

.sh_puzzle * {
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	/* font-family: 'Open Sans', sans-serif; */
	line-height: 1;
}

.sh_puzzle img {
	max-width: none !important;
	display: inline-block;
}

.sh_puzzle span.numbering {
	position: absolute;
	background-color: #0000007d;
	font-size: 15px;
	line-height: 20px;
	width: 20px;
	height: 20px;
	text-align: center;
	color: white;
	right: 0;
	/* top: 50%; */
	/* left: 50%; */
	/* transform: translate(-50%, -50%); */
	display: inline-table;
}

.sh_puzzle>div.anim:before {
	content: "";
	width: inherit;
	height: inherit;
	position: absolute;
	box-sizing: border-box;
}
.sh_puzzle>div.anim {
	transition-property: left, top, right, bottom;
	transition-timing-function: ease-out;
	transition-delay: 0s;
	transition-duration: 200ms;
}

.sh_puzzle>div.anim.mixed:before {
  border: #E91E63 1px solid;
}
		.sp_box {
  width: 100%;
  height: 100%;
  opacity: 0;
  visibility:hidden;
  transition:visibility 0.5s linear,opacity 0.5s linear;
  background: rgba(0, 0, 0, 0.73);
  position: absolute;
  z-index: 9999;
}
.sp_box.visible {
  visibility:visible;
  opacity:1;
  transition-delay:0s;
}

.sp_box > div{
  display: table;
  width: 100%;
  height: 100%;
}
.sp_box > div > div > *{
  margin: 0;
}
.sp_box > div > div {
  color: #EBEBEB;
  font-family: 'Open Sans', sans-serif;
  font-size: 46px;
  line-height: 60px;
  font-weight: bold;
  text-align: center;
  height:100%;
  width: 100%;
  display: table-cell;
  vertical-align: middle;
}

.sp_box .retry-button  {
  display: inline-block;
  background: #F3A809;
  border-bottom: 6px solid #BE7211;
  font-size: 22px;
  padding: 0 20px 5px;
  text-decoration: none;
  color: #FFFFFF;
  height: 48px;
  line-height: 50px;
  cursor: pointer;
  margin-left: 9px;
  box-sizing: content-box;
}

.sh_puzzle>div.anim:before {
  content: "";
  width: inherit;
  height: inherit;
  position: absolute;
  box-sizing: border-box;
  z-index: 3;
}

.sp_box .retry-button:hover,
.sp_box .retry-button:active {
  background: #BE7211;
}

.sp_box > div > div > .mini {
  font-size: 26px;
  line-height: 50px;
}

.sh_puzzle > .anim {
  border-radius: 5px;
}

.sh_puzzle>.mixed::before {
  border: #E91E63 1px solid;
  border-radius: 5px;
}

.sh_puzzle>.anim:hover::before {
  border: #ffffff 1px dotted;
  border-radius: 5px;
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
		<div class="px-5 max-w-2xl mx-auto">
			<div class="text-center font-bold">
				{!! $juego->descripcion !!}
			</div>
			<div class="flex flex-row justify-evenly items-center my-5">
				<div class="text-xl">
					<div class="color">{{ __('arcaddy.time') }}:</div>
					<div class="-mt-2">
						<span id="timer" class="der">0</span>{{ __('arcaddy.seconds') }}.
					</div>
				</div>
				<div class="ml-auto">
					<div class="btn-pill restart-game">{{ __('arcaddy.restart') }}</div>
				</div>
			</div>
			<div id="puzzle"></div>
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
	<script>
		let logged = {{ auth()->check() ? 'true' : 'false' }};
		let name = '{{ auth()->check() ? auth()->user()->name : '' }}';
		let images = {!! $juego->cartas->pluck('imagen') !!};
		let baseUrl = '{{ url("/storage") }}';
		let currentImage = -1;
		let correctCount = 0;
		let errorCount = 0;
		let timer = 0;
		let timerInterval;

		function saveScore() {
			const formData = new FormData();
			formData.append('tiempo', timer);
			formData.append('aciertos', correctCount);
			formData.append('errores', errorCount);
			axios.post('{{ route("cliente.save-game", ["claveJuego" => $claveJuego, "slug" => $slug]) }}', formData);
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
		function startGame() {
			currentImage++;
			if (currentImage >= images.length) {
				currentImage = 0;
			}
			configPuzzle.img_puzzle = `${baseUrl}/${images[currentImage]}`;
			console.log(configPuzzle.img_puzzle);
			$('#puzzle').empty().shufflepuzzle(configPuzzle);
			stopTimer();
			startTimer();
		}
		function restartGame() {
			Swal.close();
			stopTimer();
			timer = 0;
			correctCount = 0;
			errorCount = 0;
			currentImage = -1;
			$("#correct-count").text(correctCount);
			$("#error-count").text(errorCount);
			$("#timer").text(timer);
			startGame();
		}
		function endGame() {
			stopTimer();
			saveScore();
			let modalContent = `<div class="flex flex-row justify-center items-center">
				<dotlottie-player src="https://lottie.host/8098cf36-fe3e-4181-b9f5-1bf97918a3ee/9KuD05DkOl.json" background="transparent" speed="1" style="width: 150px; height: auto;" loop autoplay></dotlottie-player>
				</div>
				<div class="font-extrabold text-4xl color">{{ __('arcaddy.congratulations') }}</div>`;
			if (logged) {
				modalContent += `<div class="text-base">${name}</div>`;
			}
			modalContent += `<div class="mt-5 flex flex-row items-center justify-center font-bold">
					<div class="mr-4">
						<div class="color">{{ __('arcaddy.time') }}:</div>
						<div class="">${timer} {{ __('arcaddy.seconds') }}</div>
					</div>
					<div>
						<a href="#" class="btn-pill2 restart-game">{{ __('arcaddy.playagain') }}</a>
					</div>
				</div>`;
			if (!logged) {
				modalContent += `<div class="mt-7 text-base">{{ __('arcaddy.game1') }} <span class="font-bold">{{ __('arcaddy.game2') }}</span></div>
				<div class="mt-7"><a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="btn-pill">{{ __('arcaddy.game3') }}</a></div>
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
		const configPuzzle = {
			tilesH: {{ explode("x", $juego->dificultad)[0] }},
      tilesV: {{ explode("x", $juego->dificultad)[0] }},
			gap: true,
			auto_size: true,
			showStart: false,
			img_puzzle: '{{ asset("storage/".$juego->cartas->first()->imagen) }}',
			onCompleted: function() {
				correctCount++;
				$("#correct-count").text(correctCount);
				if (correctCount >= images.length) {
					endGame();
				} else {
					startGame();
				}
			},
		};
		document.addEventListener('DOMContentLoaded', function load() {
			if (!window.jQuery) return setTimeout(load, 50);
			// load puzzle js file
			let scriptElement = document.createElement('script');
			scriptElement.src = '{{ asset("js/jquery.shufflepuzzle.pack.js") }}';
			scriptElement.setAttribute("type", "text/javascript");
  		scriptElement.setAttribute("async", true);
			document.body.appendChild(scriptElement);
			// success event
			scriptElement.addEventListener("load", () => {
				console.log("File loaded")
				// Iniciar el juego al cargar la página
				startGame();
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').on('click', '.restart-game', function(e){
				e.preventDefault();
				restartGame();
			});
		});
	</script>
	@include('componentes.estilos')
</body>

</html>
