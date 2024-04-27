@php
$classes = $cliente->id === NULL ? 'degradado pb-20' : 'bg-gray-100 pb-20';
@endphp
<x-guest-layout :classes="$classes">
	<x-auth-card>
		<x-slot name="logo">
			<div class="flex justify-center w-full sm:max-w-md mt-5">
				<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-10 fill-current text-gray-500"></a>
			</div>
			<h1 class="text-center font-extrabold text-3xl mt-3 w-full sm:max-w-md">{{ __('arcaddy.forbbiden') }}</h1>
		</x-slot>
		{{--  <iframe src="https://drive.google.com/file/d/13gjNCbpJVPrsNMcTS2KBXmZa0Z0jOSKS/preview" width="640" height="480" allow="autoplay"></iframe>--}}
		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<p class="text-center">{{ __('arcaddy.forbbiden-geo') }}</p>

		<form method="POST" action="{{ route('zipcode', ['cliente' => $cliente->id]) }}">
			@csrf
			<div class="mt-4 text-center">
				<x-input id="zip" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full text-center" maxlength="5" type="hidden" name="zip" required />
			</div>

			<div class="flex items-center justify-center mt-4">
				<x-button type="button" class="ml-3 btn-pill">
					{{ __('arcaddy.geo') }}
				</x-button>
			</div>
		</form>
	</x-auth-card>
	<div class="h-10"></div>
</x-guest-layout>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRqk485J7yKVmbEh9SKbUhJm01tylP_jI&v=weekly"
      defer
    ></script>
<script>
	window.addEventListener('load', function() {
		$('form button').click(function() {
			console.log('click');
			if(navigator.geolocation) {
				Swal.fire({
					title: '{{ __('arcaddy.geo-title') }}',
					allowEscapeKey: false,
					allowOutsideClick: false,
				});
				Swal.showLoading()
				navigator.geolocation.getCurrentPosition(function(position) {
					console.log(position)
					var lat = position.coords.latitude;
					var long = position.coords.longitude;
					var point = new google.maps.LatLng(lat, long);
					new google.maps.Geocoder().geocode(
						{'latLng': point},
						function (res, status) {
							Swal.close()
							const zip_code = res[0].address_components.find(addr => addr.types[0] === "postal_code").short_name;
							console.log(zip_code)
							$("#zip").val(zip_code);
							$('form').submit();
						}
					);
    		});
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: '{{ __('arcaddy.geo-error') }}',
				});
			}
		});
	});
</script>
<style>
	.swal2-popup {
    width: inherit!important;
    max-width: inherit!important;
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
</style>
