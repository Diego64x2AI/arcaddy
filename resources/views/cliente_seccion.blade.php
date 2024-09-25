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
	@include('componentes.header')
	<main>
		@if($pagina->banners)
		<section id="banners">
			<!-- Slider main container -->
			<div class="swiper swiper-1">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					@foreach($pagina->banners2 as $banner)
					<div class="swiper-slide bg-cover bg-center slide-bg" style="background-image: url({{ asset('storage/'.$banner->archivo) }});">
						@if ($banner->link !== NULL && trim($banner->link) !== '')
							<a href="{{ $banner->link }}" style="text-indent: -8000px;display:block;width:100%;height:100%;">{{ __('arcaddy.link') }}</a>
						@endif
					</div>
					@endforeach
				</div>
				<div class="swiper-button-next">
					<i class="fa fa-chevron-right"></i>
				</div>
				<div class="swiper-button-prev">
					<i class="fa fa-chevron-left"></i>
				</div>
			</div>
		</section>
		@endif
		<div class="px-5 mt-5">
			{!! $pagina->texto !!}
		</div>
		@if($pagina->boton_texto !== NULL && trim($pagina->boton_texto) !== '' && $pagina->boton_link !== NULL && trim($pagina->boton_link) !== '')
		<div class="text-center mt-5">
			<a href="{{ $pagina->boton_link }}" class="btn-pill">{{ $pagina->boton_texto }}</a>
		</div>
		@endif
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
	<!-- prettier-ignore -->
	<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
		({key: "AIzaSyDl98_79CXXgbwn8UQflos9q_QAJO44Mlw", v: "weekly"});</script>
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
