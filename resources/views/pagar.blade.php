<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://js.stripe.com/v3/"></script>
</head>

<body class="font-sans antialiased">
	<main class="max-w-7xl mx-auto pt-10 px-5">
		<div class="col-span-1 lg:col-span-6">
			<h4 class="text-3xl text-gray-700 mb-5">Completar el pago</h4>
			<div class="p-5 rounded-md shadow-xl border bg-white">
				<div class="mb-6">
					<input id="card-holder-name" placeholder="Nombre en la tarjeta" type="text"
						class="border border-[#ebebeb] rounded-md inline-block py-2 px-3 w-full text-gray-600 tracking-wider" />
				</div>
				<div id="card-element"></div>
				<button id="card-button"
					class="w-full text-ceenter px-4 py-3 bg-lime-500 rounded-md shadow-md text-white font-semibold">
					PAGAR
				</button>
			</div>
		</div>
		</div>
	</main>
	<div id="loading-overlay" class="fixed hidden top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-900 opacity-90 flex-col items-center justify-center">
		<div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
		<p class="w-1/3 text-center text-white">Espera mientras se completa la petición.</p>
	</div>
	<footer class="mt-5 fixed left-0 bottom-0 w-full">
		<div class="degradado px-5 py-6 mt-5 text-white">
			<div class="flex flex-row items-center justify-between">
				<div>
					<img src="{{ asset('images/logo@2x.png') }}" class="block h-6 w-auto fill-current text-gray-600">
				</div>
				<div class="text-lg">Reality is an illusion...</div>
			</div>
		</div>
	</footer>
	<style>
		input {
			border-radius: 6px;
			margin-bottom: 6px;
			padding: 12px;
			border: 1px solid rgba(50, 50, 93, 0.1);
			height: 44px;
			font-size: 16px;
			width: 100%;
			background: white;
		}

		#card-error {
			color: rgb(105, 115, 134);
			text-align: left;
			font-size: 13px;
			line-height: 17px;
			margin-top: 12px;
		}

		#card-element {
			border-radius: 4px 4px 0 0;
			padding: 12px;
			border: 1px solid #ebebeb;
			height: 44px;
			width: 100%;
			background: white;
			margin-bottom: 2rem;
		}
	</style>
	<script>
		var style = {
      base: {
        color: "#32325d",
        fontFamily: 'Raleway',
				border: '1px solid #ccc',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#32325d"
        }
      },
      invalid: {
        fontFamily: 'Raleway',
        color: "#fa755a",
				border: '1px solid red',
        iconColor: "#fa755a"
      }
    };
		const loading = document.getElementById('loading-overlay');
		const clientSecret = '';
    const stripe = Stripe('pk_test_51HeO3eEM3ObKIyFDdzWJN4C5gDwJp6AuJIjqL5vvuFfSmQOgx036j8ACG1ECF3fKAz3kPHSHj8m0tgXZjPn54URk00Id1hgP6v');
    const elements = stripe.elements();
    const cardElement = elements.create('card', { style: style });
    cardElement.mount('#card-element');
		const cardHolderName = document.getElementById('card-holder-name');
		const cardButton = document.getElementById('card-button');
		cardButton.addEventListener('click', async (e) => {
			loading.classList.remove('hidden');
			loading.classList.add('flex');
			const { paymentMethod, error } = await stripe.createPaymentMethod(
				'card', cardElement, {
					billing_details: { name: cardHolderName.value }
				}
			);
			if (error) {
				loading.classList.add('hidden');
					loading.classList.remove('flex');
				// Display "error.message" to the user...
				Swal.fire({
					title: 'Error',
					text: error.message,
					icon: 'error'
				});
			} else {
				// console.log('paymentMethod.id', paymentMethod.id);
				axios.post('{{ route("charge") }}', {
					payment_id: paymentMethod.id
				})
				.then(function (response) {
					loading.classList.add('hidden');
					loading.classList.remove('flex');
					console.log(response.data.message);
					window.location.href = '{{ route("gracias") }}';
				})
				.catch(function (error) {
					loading.classList.add('hidden');
					loading.classList.remove('flex');
					if (error.response) {
						// The request was made and the server responded with a status code
						// that falls out of the range of 2xx
						console.log(error.response.data);
						console.log(error.response.status);
						console.log(error.response.headers);
						Swal.fire({
							title: 'Error',
							text: error.response.data.message,
							icon: 'error'
						});
					} else if (error.request) {
						// The request was made but no response was received
						// `error.request` is an instance of XMLHttpRequest in the browser and an instance of
						// http.ClientRequest in node.js
						console.log(error.request);
						Swal.fire({
							title: 'Error',
							text: error.request,
							icon: 'error'
						});
					} else {
						// Something happened in setting up the request that triggered an Error
						console.log('Error', error.message);
						Swal.fire({
							title: 'Error',
							text: error.message,
							icon: 'error'
						});
					}
				});
			}
		});
	</script>
</body>

</html>
