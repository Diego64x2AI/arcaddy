<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
	<main>
		{{--
		<div class="flex items-center justify-center py-5">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		--}}
		@foreach($cliente->secciones()->where('activa', 1)->get() as $seccion)
			@includeIf('secciones.'.$seccion->seccion)
		@endforeach
	</main>
	<footer class="mt-5">
		<div class="flex items-center justify-center">
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-full h-auto max-w-xs" alt="{{ $cliente->cliente }}">
		</div>
		@if ($cliente->secciones()->where('activa', 1)->where('seccion', 'social')->count() > 0)
		<div class="text-center mt-5">
			<div class="text-xl">Síguenos:</div>
			<div class="text-center mt-3 flex flex-row items-center justify-center">
			@if ($cliente->instagram !== '' && $cliente->instagram !== NULL)
			<a href="{{ $cliente->instagram }}" target="_blank" class="mr-2"><img src="{{ asset('images/instagram.png') }}" class="object-fit w-14 h-auto" alt="Instagram"></a>
			@endif
			@if ($cliente->facebook !== '' && $cliente->facebook !== NULL)
			<a href="{{ $cliente->facebook }}" target="_blank" class="mr-2"><img src="{{ asset('images/facebook.png') }}" class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cliente->twitter !== '' && $cliente->twitter !== NULL)
			<a href="{{ $cliente->twitter }}" target="_blank" class="mr-2"><img src="{{ asset('images/twitter.png') }}" class="object-fit w-14 h-auto" alt="Twitter"></a>
			@endif
			@if ($cliente->tiktok !== '' && $cliente->tiktok !== NULL)
			<a href="{{ $cliente->tiktok }}" target="_blank" class="mr-2"><img src="{{ asset('images/tiktok.png') }}" class="object-fit w-14 h-auto" alt="Tiktok"></a>
			@endif
			@if ($cliente->whatsapp !== '' && $cliente->whatsapp !== NULL)
			<a href="{{ $cliente->whatsapp }}" target="_blank"><img src="{{ asset('images/whatsapp.png') }}" class="object-fit w-14 h-auto" alt="Whatsapp"></a>
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
						@role('admin')
						<a href="{{ route('dashboard') }}" class="text-base mr-4 hidden md:inline-block">Dashboard</a>
						@endrole
						<div class="text-base mr-4 font-bold">
							<a href="{{ route('registro', ['cliente' => $cliente->id]) }}" class="text-base">
								Hola {{ auth()->user()->name }}
							</a>
						</div>
						<!-- Authentication -->
						<form method="POST" action="{{ route('logout', ['cliente' => $cliente->id]) }}">
							@csrf
							<a :href="route('logout', ['cliente' => $cliente->id])" class="text-base" onclick="event.preventDefault(); this.closest('form').submit();">
								{{ __('Log Out') }}
							</a>
						</form>
					@else
						@if (Route::has('register'))
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
	@if ($cliente->slug === 'estafeta')
		<div class="fixed right-0 bottom-0 mr-5 mb-5" style="z-index: 5000">
			<div class="bg-[#25D366] py-3 px-5 text-white rounded-full text-xl">
				<a href="https://wa.me/5213326293396?" target="_blank">Ayuda <i class="fa fa-whatsapp"></i></a>
			</div>
		</div>
	@endif
	<script>
		const votar_url = '{{ route('votar') }}';
		window.addEventListener('load', function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').css('paddingTop', $('#header').innerHeight())
			const iso = new Isotope( '.grid', {
				itemSelector: '.isotope-item',
				percentPosition: true,
  			layoutMode: 'fitRows',
				stagger: 30,
				transitionDuration: '0.3s',
				masonry: {
					columnWidth: '.isotope-item'
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
				let media = '';
				let votoshtml = '';
				if (plataforma === 'google') {
					media = `<iframe src="https://drive.google.com/file/d/${video_id}/preview" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>`
				} else if (plataforma === 'vimeo') {
					media = `<iframe src="https://player.vimeo.com/video/${video_id}?h=${plataforma_user}&amp;badge=0&autopause=0&player_id=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>`
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
						spaceBetween: 0,
						autoHeight: false,
						grid: {
							rows: 2
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
	</style>
</body>

</html>
