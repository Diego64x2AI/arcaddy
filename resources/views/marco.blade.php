@php
	$rlogin = (bool) $cliente->secciones()->where('seccion', 'galeriamarcos')->first()?->login;
@endphp
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
	{!! htmlScriptTagJsApi([
		'action' => 'marco',
		'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
		'custom_validation' => 'myCustomValidation'
		]) !!}
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js"></script>
</head>

<body class="font-sans antialiased overflow-x-hidden">
	@includeIf('componentes.header')
	@if ($cliente->secciones()->where('seccion', 'marco')->first()->mostrar_titulo)
	<div class="titulo-modulo">{{ $cliente->secciones()->where('seccion', 'marco')->first()->titulo }}</div>
	@endif
	<main style="padding: 0 15px;" class="relative max-w-[500px] mx-auto pt-5 pb-20">
		<div id="buttonsContainer" style="display: none;" class="flex flex-row gap-5 mb-5 items-center justify-evenly">
			<div>
				<button id="finishEditing" class="btn-pill2 !py-2 !px-4 !font-semibold !text-sm uppercase">
					<div class="flex flex-row items-center">
						<div class="mr-3"><i class="fa fa-share-alt text-2xl"></i></div>
						<div>{{ __('arcaddy.marco1') }}</div>
					</div>
					</button>
			</div>
			<div>
				<button id="uploadBtn" class="btn-pill !py-2 !px-4 !font-semibold !text-sm uppercase">
					<div class="flex flex-row items-center">
						<div class="mr-3"><i class="fa fa-user-circle text-2xl"></i></div>
						<div>{{ __('arcaddy.marco2') }}</div>
					</div>
				</button>
			</div>
		</div>
		<div class="relative bg-white overflow-hidden">
			<canvas id="c" width="400" height="400"></canvas>
			<button id="uploadButton" class="absolute top-1/2 left-1/2 btn-pill2 !py-4 !px-8 !text-sm uppercase -translate-x-[85px] -translate-y-[35px]">Selecciona<br>tu foto</button>
			<div id="anotherBtn" style="display: none;" class="absolute left-3 bottom-3">
				<button id="selectAnother" class="btn-pill2 !py-2 !px-8 !text-sm uppercase">{{ __('arcaddy.marco3') }}<br>{{ __('arcaddy.marco4') }}</button>
			</div>
		</div>
		<input type="file" id="upload" accept="image/*" style="display: none;" />
		<div id="info" style="display:none;"></div>
		@if($cliente->marco->count() > 1)
		<div class="font-bold mt-3 text-center text-xl">{{ __('arcaddy.marco5') }}</div>
		<div class="flex flex-row items-center justify-evenly md:justify-center gap-5 mt-3">
			@foreach ($cliente->marco as $marco)
				<div>
					<div class="bg-white">
						<a href="javascript:void(0);" class="change-marco"><img src="{{ asset('storage/'.$marco->archivo) }}" alt="{{ $marco->titulo }}" class="w-full h-auto object-cover"></a>
					</div>
					<div class="text-center mt-1">
						{{ $marco->titulo }}
					</div>
				</div>
			@endforeach
		</div>
		@endif
	</main>
	@includeIf('componentes.footer')
	<script>
		let canvas, frame, userImage, uploadButton, bg_img, captcha;
		const rlogin = {{ $rlogin ? 'true' : 'false' }};
		function resizeCanvas() {
			var maxWidth = 500; // Máximo ancho para escritorio
			var width = window.innerWidth > maxWidth ? maxWidth : window.innerWidth;
			console.log(width, window.innerWidth, maxWidth);
			width -= 30;
			canvas.setWidth(width);
			canvas.setHeight(width);
			if (frame) {
				var scaleFactor = width / frame.width;
				console.log(scaleFactor, frame.width, frame.height)
				frame.scale(scaleFactor).setCoords();
				canvas.renderAll();
			}
		}
		function callbackThen(response){
			// read HTTP status
				console.log(response.status);

				// read Promise object
				response.json().then(function(data){
						console.log(data);
				});
		}
		function callbackCatch(error){
				console.error('Error:', error)
		}
		const myCustomValidation = (response) => {
			console.log(response);
			captcha = response;
		}
		const uploadImage = async (compartir) => {
			canvas.discardActiveObject().renderAll();
			// Convertir el canvas de Fabric.js a data URL y luego a Blob
			var dataURL = canvas.toDataURL();
			// var blob = dataURLtoBlob(dataURL);
			const blob = await (await fetch(dataURL)).blob()
			// console.log(blob)
			var formData = new FormData();
			formData.append('imagen', blob);
			formData.append('compartir', compartir);
			formData.append('token', captcha);
			$.ajax({
				url: '{{ route('cliente.marco.store', ['slug' => $cliente->slug]) }}',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					console.log(response);
					if (!compartir) {
						Swal.fire({
							title: response.status ? '{{ __('arcaddy.marco6') }}' : 'ERROR',
							text: response.message,
							icon: response.status ? 'success' : 'error',
							showConfirmButton: false,
							timer: 2500
						});
					}
				},
				error: function(xhr, status, error) {
					if (!compartir) {
						Swal.fire({
							title: '¡Error!',
							text: '{{ __('arcaddy.marco7') }}',
							icon: 'error',
							showConfirmButton: false,
							timer: 2500
						});
					}
				}
			});
		}
		window.addEventListener('load', function() {
			uploadButton = document.getElementById('uploadButton');
			let info = document.getElementById('info');
			const roundedCorners = (fabricObject, cornerRadius) => new fabric.Rect({
				width: fabricObject.width,
				height: fabricObject.height,
				rx: cornerRadius / fabricObject.scaleX,
				ry: cornerRadius / fabricObject.scaleY,
				left: -fabricObject.width / 2,
				top: -fabricObject.height / 2
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').css('paddingTop', $('#header').innerHeight())
			canvas = new fabric.Canvas('c', {
				preserveObjectStacking: true
			});
			/*
			canvas.on({
				'touch:gesture': function() {
					var text = document.createTextNode(' Gesture ');
					info.insertBefore(text, info.firstChild);
				},
				'touch:drag': function() {
					var text = document.createTextNode(' Dragging ');
					info.insertBefore(text, info.firstChild);
				},
				'touch:orientation': function() {
					var text = document.createTextNode(' Orientation ');
					info.insertBefore(text, info.firstChild);
				},
				'touch:shake': function() {
					var text = document.createTextNode(' Shaking ');
					info.insertBefore(text, info.firstChild);
				},
				'touch:longpress': function() {
					var text = document.createTextNode(' Longpress ');
					info.insertBefore(text, info.firstChild);
				}
			});
			*/
			bg_img = new fabric.Image();
			bg_img.setSrc('{{ asset('storage/'.$cliente->marco[0]->archivo) }}', function(img) {
				frame = img;
				frame.set({
					selectable: false,
					evented: false,
				});
				canvas.add(frame);
				canvas.sendToBack(frame);
				resizeCanvas();
			});
			console.log(bg_img);
			window.addEventListener('resize', resizeCanvas);
			$('body').on('click', '.change-marco', function(e){
				e.preventDefault();
				var src = $(this).find('img').attr('src');
				console.log(bg_img, src);
				bg_img.setSrc(src, function(img) {
					canvas.renderAll()
					resizeCanvas();
				});
				/*
				fabric.Image.fromURL(src, function(img) {
					canvas.remove(frame);
					frame = img;
					frame.set({
						selectable: false,
						evented: false,
					});
					canvas.add(frame);
					canvas.sendToBack(frame);
					resizeCanvas();
				});
				*/
			});
			uploadButton.onclick = function() {
				document.getElementById('upload').click();
			};
			document.getElementById('upload').addEventListener('change', function(e) {
				if (userImage) {
					canvas.remove(userImage); // Elimina la imagen anterior
				}
				// eliminar el boton de subir imagen
				uploadButton.style.display = 'none';
				var reader = new FileReader();
				reader.onload = function(event) {
					var imgObj = new Image();
					imgObj.src = event.target.result;
					imgObj.onload = function() {
						userImage = new fabric.Image(imgObj);
						userImage.scaleToHeight(canvas.height * 0.9); // Ajusta según la proporción deseada
						canvas.add(userImage);
						canvas.sendToBack(userImage);
						document.getElementById('buttonsContainer').style.display = 'flex';
						document.getElementById('anotherBtn').style.display = 'block';
					}
				}
				reader.readAsDataURL(e.target.files[0]);
			});
			document.getElementById('selectAnother').onclick = function() {
				document.getElementById('upload').click();
			};
			document.getElementById('uploadBtn').onclick = function() {
				// if the login is required
				if (rlogin) {
					// show dialog to confirm
					Swal.fire({
						title: '{{ __('arcaddy.modal-nologin-title') }}',
						html: `
							<div class="text-center color2">
								{{ __('arcaddy.modal-nologin-text') }}
							</div>
						`,
						icon: null,
						showCloseButton: false,
						showCancelButton: true,
						confirmButtonText: '{{ __('Register') }}',
						cancelButtonText: '{{ __('arcaddy.cancel') }}',
					}).then(async (result) => {
						if (result.isConfirmed) {
							window.location.href = '{{ route('register', ['cliente' => $cliente->id]) }}';
						}
					});
					return;
				}
				// show dialog to confirm
				Swal.fire({
					title: '{{ __('arcaddy.marco2') }}',
					html: `
						<div class="text-center color2">
							{{ __('arcaddy.marco8') }}
						</div>
						<div class="text-center mt-3 color2">
							<ul class="list-decimal text-center">
								<li>{{ __('arcaddy.marco9') }}</li>
								<li>{{ __('arcaddy.marco10') }}</li>
								<li>{{ __('arcaddy.marco11') }}</li>
							</ul>
						</div>
					`,
					icon: null,
					showCloseButton: false,
					showCancelButton: true,
					confirmButtonText: '{{ __('arcaddy.marco12') }}',
					cancelButtonText: '{{ __('arcaddy.cancel') }}'
				}).then(async (result) => {
					if (result.isConfirmed) {
						uploadImage(0);
					}
				});
			};
			document.getElementById('finishEditing').onclick = async () => {
				canvas.discardActiveObject().renderAll();
				// Convertir el canvas de Fabric.js a data URL y luego a Blob
				var dataURL = canvas.toDataURL();
				// var blob = dataURLtoBlob(dataURL);
				const blob = await (await fetch(dataURL)).blob()
				// console.log(blob)
				if (navigator.share) {
					const filesArray = [
						new File(
							[blob],
							'animation.png',
							{
								type: blob.type,
								lastModified: new Date().getTime()
							}
						)
					];
					const shareData = {
						files: filesArray,
					};
					navigator.share(shareData);
				} else {
					var link = document.createElement('a');
					link.download = 'imagen_final.png';
					link.href = URL.createObjectURL(blob);
					document.body.appendChild(link); // Necesario para Firefox
					link.click();
					document.body.removeChild(link);
				}
				uploadImage(1);
			};
		});
	</script>
	@includeIf('componentes.estilos')
</body>

</html>
