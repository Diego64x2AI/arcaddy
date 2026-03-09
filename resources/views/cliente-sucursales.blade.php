@php
$classes = $cliente->id === NULL ? 'degradado pb-20' : 'bg-gray-100 pb-20';
@endphp
<x-guest-layout :classes="$classes">
	<div class="w-full max-w-2xl mx-auto px-5">
		@if ($cliente->id === NULL)
			<a href="{{ route('home') }}"><x-application-logo class="w-auto h-20 fill-current text-gray-500" /></a>
		@else
			<div class="flex justify-center w-full mt-5">
				<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-10 fill-current text-gray-500"></a>
			</div>
			@if($cliente->registro_img !== NULL)
				<div class="mt-3 flex flex-row justify-center">
					<img src="{{ asset('storage/'.$cliente->registro_img) }}" style="border-radius:50px" class="img-general rounded-lg shadow object-cover w-100 border border-secondary">
				</div>
			@endif
		@endif
		<h1 class="text-center font-extrabold text-xl mt-3 w-full">
			Para acceder a la plataforma selecciona tu sucursal preferida:
		</h1>
		<div id="sucursales-cercanas" class="flex flex-col gap-3 mt-10">
			<div id="sucursales-fallback" style="display:none;">
				@foreach($cliente->sucursales as $sucursal)
				<div class="shadow border bg-white rounded-lg">
					<div class="px-5 py-3 font-bold uppercase">{{ $sucursal->nombre }}</div>
					<div class="px-5 pb-3 text-sm font-semibold">
						<div>{{ $sucursal->direccion }}</div>
						<div>{{ $sucursal->ciudad }}</div>
						<div>{{ $sucursal->horario }}</div>
						<div class="mt-2">
							<a href="{{ route('cliente.sucursal', ['slug' => $cliente->slug, 'sucursal' => $sucursal->id]) }}"
							   class="btn btn-pill !rounded-none">Seleccionar sucursal</a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="h-10"></div>
</x-guest-layout>
<script>
	window.addEventListener('load', function() {
		$('body').on('click', '.accordeon-link', function() {
			// close other accordions
			$('.accordeon-link').not(this).removeClass('open').find('svg').removeClass('fa-minus').addClass('fa-plus');
			$('.accordeon-link').not(this).next().slideUp();
			$(this).next().slideToggle();
			$(this).toggleClass('open').find('svg').toggleClass('fa-plus fa-minus');
		});
		// get user location
		navigator.geolocation.getCurrentPosition(function(position) {
			document.getElementById('sucursales-fallback').style.display = 'none';
			console.log(position.coords.latitude, position.coords.longitude);
			axios.post(`{{ url('/') }}/{{ $cliente->slug }}/sucursales-cercanas`, {
				lat: position.coords.latitude,
				lng: position.coords.longitude,
				cliente: {{ $cliente->id }},
			})
			.then(response => {
				console.log(response.data);
				let sucursales = response.data.sucursales;
				if (sucursales.length > 0) {
					$('#sucursales-cercanas').empty();
					let x = 0;
					sucursales.forEach(sucursal => {
						let icon = (x === 0) ? 'fa-minus' : 'fa-plus';
						let style = (x === 0) ? 'block' : 'none';
						$('#sucursales-cercanas').append(`
							<div class="shadow border bg-white rounded-lg">
								<div class="relative rounded-3xl accordeon-link cursor-pointer px-5 py-3 uppercase font-bold">
									<div>${sucursal.nombre}</div>
									<div class="text-xs font-semibold color">${sucursal.distance.toFixed(2)} kms</div>
									<div class="absolute top-3 right-5">
										<i class="fa ${icon}"></i>
									</div>
								</div>
								<div class="px-5 pb-3 font-semibold text-sm justify-evenly" style="display:${style};">
									<div>${sucursal.direccion}</div>
									<div>${sucursal.ciudad}</div>
									<div>${sucursal.horario}</div>
									<div class="mt-2">
										<a href="{{ url('/') }}/{{ $cliente->slug }}/sucursales/${sucursal.id}" class="btn btn-pill !rounded-none">Seleccionar sucursal</a>
									</div>
								</div>
							</div>
						`);
						x++;
					});
				}
			}).catch(function(error) {
				console.log(error);
			});
		}, function() {
			const fallback = document.getElementById('sucursales-fallback');
			fallback.style.display = 'flex';
			fallback.style.flexDirection = 'column';
			fallback.style.gap = '0.75rem';
		});
	});
</script>
<style>
	.btn-pill {
		background-color: {{ $cliente->color }} !important;
	}

	.color {
		color: {{ $cliente->color }} !important;
	}

	.bg-client {
		background-color: {{ $cliente->color }} !important;
	}
</style>
