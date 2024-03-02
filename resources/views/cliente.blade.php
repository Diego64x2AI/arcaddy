<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $cliente->cliente}} <?php  /*{{ config('app.name', 'Laravel') }}*/ ?></title>
	<meta name="description" content="{{ $cliente->metadescription}}">
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
</head>

<body class="font-sans antialiased overflow-x-hidden">
	<main>
		{{--
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		--}}

		@if($cliente->id != 82)
		@foreach($cliente->secciones()->where('activa', 1)->get() as $seccion)
			@includeIf('secciones.'.$seccion->seccion)


		@endforeach
		@else
		@foreach($cliente->secciones()->where('activa', 1)->get() as $seccion)
			@includeIf('secciones.'.$seccion->seccion)
			@if($seccion->seccion == "libres")


	    <!-- Alebrije -->
        <link type="text/css" href="https://ar-caddy.com/projects/ar-scio/styles.css" rel="stylesheet"/>
        <style>
        #libres{
            display: none;
        }
        #alebrije{
            height: 400px;
            width: 100%;
            margin: 0px auto;
        }
        @media screen and (min-width: 768px) {
            #alebrije{
                height: 340px;
                 width: 50%;
            }
        }
        @media screen and (min-width: 992px) {
            #alebrije{
                height: 340px;
                 width: 50%;
            }
        }
         @media screen and (min-width: 1200px) {
            #alebrije{
                height: 600px;
                 width: 50%;
            }
        }
        #alx-base-3d{
            position: relative;
        }
        #alx-tapa-3d{
            position: absolute;
            height: 100%;
            width: 100%;
            z-index: 10;
            left: 0px;
            top: 0px;
        }
        #alx-btn-simula-ver{
                background-image: url('https://ar-caddy.com/projects/ar-scio/ar_icon.png');
                background-repeat: no-repeat;

                background-size: 20px 20px;
                background-position: 12px 50%;
                width: 170px;
                height: 30px;
                border: 1px solid #DADCE0;
                border-radius: 20px;
                font-size: 12px;
                line-height: 30px;
                text-align: center;
                margin: -40px auto 50px;
                position: relative;
                z-index: 10;
                color: #4285f4;
                padding-left: 22px;
                display: none;
        }
        @media screen and (max-width: 991px) {
            #alx-btn-simula-ver{
               display: block;
            }
        }
        #alebrije{
            background-color: transparent;
        }
        </style>
    <div id="alx-base-3d">
    <model-viewer id="alebrije" src="https://ar-caddy.com/projects/ar-scio/albreije volador.glb" ar ar-modes="scene-viewer webxr quick-look" camera-controls poster="https://ar-caddy.com/projects/ar-scio/poster.png" shadow-intensity="1" ios-src="https://ar-caddy.com/projects/ar-scio/Alebrije_10.usdz" autoplay>

      <div class="progress-bar hide" slot="progress-bar">
          <div class="update-bar"></div>
      </div>
      <button slot="ar-button" id="ar-button" style="display: none;">
          View in your space
      </button>
      <div id="ar-prompt">
          <img src="https://ar-caddy.com/projects/ar-scio/ar_hand_prompt.png">
      </div>
    </model-viewer>
    <div id="alx-tapa-3d"></div>
    </div>
    <div id="alx-btn-simula-ver" onclick="document.getElementById('ar-button').click();">
        View in your space
    </div>

    <script src="https://ar-caddy.com/projects/ar-scio/script.js"></script>

    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.2.0/model-viewer.min.js"></script>









			@endif

		@endforeach
		@endif






	</main>

</main>

<footer class="mt-5">
	<div class="grid grid-cols-2 px-3 items-center">
		<div><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-12" alt="{{ $cliente->cliente }}"></div>
		<div class="ml-auto">{!! file_get_contents(public_path('images/logo.svg')) !!}</div>
	</div>
	@if ($cliente->secciones()->where('activa', 1)->where('seccion', 'social')->count() > 0)
	<div class="text-center mt-5">
		<div class="text-xl">{{($cliente->id !== 82)?'Síguenos:':'Follow us:'}}</div>
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
	@auth
	<div class="text-center mt-3 pb-20">
		<!-- Authentication -->
		<form method="POST" action="{{ route('logout', ['cliente' => $cliente->id]) }}">
			@csrf
			<a :href="route('logout', ['cliente' => $cliente->id])" class="text-base flex flex-row items-center justify-center" onclick="event.preventDefault(); this.closest('form').submit();">
				<div>{!! file_get_contents(public_path('images/salir.svg')) !!}</div>
				<div class="ml-2">{{ __('Log Out') }}</div>
			</a>
		</form>
	</div>
	@endauth
