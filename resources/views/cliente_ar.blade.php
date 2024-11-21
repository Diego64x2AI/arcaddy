<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $cliente->cliente}}</title>
	<meta name="description" content="{{ $cliente->metadescription}}">
	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/6167140cfb.js" crossorigin="anonymous"></script>
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
	model-viewer {
        width: 100%;
        height: 85vh; /* Ajusta el tamaño para que sea más visible y haya espacio para el botón y el texto */
        background-color: #FFFFFF; /* Fondo gris oscuro para el model-viewer */
      }
			#ar-prompt {
        display: none; /* Oculta el ícono de la esquina */
      }

      .icon-ar {
        width: 24px; /* Tamaño ajustable del icono */
        height: 24px;
      }
	</style>
</head>

<body class="font-sans antialiased overflow-x-hidden">
	@include('componentes.header')
	<main>
		<!-- <model-viewer> HTML element -->
		<model-viewer src="{{ asset('storage/'.$pagina->glb) }}" ar ar-modes="scene-viewer webxr quick-look" ios-src="{{ asset('storage/'.$pagina->usdz) }}" camera-controls tone-mapping="neutral" poster="{{ asset('storage/'.$pagina->imagen) }}" shadow-intensity="1" autoplay>
			<div class="progress-bar hide" slot="progress-bar">
					<div class="update-bar"></div>
			</div>
			<button slot="ar-button" style="display:none;" id="hidden-ar-button"></button> <!-- Oculta el botón de AR por defecto -->
			<div id="ar-prompt">
				<img src="{{ asset('images/ar_hand_prompt.png') }}">
			</div>
		</model-viewer>
		<div class="p-5 max-w-5xl mx-auto lg:px-8 lg:mt-10">
			{!! $pagina->texto !!}
		</div>
		<div class="text-center mt-5">
			<a id="custom-ar-button" href="javascript:startAR()" class="btn-pill">
				<img src="{{ asset('images/ic_view_in_ar_new_googblue_48dp.png') }}" alt="AR Icon" class="w-[24px] h-auto inline-block">
				{{ $pagina->boton_texto }}
			</a>
		</div>
	</main>
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
	<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>
	<script>
		// Handles loading the events for <model-viewer>'s slotted progress bar
		const onProgress = (event) => {
			const progressBar = event.target.querySelector('.progress-bar');
			const updatingBar = event.target.querySelector('.update-bar');
			updatingBar.style.width = `${event.detail.totalProgress * 100}%`;
			if (event.detail.totalProgress === 1) {
				progressBar.classList.add('hide');
				event.target.removeEventListener('progress', onProgress);
			} else {
				progressBar.classList.remove('hide');
			}
		};
		document.querySelector('model-viewer').addEventListener('progress', onProgress);
		function startAR() {
			const modelViewer = document.querySelector('model-viewer');
			modelViewer.activateAR();
		}
	</script>
	<script>
		const votar_url = '{{ route('votar') }}';
		window.addEventListener('load', function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').css('paddingTop', $('#header').innerHeight());
			$('.accordeon-link').click(function(){
				// close other accordions
				$('.accordeon-link').not(this).removeClass('open').find('i').removeClass('fa-minus').addClass('fa-plus');
				$('.accordeon-link').not(this).next().slideUp();
				$(this).next().slideToggle();
				$(this).toggleClass('open').find('i').toggleClass('fa-plus fa-minus');
			});
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
					votoshtml = `<div class="text-center mt-2 votos-${id}">${votos} {{ __('arcaddy.votes') }}</div>`
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
						'<i class="fa fa-thumbs-up"></i> {{ __('arcaddy.vote') }}',
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
								title: error.responseJSON.message.replace('Too Many Attempts.', '{{ __('arcaddy.alreadyvoted') }}')
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
			new Swiper('#colaboradores-swiper', {
				// Optional parameters
				direction: 'horizontal',
				slidesPerView: 1,
				spaceBetween: 0,
				centerInsufficientSlides: true,
				autoHeight: false,
				autoplay: {
					delay: 3000,
					disableOnInteraction: true,
				},
				breakpoints: {
					1024: {
						slidesPerView: 3,
						spaceBetween: 0,
					},
					1280: {
						slidesPerView: 3,
						spaceBetween: 0,
					},
					1366: {
						slidesPerView: 4,
						spaceBetween: 0,
					},
					1600: {
						slidesPerView: 5,
						spaceBetween: 0,
					},
				},
				loop: false,
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
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
	@include('componentes.estilos')
</body>

</html>
