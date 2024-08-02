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
	<script src="https://kit.fontawesome.com/6167140cfb.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://unpkg.com/@popperjs/core@2"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body class="font-sans antialiased">
	<div class="min-h-screen bg-white">
		@include('layouts.navigation')

		<!-- Page Heading -->
		<header class="bg-gray-100 shadow">
			<div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
				{{ $header }}
			</div>
		</header>

		<!-- Page Content -->
		<main>
			{{ $slot }}
		</main>
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
