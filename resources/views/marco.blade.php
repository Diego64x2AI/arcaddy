<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $cliente->cliente}} <?php  /*{{ config('app.name', 'Laravel') }}*/ ?></title>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.min.js"></script>
</head>

<body class="font-sans antialiased overflow-x-hidden">
	@includeIf('componentes.header')
	<div class="text-center px-5 py-5 text-3xl mt-5 font-extrabold lg:text-8xl">Crea tu foto y participa:</div>
	<main style="padding: 0 15px;" class="relative max-w-[500px] mx-auto pt-5 pb-20">
		<canvas id="c" width="400" height="400"></canvas>
		<button id="uploadButton" class="absolute top-1/2 left-1/2 btn-pill2 !py-4 !px-8 !text-sm uppercase -translate-x-[85px] -translate-y-[35px]">Selecciona<br>tu foto</button>
		<input type="file" id="upload" accept="image/*" style="display: none;" />
		<div id="info" style="display:none;"></div>
		<div id="buttonsContainer" style="display: none;" class="flex flex-row gap-5 mt-5 items-center justify-evenly">
			<div>
				<button id="selectAnother" class="btn-pill2 !py-4 !px-8 !text-sm uppercase">Seleccionar<br>otra imagen</button>
			</div>
			<div>
				<button id="finishEditing" class="btn-pill !py-4 !px-8 !text-2xl !font-bold uppercase">Descarga</button>
			</div>
		</div>
	</main>
	@includeIf('componentes.footer')
	<script>
		let canvas, frame, userImage, uploadButton;
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
			fabric.Image.fromURL('{{ asset("images/marco.png") }}', function(img) {
				frame = img;
				frame.set({
					selectable: false,
					evented: false,
				});
				frame.set("clipPath", roundedCorners(frame, 80))
				canvas.add(frame);
				canvas.sendToBack(frame);
				resizeCanvas();
			});

			window.addEventListener('resize', resizeCanvas);
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
					}
				}
				reader.readAsDataURL(e.target.files[0]);
			});
			document.getElementById('selectAnother').onclick = function() {
				document.getElementById('upload').click();
			};
			document.getElementById('finishEditing').onclick = async () => {
				canvas.discardActiveObject().renderAll();
				// Convertir el canvas de Fabric.js a data URL y luego a Blob
				var dataURL = canvas.toDataURL();
				// var blob = dataURLtoBlob(dataURL);
				const blob = await (await fetch(dataURL)).blob()
				console.log(blob)
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
			};
		});
	</script>
	@includeIf('componentes.estilos')
</body>

</html>
