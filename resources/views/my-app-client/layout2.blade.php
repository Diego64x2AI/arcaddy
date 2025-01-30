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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
	<!-- Font Awesome Icons -->
	<link href="{{ asset('fontawesome-free-6.7.2-web/css/all.min.css') }}" rel="stylesheet">
	<script src="{{ asset('fontawesome-free-6.7.2-web/js/all.min.js') }}"></script>
	<script type="text/javascript" src="https://unpkg.com/@popperjs/core@2"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body class="font-sans antialiased">
	<div class="min-h-screen bg-white">

		<!-- Page Content -->
		<main>
			@yield('content')
		</main>

		<footer class="fixex flex flex-row items-center px-5 z-[99999] w-full h-[70px] left-0 bottom-0 bg-center bg-no-repeat bg-[#0C060C]" style="background-image: url({{ asset('images-my-app/footer.png') }});">
			<div class="">
				<img src="{{ asset('images-my-app/logo-footer.png') }}" alt="Arcaddy" class="w-full h-auto">
			</div>
			<div class="ml-auto">
				<img src="{{ asset('images-my-app/txt-footer.png') }}" alt="Reallity is an illusion" class="w-full h-auto">
			</div>
		</footer>
	</div>
	<script>
		window.addEventListener('load', function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('.open-modal').click(function(e){
				e.preventDefault();
				$('div#'+$(this).data('id')).toggleClass('opacity-0').toggleClass('pointer-events-none');
				$('body').addClass('modal-active');
			});
			$('.modal-close').click(function(e){
				e.preventDefault();
				$(this).parent().parent().parent().parent().addClass('opacity-0').addClass('pointer-events-none');
				$('body').removeClass('modal-active');
			});
		});
	</script>
	@yield('js')
</body>

</html>
