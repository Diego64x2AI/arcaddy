@extends('my-app-client.layout')



@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-redenciones">
			{{ __('arcaddy.admin11') }}<br>{{ __('arcaddy.admin12') }}
		</div>
	</div>
</div>

<div id="alx-super-cont-scaner" class="alx-back-black">
	<div class="alx-cont-scaner">
		<video id="preview" playsinline autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
		<div class="alx-escaner-lt"></div>
		<div class="alx-escaner-rt"></div>
		<div class="alx-escaner-lb"></div>
		<div class="alx-escaner-rb"></div>
	</div>

	<div class="alx-section">
		<div class="container alx-mobile">
			<div class="row">
				<div class="col-xs-12">
					<a class="alx-btn alx-btn-cerrar" href="{{route('my-app-client.reporte-redenciones')}}">{{ __('arcaddy.close') }}</a>
				</div>
			</div>
		</div>
	</div>

	<div id="alx-capa-scaner">

		<div id="alx-info-scaner" class="text-center">

			<div id="alx-info-scaner-ok" class="alx-info-scaner-ocultar">
				<img src="{{asset('/images-my-app/qrok.png')}}" class="alx-info-img-scaner">
				<br>
				<div class="alx-w-extrabold alx-txt-super">{{ __('arcaddy.admin13') }}</div>
				<br>
				<img src="{{asset('/images-my-app/qrno.png')}}" class="alx-info-img-scaner" id="alx-info-scaner-img-prodcuto">


				<div class="alx-w-extrabold alx-txt-pink alx-txt-ch" id="alx-info-scaner-nombre-producto"></div>
				<div class="alx-w-extrabold" id="alx-info-scaner-precio-producto"></div>
			</div>

			<div id="alx-info-scaner-no" class="alx-info-scaner-ocultar">
				<img src="{{asset('/images-my-app/qrno.png')}}" class="alx-info-img-scaner">
				<br>
				<div class="alx-w-extrabold alx-txt-super">
					{{ __('arcaddy.admin14') }}<br>{{ __('arcaddy.admin15') }}
			    </div>
				<br>
			</div>



			<div class="alx-w-extrabold" id="alx-info-scaner-nombre"></div>

			<div>
				<div class="alx-btn alx-btn-cerrar" id="alx-cerrar-scaner">{{ __('arcaddy.close') }}</div>
			</div>

		</div>
	</div>
	<input type="hidden" id="url-ajax" value="https://ar-caddy.com/my-app-client/producto-redencion-validar/">
	<input type="hidden" id="productoid" value="{{ $producto->id }}">

</div>

@endsection

@section('js')
<script src="{{ asset('js/jsQR.min.js')}}"></script>

<script type="text/javascript">

$( document ).ready(function() {
	const video = document.getElementById('preview');
	const canvas = document.getElementById('canvas');
	const ctx = canvas.getContext('2d');
	let scanning = false;
	navigator.mediaDevices
	.getUserMedia({ video: { facingMode: "environment" } })
	.then(function(stream) {
		video.srcObject = stream;
	})
	.catch(function(error) {
		console.error("Error al acceder a la cámara: " + error);
	});
	function escanea(){
		const interval = setInterval(function() {
			ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
			const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
			const code = jsQR(imageData.data, canvas.width, canvas.height);
			if (code) {
				//resultElement.textContent = 'QR Code Data: ' + code.data;
				clearInterval(interval);
				const codigo = code.data;
				const split = codigo.split('-');
				const cliente_id = split[0];
				const user_id = split[2];
				console.log('Simulando validación...', codigo, cliente_id, user_id);
				axios.get(`{{ route("my-app-client.producto-redencion-validar", ["producto" => $producto->id]) }}/${codigo}/${user_id}`)
				.then(function(response) {
					console.log(response.data);
					if (!response.data.status) {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: response.data.message,
							customClass: 'quiz-swal',
						});
						return;
					}
					Swal.fire({
						icon: 'success',
						title: 'Éxito',
						text: response.data.message,
						customClass: 'quiz-swal',
					});
				})
				.catch(function(error) {
					console.log(error);
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '{{ __('arcaddy.error-gral') }}',
						customClass: 'quiz-swal',
					});
				});
			}
		}, 3000);
	}
	/*FIN scanea*/
	video.addEventListener('canplay', function() {
		if (!scanning) {
			scanning = true;
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
			escanea();
		}
	});
	$('#alx-cerrar-scaner').on('click', function(){
		$('#alx-capa-scaner').removeClass('mostrar-info-scaner');
		$('#alx-info-scaner-ok').addClass('alx-info-scaner-ocultar');
		$('#alx-info-scaner-no').addClass('alx-info-scaner-ocultar');
		$('#alx-info-scaner-nombre').html('');
		escanea();
	});
});
</script>
@endsection
