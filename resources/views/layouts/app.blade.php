<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
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
	@yield('js')
</body>

</html>
