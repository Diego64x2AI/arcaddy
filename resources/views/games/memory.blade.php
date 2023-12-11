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
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
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
	.alx-btn-add-calendario{
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
        body{
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

        #restart-button{
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


        #maximo{
            width: 600px;
            margin: 0px auto;
            position: relative;
        }
        .etiquetas{
            width: 200px;
            color: #000000;
        }
        #stats-container{
            color: {{ $cliente->color }};
        }

        .datos{
            float: left;
            margin-right: 20px;
            line-height: 40px;
        }
        .l{
            clear: both;
            margin-bottom: 40px;
        }

        .der{
            margin-right: 10px;
        }

        .en-mobile{
            display: none;
        }
        @media screen and (max-width: 599px) {

            body{
                font-size: 12px;
            }
            #maximo{
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
            .datos{
                width: 150px;
                line-height: 20px;
            }
            .en-mobile{
                display: block;
            }
             .l{
            
                margin-bottom: 10px;
            }
        }
        #game-container::after {
            content: ""; /* Contenido vacío */
            display: table;
            clear: both;
        }
        #btn-regresar-de-juego{
            margin: 10px;
        }




    </style>
	
	
	
</head>

<body class="font-sans antialiased">
	<main>
	   
	    <a class="btn-pill" id="btn-regresar-de-juego" href="{{route('cliente', $cliente->slug)}}">Regresar</a>
	    <h1 class="text-center px-5 py-5 text-4xl font-extrabold lg:text-8xl" style="color: {{ $cliente->color }};">{!! $juego->nombre !!}</h1>
	    
	    <div class="text-center" style="font-weight: 400;">
	        {!! $juego->descripcion !!}
	    </div>
	    <br><br>
	
		
        <div id="maximo">
        <div id="stats-container">
            <div class="datos">
                <span class="etiquetas">Aciertos:</span> <span id="correct-count" class="der">0</span>
                <div class="en-mobile"></div>
                <span class="etiquetas">Errores:</span> <span id="error-count"  class="der">0</span>
                <div class="en-mobile"></div>
                <span class="etiquetas">Tiempo:</span> <span id="timer"  class="der">0</span>seg.
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
			<a href="{{ $cliente->instagram }}" target="_blank" class="mr-2"><img src="{{ asset('images/instagram.png') }}?v=1" class="object-fit w-14 h-auto" alt="Instagram"></a>
			@endif
			@if ($cliente->facebook !== '' && $cliente->facebook !== NULL)
			<a href="{{ $cliente->facebook }}" target="_blank" class="mr-2"><img src="{{ asset('images/facebook.png') }}?v=1" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cliente->twitter !== '' && $cliente->twitter !== NULL)
			<a href="{{ $cliente->twitter }}" target="_blank" class="mr-2"><img src="{{ asset('images/twitter.png') }}?v=1" class="object-fit w-14 h-auto" alt="Twitter"></a>
			@endif
			@if ($cliente->tiktok !== '' && $cliente->tiktok !== NULL)
			<a href="{{ $cliente->tiktok }}" target="_blank" class="mr-2"><img src="{{ asset('images/tiktok.png') }}?v=1" class="object-fit w-14 h-auto" alt="Tiktok"></a>
			@endif
			@if ($cliente->whatsapp !== '' && $cliente->whatsapp !== NULL)
			<a href="{{ $cliente->whatsapp }}" target="_blank"><img src="{{ asset('images/whatsapp.png') }}?v=1" class="object-fit w-14 h-auto" alt="Whatsapp"></a>
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
				<img src="{{ asset('storage/'.$cliente->logo) }}" style="height: 40px; width:auto" alt="{{ $cliente->cliente }}">
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
    					
    						<a href="{{route('registro',['cliente' => $cliente->id])}}?ver=1" class="text-base mr-4 hiddenalex md:inline-block">Mi QR</a>
    					
						@endrole

						<!-- Authentication -->
						<form method="POST" action="{{ route('logout', ['cliente' => $cliente->id]) }}">
							@csrf
							<a :href="route('logout', ['cliente' => $cliente->id])" class="text-base" onclick="event.preventDefault(); this.closest('form').submit();">
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
								<a :href="route('logout', ['cliente' => $cliente->id])" class="text-base" onclick="event.preventDefault(); this.closest('form').submit();">
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
			<div class="py-3 px-5 text-white rounded-full " style="background-color: {{ $flotante->color }}; font-weight: bold;">
				<a href="{{ $flotante->link }}" target="{{ $flotante->target }}">{{ $flotante->texto }} <i class="{{ $flotante->icono }}"></i></a>
			</div>
		</div>
	@endforeach
	<script>
		const votar_url = '{{ route('votar') }}';
		window.addEventListener('load', function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').css('paddingTop', $('#header').innerHeight())
			if ($('.isotope-votaciones').length > 0) {
				const iso = new Isotope( '.isotope-votaciones', {
					itemSelector: '.isotope-votaciones-item',
					percentPosition: true,
					layoutMode: 'masonry', /*fitRows*/
					stagger: 30,
					transitionDuration: '0.3s',
					masonry: {
						columnWidth: '.isotope-votaciones-item'
					}
				})
				// filter items on button click
				$('.filter-button-group').on( 'click', 'button', function() {
					$('.filter-button-group button').removeClass('current-cat');
					$(this).addClass('current-cat');
					var filterValue = $(this).attr('data-filter');
					iso.arrange({ filter: filterValue })
					/*
					iso.arrange({
						// item element provided as argument
						filter: function( itemElem ) {
							var number = itemElem.querySelector('.number').innerText;
							return parseInt( number, 10 ) > 50;
						}
					})
					*/
					// iso.Isotope({ filter: filterValue });
				});
			}
			if ($('.isotope-menu').length > 0) {
				const iso = new Isotope( '.isotope-menu', {
					itemSelector: '.isotope-menu-item',
					percentPosition: true,
					layoutMode: 'fitRows',
					stagger: 30,
					transitionDuration: '0.3s',
					masonry: {
						columnWidth: '.isotope-menu-item'
					}
				})
				// filter items on button click
				$('.filter-button-group2').on( 'click', 'button', function() {
					$('.filter-button-group2 button').removeClass('current-cat');
					$(this).addClass('current-cat');
					var filterValue = $(this).attr('data-filter');
					iso.arrange({ filter: filterValue })
				});
			}
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})
			$('.isotope-item').click(function(e) {
				e.preventDefault();
				const nombre = $(this).data('nombre');
				const categoria = $(this).data('categoria');
				let votos = Number($(this).data('votos'));
				const id = Number($(this).data('id'));
				const video_id = $(this).data('video-id');
				const plataforma = $(this).data('plataforma');
				const plataforma_user = $(this).data('plataforma-user');
				const imagen = $(this).data('imagen');
				let media = '';
				let votoshtml = '';
				if (plataforma === 'google') {
					media = `<iframe src="https://drive.google.com/file/d/${video_id}/preview" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>`
				} else if (plataforma === 'vimeo') {
					/*media = `<iframe src="https://player.vimeo.com/video/${video_id}?h=${plataforma_user}&amp;badge=0&autopause=0&player_id=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>`*/
					
					media = `<iframe src="https://player.vimeo.com/video/${video_id}?autopause=0&player_id=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>`
					
					
					

					
				} else if( plataforma === 'youtube'){
				    	media = `<iframe  src="https://www.youtube.com/embed/${video_id}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen  style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>`
				    	
				} else if( plataforma === 'imagen'){
				    	//media = `<img src="${imagen}" class="img-general inline-block object-cover w-full h-auto" />`
				    	media = `<div class="img-votacion-detalle" style="background-image: url(${imagen})"></div>`
				}
				if ($(this).data('votaciones') === 'Y') {
					votoshtml = `<div class="text-center mt-2 votos-${id}">${votos} votos</div>`
				}
				console.log('abrir', nombre, categoria, votos, video_id);
				Swal.fire({
					title: `<div class="font-bold uppercase mt-5 text-base color">${nombre}</div>`,
					icon: null,
					html: `<div class="aspect-w-16 aspect-h-9">${media}</div>${votoshtml}`,
					showCloseButton: true,
					showCancelButton: false,
					showConfirmButton: ($(this).data('votaciones') === 'Y'),
					focusConfirm: true,
					buttonsStyling: false,
					customClass: {
						confirmButton: 'btn-pill',
					},
					confirmButtonText:
						'<i class="fa fa-thumbs-up"></i> Votar',
					confirmButtonAriaLabel: 'Votar',
					cancelButtonText:
						'<i class="fa fa-thumbs-down"></i>',
					cancelButtonAriaLabel: 'Thumbs down'
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {
						$.ajax({
							url: votar_url,
							type: 'POST',
							data: {
								id: id,
							},
						}).then(function(data){
							console.log(data)
							$(`.participante-${id}`).data('votos', data.votos);
							$(`.votos-${id}`).html(`${data.votos} votos`);
							Toast.fire({
								icon: 'success',
								title: data.message
							})
						}).fail(function(error){
							console.log(error.responseJSON.message)
							Toast.fire({
								icon: 'error',
								title: error.responseJSON.message.replace('Too Many Attempts.', 'Ya votaste por este participante.')
							})
						});
					}
				})
			});
			$('.filter-button-group button:eq(0)').trigger('click');
			$('.filter-button-group2 button:eq(0)').trigger('click');
			new Swiper('.swiper-1', {
				// Optional parameters
				direction: 'horizontal',
				loop: false,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
				pagination: {
					el: '.swiper-pagination',
				},
			});
			new Swiper('.swiper-2', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 2,
				spaceBetween: 10,
				centerInsufficientSlides: true,
				autoHeight: true,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 0,
					},
				},
				loop: false,
				pagination: {
					el: '.swiper-pagination',
				},
			});
			new Swiper('.swiper-3', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				autoHeight: true,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 0,
					},
				},
				loop: false,
				pagination: {
					el: '.swiper-pagination',
				},
			});
			new Swiper('.swiper-galeria', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				loop: false,
				autoHeight: true,
				autoplay: {
          delay: 3000,
          disableOnInteraction: true,
        },
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 10,
						autoHeight: false,
						grid: {
							rows: ($('.swiper-galeria .swiper-slide').length >= 6) ? 1 : 1,
						}
					},
				},
				pagination: {
					el: '.swiper-pagination',
				},
			});
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
			background-color: {{ $cliente->color_bg }} !important;
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
		
		.isotope-menu-item:hover{
		    color: #000000;
		}
	</style>
	<script src="{{ asset('assets/jquery-3.6.4.min.js') }}"></script>
	<?php /*style="background-image: url({{ asset('storage/clientes/games/memory/'.$c->imagen) }});"*/?>
	<script>
    $(document).ready(function () {
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
                if($c->frente == 1){
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
                alert("¡Felicidades! Has completado el juego en " + timer + " segundos.");
            }
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

       
      
        

        // Manejar clic en el botón de reinicio
        $("#restart-button").click(restartGame);


        // Iniciar el juego al cargar la página
        startGame();
    });
</script>
<style>
.card .back { 
    background: #000000 url('{{asset('storage/clientes/games/memory/'.$imgBack)}}') no-repeat center center;
    background-size: cover;
}
</style>
</body>

</html>