</footer>
<div id="header" class="fixed top-0 right-0 w-full px-2 py-3 z-50 bg-white shadow-sm">
	<div id="header-back"></div>
	<div class="flex flex-row justify-center items-center">
		<div class="mr-auto">
			&nbsp;
		</div>
		<div class="flex flex-col md:flex-row items-center justify-center">
			<img src="{{ asset('storage/'.$cliente->logo) }}" style="height: 40px; width:auto" alt="{{ $cliente->cliente }}">
		</div>
		@auth
		<div class="ml-auto">
			@role('admin')
			<a href="{{ route('dashboard') }}">{!! file_get_contents(public_path('images/admin.svg')) !!}</a>
			@endrole
			@role('client')
			<a href="{{ route('my-app-client.home') }}">{!! file_get_contents(public_path('images/admin.svg')) !!}</a>
			@endrole
			@role('user')
			<a href="{{route('registro', ['cliente' => $cliente->id])}}?ver=1">{!! file_get_contents(public_path('images/qr.svg')) !!}</a>
			@endrole
		</div>
		@else
		<div class="ml-auto"><span class="w-10 h-auto inline-block">&nbsp;</span></div>
		@endauth
	</div>
	<div class="text-center mt-2 font-normal flex flex-row items-center justify-center">
		@auth
			{{ auth()->user()->name }}
		@else
			@if ($cliente->registro)
				@if (Route::has('register'))
				<a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="text-base">{{ __('Register') }}</a>
				<div class="ml-2">|</div>
				@endif
				<a href="{{ route('login', ['cliente' => $cliente->id]) }}" class="ml-2 text-base">{{ __('Login') }}</a>
			@endif
		@endauth
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
			if ($('.isotope-galeria').length > 0) {
				const iso = new Isotope( '.isotope-galeria', {
					itemSelector: '.isotope-galeria-item',
					percentPosition: true,
					layoutMode: 'masonry', /*fitRows*/
					stagger: 30,
					transitionDuration: '0.3s',
					masonry: {
						columnWidth: '.isotope-galeria-item'
					}
				})
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
				});
				if ($('.filter-button-group2').length > 0) {
					// filter items on button click
					$('.filter-button-group2').on( 'click', 'button', function() {
						$('.filter-button-group2 button').removeClass('current-cat');
						$(this).addClass('current-cat');
						var filterValue = $(this).attr('data-filter');
						iso.arrange({ filter: filterValue })
					});
				}
				if ($('#select-menu').length > 0) {
					$('#select-menu').change(function() {
						var filterValue = $(this).val();
						iso.arrange({ filter: filterValue })
					}).trigger('change');
				}
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
			});
			$('.isotope-galeria-item').click(function(e) {
				e.preventDefault();
				const nombre = $(this).data('titulo');
				const imagen = $(this).data('imagen');
				let media = `<img class="w-full h-auto" src="${imagen}">`;
				console.log('abrir', nombre, imagen);
				Swal.fire({
					title: `<div class="font-bold uppercase mt-5 text-base color">${nombre}</div>`,
					icon: null,
					html: `<div>${media}</div>`,
					showCloseButton: true,
					showCancelButton: false,
					showConfirmButton: false,
					focusConfirm: true,
					buttonsStyling: false,
					customClass: {
						confirmButton: 'btn-pill',
					},
				});
			});
			$('.isotope-menu-item').click(function(e) {
				e.preventDefault();
				const nombre = $(this).data('nombre');
				const imagen = $(this).data('imagen');
				const descripcion = $(this).data('descripcion');
				const canje = $(this).data('canje-texto');
				const precio = $(this).data('precio');
				const boton = $(this).data('boton');
				const link = $(this).data('link');
				const cantidad = ($(this).data('cantidad') !== null && jQuery.trim($(this).data('cantidad')) !== '') ? $(this).data('cantidad') : '';
				let media = `<img class="w-full h-auto" src="${imagen}">`;
				let canjeText = '';
				let botonHtml = '';
				if (canje !== '' && canje !== null) {
					canjeText = `<div class="absolute -bottom-3 right-0 bg-client text-[9px] text-white rounded-3xl px-3 py-2 uppercase font-semibold">${canje}</div>`;
				}
				if (boton !== '' && link !== '') {
					botonHtml = `<a href="${link}" target="_blank" class="btn-pill mt-3">${boton}</a>`;
				}
				Swal.fire({
					title: `<div class="font-bold uppercase text-xs color2">&nbsp;</div>`,
					icon: null,
					html: `
						<div class="relative">${media}${canjeText}</div>
						<div class="grow text-xl color2 mt-5 text-center w-full">
							<div class="font-semibold">${nombre}</div>
							<div class="text-xs">${cantidad}</div>
						</div>
						<div class="text-base color font-bold">${precio}</div>
						<div class="my-3 color2">${descripcion}</div>
						${botonHtml}
					`,
					showCloseButton: true,
					showCancelButton: false,
					showConfirmButton: false,
					focusConfirm: true,
					buttonsStyling: false,
					customClass: {
						popup: 'popup-menu',
						confirmButton: 'btn-pill',
					},
				});
			});
			$('.isotope-votaciones-item').click(function(e) {
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
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
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
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
      	},
			});
			new Swiper('.swiper-1', {
				// Optional parameters
				direction: 'horizontal',
				loop: false,
				autoplay: {
					delay: 3000,
					disableOnInteraction: true,
				},
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
      	},
			});

			new Swiper('.swiper-quiz', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				autoHeight: true,
				autoplay: false,
				loop: false,
				noSwiping: true,
				noSwipingClass: 'swiper-slide',
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
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
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
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
      	},
			});

			new Swiper('.swiper-experiencia', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 10,
				centerInsufficientSlides: true,
				autoHeight: true,
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 0,
					},
				},
				loop: false,
				autoplay: {
		          delay: 3000,
		          disableOnInteraction: true,
		        },
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
      	},
			});
		});
	</script>
	@php
	list($r, $g, $b) = sscanf($cliente->color_bg, "#%02x%02x%02x");
	list($r2, $g2, $b2) = sscanf($cliente->color, "#%02x%02x%02x");
	@endphp
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
		.swal2-popup {
			background-color: rgba({{ $r }},{{ $g }},{{ $b }},1)!important;
			color: {{ $cliente->color }} !important;
		}
		.swal2-confirm {
			background-color: {{ $cliente->color }} !important;
			color: {{ $cliente->color_bg }} !important;
		}
		.swiper-button-next, .swiper-button-prev {
			background: linear-gradient(270deg, rgba({{ $r }},{{ $g }},{{ $b }},0.5) 0%, rgba({{ $r }},{{ $g }},{{ $b }},1) 100%);
			color: {{ $cliente->color }} !important;
		}
		.swiper-button-next {
			background: linear-gradient(45deg, rgba({{ $r }},{{ $g }},{{ $b }},0.5) 0%, rgba({{ $r }},{{ $g }},{{ $b }},1) 100%);
		}
		.btn-pill {
			background-color: {{ $cliente->color }} !important;
		}
		[type='checkbox'], [type='radio'] {
			color: {{ $cliente->color }} !important;
		}
		select {
			background-color: {{ $cliente->color_bg }} !important;
			border-color: rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},0.5) !important;
			outline-color: transparent !important;
			color: {{ $cliente->color_base }} !important;
		}
		option, option:hover, option:focus, option:active {
			background-color: {{ $cliente->color_bg }} !important;
		}
		option:checked {
			background-color: rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},0.2) !important;
		}
		.btn-pill2 {
			background-color: {{ $cliente->color_base }} !important;
			color: {{ $cliente->color_bg }} !important;
		}
		.isotope-menu-item {
			background-color: {{ $cliente->color_bg }};
			border: 1px solid rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},0.5);
		}
		.color, .swal2-close {
			color: {{ $cliente->color }} !important;
			fill: {{ $cliente->color }} !important;
		}

		.color2 {
			color: {{ $cliente->color_base }} !important;
			fill: {{ $cliente->color_base }} !important;
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

		.img-votacion-detalle{
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
		}
		.isotope-menu-item:hover{
		    color: #000000;
		}
		@media (min-width: 1024px){
			.lg\:text-8xl {
			    font-size: 3rem;
			}
		}
	</style>
</body>

</html>
