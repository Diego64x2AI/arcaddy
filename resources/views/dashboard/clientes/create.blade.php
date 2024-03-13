<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ ($cliente->id !== NULL) ? 'Editar' : 'Agregar' }} cliente
		</h2>
	</x-slot>
	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white">
				@if ($errors->any())
				<div class="my-5">
					<div class="relative w-full p-4 text-white bg-yellow-400 rounded-lg">{{ $errors->first() }}</div>
				</div>
				@endif
				@if (session('success'))
					<div class="my-5">
						<div class="relative w-full p-4 text-white bg-lime-500 rounded-lg">{{ session('success') }}</div>
					</div>
					@endif
				<form action="{{ $cliente->id === NULL ? route('clientes.store') : route('clientes.update', ['cliente' => $cliente->id]) }}" name="cliente-form" method="POST" enctype="multipart/form-data">
					@csrf
					@if ($cliente->id !== NULL)
					@method('PUT')
					@endif
					<div class="p-6 bg-gray-100 border border-white">

					    @if($cliente->id !== NULL)
					    <div style="text-align: right;">
								    	<a href="{{ url("/{$cliente->slug}") }}" target="_blank"	>
								    	Ver sitio web
								    	 ar-caddy/<span class="font-bold">{{ $cliente->slug }}</span></a>
						</div>

								@endif

						<div style="display: none;">
						    <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
									Idioma
							</label>
							<select class="shadow appearance-none border-0 py-2 px-3 text-gray-700" style="width: 200px;" name="idioma">
							    @if($cliente->id !== NULL)
							    <option value="ES" {{($cliente->idioma == 'ES')?'selected':''}} >Español</option>
							    <option value="EN" {{($cliente->idioma == 'EN')?'selected':''}}>Inglés</option>
							    @else
							    <option value="ES">Español</option>
							    <option value="EN">Inglés</option>
							    @endif
							</select>
						</div>
						<br>
						<div class="grid grid-cols-1 md:grid-cols-7 items-center justify-around -mx-3">
							<div class="col-span-2 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
									ar-caddy.com/
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="slug" id="slug"
									type="text" value="{{ ($cliente->id !== NULL) ? $cliente->slug : old('slug') }}" placeholder="Ejemplo: redbull" required>


							</div>
							<div class="col-span-2 px-3 mb-6 md:mb-6">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
									Nombre cliente
								</label>
								<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="cliente" id="cliente"
									type="text" value="{{ ($cliente->id !== NULL) ? $cliente->cliente : old('cliente') }}" placeholder="Ejemplo: Red Bull" required>


							</div>
							<div class="px-3 mb-6 md:mb-6 text-center">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="color_bg">
									Fondo
								</label>
								<input name="color_bg" id="color_bg"
									value="{{ ($cliente->id !== NULL) ? $cliente->color_bg : old('color_bg') }}" type="color" placeholder="#FFFFFF" @if($cliente->id === NULL) required @endif>
							</div>
							<div class="px-3 mb-6 md:mb-6 text-center">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="color_base">
									Texto
								</label>
								<input name="color_base" id="color_base"
									value="{{ ($cliente->id !== NULL) ? $cliente->color_base : old('color_base') }}" type="color" placeholder="#000000" @if($cliente->id === NULL) required @endif>
							</div>
							<div class="px-3 mb-6 md:mb-6 text-center">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="color">
									Contraste
								</label>
								<input name="color" id="color"
									value="{{ ($cliente->id !== NULL) ? $cliente->color : old('color') }}" type="color" placeholder="#FF4E00" @if($cliente->id === NULL) required @endif>
							</div>
						</div>



						<div class="flex flex-wrap -mx-3">
							<div class="w-full md:w-3/6 px-3 mb-6 md:mb-6">
        						<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
        									Meta description
        						</label>
        						<textarea name="metadescription" style="width: 100%; height: 100px;" class="shadow appearance-none border-0">{{ ($cliente->id !== NULL) ? $cliente->metadescription : old('metadescription') }}</textarea>
        					</div>

						</div>
					    <br>







						<div class="flex flex-wrap -mx-3 justify-center">
							<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
							    <div>
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
									Logo cliente
								</label>
								<img src="{{ ($cliente->id !== NULL) ? asset('storage/'.$cliente->logo) : asset('images/1000x1000.png') }}"
														class="img-general object-cover w-100 border border-secondary">
								<div class="text-center mt-3">
									<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									<div class="examinar-size text-xs mt-2 text-gray-400">(1000x1000px)</div>
								</div>
								<input name="logo" id="logo" type="file" class="file-general" accept="image/*" style="display: none">
								</div>
							</div>
							@if($cliente->id !== NULL)
							<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
									QR cliente
								</label>
								<img src="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}"
														class="object-cover w-100 border border-secondary">
								<div class="text-center mt-3">
									<a role="button" href="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}" target="_blank" class="rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Descargar QR</a>
								</div>
							</div>
							@endif

							<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
							    <div>
								<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
									Background
								</label>
								<img src="{{ ($cliente->id !== NULL && $cliente->imagen_background != '') ? asset('storage/'.$cliente->imagen_background) : asset('images/1000x1000.png') }}"
														class="img-general object-cover w-100 border border-secondary">
								<div class="text-center mt-3">
									<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									<div class="examinar-size text-xs mt-2 text-gray-400"></div>
								</div>
								<input name="imagen_background" id="imagen_background" type="file" class="file-general" accept="image/*" style="display: none">
								</div>
							</div>
						</div>


						<div id="login_bloqueo_cont" class="bg-white p-3 mt-3">
							<div class="flex flex-row items-center font-bold">
								<div class="text-xl md:text-3xl truncate mr-2">
									Ver Arcaddy solo con login
								</div>
								<div class="ml-auto">
									<span class="mr-2">Activar / Desactivar </span>
									<input type="checkbox" id="login_bloqueo" name="login_bloqueo" value="on" @if($cliente->id !== NULL && $cliente->login_bloqueo) checked @endif>
								</div>
							</div>
						</div>
						<div id="btn_registro_en_login_cont" class="bg-white p-3 mt-3">
							<div class="flex flex-row items-center font-bold">
								<div class="text-xl md:text-3xl truncate mr-2">
									Ver botón registro en login
								</div>
								<div class="ml-auto">
									<span class="mr-2">Activar / Desactivar </span>
									<input type="checkbox" id="btn_registro_en_login" name="btn_registro_en_login" value="on" @if($cliente->id !== NULL && $cliente->btn_registro_en_login) checked @endif>
								</div>
							</div>
						</div>
						<div id="privado" class="bg-white p-3 mt-3">
							<div class="flex flex-row items-center font-bold">
								<div class="text-xl md:text-3xl truncate mr-2">Arcaddy privado</div>
							</div>
							<div id="privado-container" class="mt-5 section-box">
								<div class="flex flex-wrap items-center -mx-3">
									<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
										<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
											Título página
										</label>
										<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="password_titulo" id="password_titulo"
											type="text" value="{{ ($cliente->id !== NULL) ? $cliente->password_titulo : old('password_titulo') }}">
									</div>
									<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
										<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
											Descripción página
										</label>
										<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="password_descripcion" id="password_descripcion"
											type="text" value="{{ ($cliente->id !== NULL) ? $cliente->password_descripcion : old('password_descripcion') }}">
									</div>
									<div class="w-full md:w-1/3 px-3 mb-6 md:mb-6">
										<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
											Contraseña
										</label>
										<input class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700" name="password" id="password"
											type="text" value="{{ ($cliente->id !== NULL) ? $cliente->password : old('password') }}">
									</div>
								</div>
							</div>
						</div>
						<div id="geolocalizacion" class="bg-white p-3 mt-3">
							<div class="flex flex-row items-center font-bold">
								<div class="text-xl md:text-3xl truncate mr-2">Geobloqueo</div>
								<div class="ml-auto">
									<span class="inline-block mr-2">Auto</span>
									<input type="radio" name="geo_bloqueo" value="1" @if($cliente->id !== NULL && $cliente->geo_bloqueo === 1) checked @endif>
								</div>
								<div class="ml-2">
									<span class="inline-block mr-2">Manual</span>
									<input type="radio" name="geo_bloqueo" value="2" @if($cliente->id !== NULL && $cliente->geo_bloqueo === 2) checked @endif>
								</div>
								<div class="ml-2">
									<span class="inline-block mr-2">Desactivado</span>
									<input type="radio" name="geo_bloqueo" value="0" @if(($cliente->id !== NULL && $cliente->geo_bloqueo === 0) || $cliente->id === NULL ) checked @endif>
								</div>
							</div>
							<div id="privado-container" class="mt-5 section-box">
								<div class="flex flex-wrap items-center -mx-3">
									<div class="w-full px-3 mb-6 md:mb-6">
										<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
											Códigos postales aceptados:
										</label>
										<textarea class="shadow appearance-none resize-none h-20 border-0 w-full py-2 px-3 text-gray-700" name="geo_codes"
												type="text" placeholder="Códigos postales separados por coma">{{ ($cliente->id !== NULL) ? $cliente->geo_codes : old('geo_codes') }}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div id="registro" class="bg-white p-3 mt-3">
							<div class="flex flex-row items-center font-bold">
								<div class="text-xl md:text-3xl truncate mr-2">Registro</div>
								<div class="ml-auto"><span class="hidden md:inline-block mr-2">Activar / Desactivar </span><input type="checkbox" id="registro" name="registro" value="on" @if($cliente->id !== NULL && $cliente->registro) checked @endif></div>
							</div>
							<div id="registro-container" class="mt-5 section-box">
								<div class="flex flex-wrap -mx-3 justify-center">
									<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
										<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="registro_img">
											Imagen
										</label>
										<img src="{{ ($cliente->id !== NULL && $cliente->registro_img !== NULL) ? asset('storage/'.$cliente->registro_img) : asset('images/1000x1000.png') }}"
																class="img-general object-cover w-100 border border-secondary">
										<div class="text-center mt-3">
											<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
											<div class="examinar-size text-xs mt-2 text-gray-400">(1000x1000px)</div>
										</div>
										<input name="registro_img" id="registro_img" type="file" class="file-general" accept="image/*" style="display: none">
									</div>
									@if($cliente->id !== NULL)
									<div class="w-full md:w-1/6 px-3 mb-6 md:mb-6 text-center">
										<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="logo">
											QR cliente
										</label>
										<img src="{{ asset('storage/qrcodes/'.$cliente->slug.'_registro.png?'.time()) }}"
																class="object-cover w-100 border border-secondary">
										<div class="text-center mt-3">
											<a role="button" href="{{ asset('storage/qrcodes/'.$cliente->slug.'_registro.png?'.time()) }}" target="_blank" class="rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Descargar QR</a>
										</div>
									</div>
									@endif
									<div class="w-full md:w-2/6 px-3 mb-6 md:mb-6 text-center ml-auto">
										<div>
											<label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="registro_descripcion">
												Texto descriptivo:
											</label>
											<textarea class="shadow appearance-none resize-none h-20 border-0 w-full py-2 px-3 text-gray-700" name="registro_descripcion" id="registro_descripcion"
												type="text" placeholder="Texto descriptivo">{{ ($cliente->id !== NULL) ? $cliente->registro_descripcion : old('registro_descripcion') }}</textarea>
										</div>

										<?php /*<div class="flex items-center justify-end mt-2">
										    <div class="ml-2 grow text-right">
												<div class="font-bold">
												    Fecha nacimiento
												</div>
											</div>
											<div class="ml-2">
												<input type="checkbox" name="nacimiento" value="on">
											</div>
										</div> */?>

										@foreach ($campos as $campo)
											<div class="flex items-center justify-end mt-2">
												@if ($campo->editable)
													<div class="font-bold">{{ $campo->info }}</div>
													<div class="ml-2 grow">
														<input class="input-underline text-right" name="campos[{{ $campo->id }}]" value="{{ $cliente->campos->where('campo_id', $campo->id)->count() > 0 ? $cliente->campos->where('campo_id', $campo->id)->first()->nombre : $campo->nombre }}" placeholder="{{ $campo->nombre }}" type="text" required>
													</div>
												@else
													<div class="ml-2 grow text-right">
														<div class="font-bold">{{ $campo->nombre }}</div>
														<input name="campos[{{ $campo->id }}]" value="{{ $campo->nombre }}" placeholder="{{ $campo->nombre }}" type="hidden" required>
													</div>
												@endif
												<div class="ml-2">
													<input type="checkbox" name="campos_activo[{{ $campo->id }}]" value="on" @if($cliente->campos->where('campo_id', $campo->id)->count() > 0 && $cliente->campos->where('campo_id', $campo->id)->first()->activo) checked @endif>
												</div>
											</div>
										@endforeach
									</div>

								</div>
								<div class="font-semibold">
									Base de datos para permitir registros
								</div>
								<div class="flex flex-row">
									<div class="text-center mt-3">
										<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
										<div class="examinar-size text-xs mt-2 text-gray-400">(solamente .xlsx)</div>
									</div>
									<input name="registro_base" id="registro_base" type="file" accept=".xlsx" style="display: none">
								</div>
								@if ($cliente->registro_base)
								<div class="text-xs mt-2">
									Actualmente cuentas con una base de datos cargada: <a href="{{ route('clientes.registrodb.delete', ['cliente' => $cliente->id]) }}">Eliminar</a>
								</div>
								@endif
							</div>
						</div>
						<!-- /flotantes -->
						<div id="flotantes" class="bg-white p-3 mt-3">
							<div class="flex flex-row items-center font-bold">
								<div class="text-xl md:text-3xl truncate mr-5 grow">
									Flotantes
								</div>
							</div>
							<div id="flotantes-container" class="container-draggable mt-5 section-box">
								@if ($cliente->id !== NULL)
									@foreach ($cliente->flotantes as $flotante)
									<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
										<div class="p-3">
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													Icono:
												</label>
												<select class="input-underline" name="flotantes_icono[]">
													<option value="" @if($flotante->icono === '') selected @endif>Ninguno</option>
													<option value="fas fa-phone" @if($flotante->icono === 'fas fa-phone') selected @endif>Teléfono</option>
													<option value="fas fa-envelope" @if($flotante->icono === 'fas fa-envelope') selected @endif>Correo</option>
													<option value="fas fa-map-marker-alt" @if($flotante->icono === 'fas fa-map-marker-alt') selected @endif>Ubicación</option>
													<option value="fab fa-whatsapp" @if($flotante->icono === 'fab fa-whatsapp') selected @endif>Whatsapp</option>
													<option value="fab fa-facebook" @if($flotante->icono === 'fab fa-facebook') selected @endif>Facebook</option>
													<option value="fab fa-instagram" @if($flotante->icono === 'fab fa-instagram') selected @endif>Instagram</option>
													<option value="fab fa-twitter" @if($flotante->icono === 'fab fa-twitter') selected @endif>Twitter</option>
													<option value="fab fa-youtube" @if($flotante->icono === 'fab fa-youtube') selected @endif>Youtube</option>
												</select>
											</div>
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													Texto:
												</label>
												<input class="input-underline" name="flotantes_texto[]" value="{{ $flotante->texto }}" type="text">
											</div>
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													LINK:
												</label>
												<input class="input-underline" name="flotantes_link[]" value="{{ $flotante->link }}" type="url" required>
											</div>
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													Target:
												</label>
												<select class="input-underline" name="flotantes_target[]" required>
													<option value="_self" @if($flotante->target === '_self') selected @endif>Misma ventana</option>
													<option value="_blank" @if($flotante->target === '_blank') selected @endif>Nueva ventana</option>
												</select>
											</div>
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													Color de fondo:
												</label>
												<input name="flotantes_color[]" value="{{ $flotante->color }}" type="color" placeholder="#FFFFFF" required>
											</div>
											<div class="mb-2">
												<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
													Posición:
												</label>
												<select class="input-underline" name="flotantes_posicion[]" required>
													<option value="flotante-b-r" @if($flotante->posicion === 'flotante-b-r') selected @endif>Bottom right</option>
													<option value="flotante-b-l" @if($flotante->posicion === 'flotante-b-l') selected @endif>Bottom left</option>
													<option value="flotante-t-r" @if($flotante->posicion === 'flotante-t-r') selected @endif>Top right</option>
													<option value="flotante-t-l" @if($flotante->posicion === 'flotante-t-l') selected @endif>Top left</option>
												</select>
											</div>
											<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
												<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
															class="fas fa-trash-alt"></i></a></div>
											</div>
										</div>
									</div>
									@endforeach
								@endif
							</div>
							<div class="text-right mt-5">
								<a href="" id="add_flotante" class="btn-pill">+ Agregar</a>
							</div>
						</div>
						<!-- /flotantes -->
						<div id="secciones-container">
							@php
								$secciones = ($cliente->id !== NULL) ? $cliente->secciones()->select('seccion')->pluck('seccion')->toArray() : ['banners', 'descriptivos', 'colaboradores', 'patrocinadores', 'blog', 'galeria', 'playlist', 'experiencia', 'libres', 'live', 'social', 'productos', 'banners2', 'menu', 'ranking'];
							@endphp
							@foreach($secciones as $seccion)
								@includeIf('dashboard.clientes.secciones.'.$seccion)
							@endforeach
						</div>
					</div>
					<div class="fixed top-20 right-0">
						<button type="submit" class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white w-12 h-12"><i class="fa fa-save"></i></button>
					</div>
				</form>
				<form action="" method="POST" class="inline delete-form-producto">
					@csrf
					@method('DELETE')
				</form>
			</div>
		</div>
	</div>
	<!-- Main modal -->
	<div id="cropModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 hidden z-[5000px] w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
		<div class="absolute inset-0 bg-gray-500 opacity-75"></div>
		<div class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-full lg:max-w-6xl">
			<!-- Modal content -->
			<div class="relative bg-gray-50 rounded-lg p-4 shadow-lg">
				<!-- Modal header -->
				<div class="flex items-start justify-between py-3 border-b rounded-t">
					<h3 class="text-xl font-semibold text-gray-900">
						Cortar imagen
					</h3>
					<button id="closeCropModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="defaultModal">
						<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
						<span class="sr-only">Close modal</span>
					</button>
				</div>
				<!-- Modal body -->
				<div class="space-y-6 py-2 w-full h-[500px] overflow-auto">
					<div class="img-container py-4">
						<img id="image-crop" src="" alt="Picture" class="w-full h-auto">
					</div>
				</div>
				<!-- Modal footer -->
				<div class="flex items-center py-3 space-x-2 border-t border-gray-200 rounded-b">
					<button onclick="saveCropImage();" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
						Guardar cambios
					</button>
				</div>
			</div>
		</div>
	</div>
	@section('js')
	<script src="{{ asset('assets/editor/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
	<script>
		let cropper;
		let cropTipo, cropId;
		function saveCropImage () {
			cropper.getCroppedCanvas().toBlob((blob) => {
				var reader = new FileReader();
        reader.readAsDataURL(blob);
				reader.onloadend = function() {
					var base64data = reader.result;
					console.log(`${cropTipo}-${cropId}`)
					$(`#${cropTipo}-${cropId}`).attr('src', `${base64data}`);
					const formData = new FormData();
					formData.append('croppedImage', blob);
					formData.append('tipo', cropTipo);
					formData.append('id', cropId);
					axios.post('{{ route("clientes.crop") }}', formData, {
						headers: {
							'Content-Type': 'multipart/form-data'
						}
					}).then((response) => {
						console.log(response);
						$('#closeCropModal').trigger('click');
						Swal.fire({
							icon: response.data.status ? 'success' : 'error',
							title: response.data.message,
							showConfirmButton: false,
							timer: 1500
						});
					});
				}
			});
		}
		window.addEventListener('load', function() {
				$('body').on('click', 'a.crop-image', function (e) {
					e.preventDefault();
					const image = $(this).data('image');
					const width = $(this).data('width');
					const height = $(this).data('height');
					cropTipo = $(this).data('tipo');
					cropId = $(this).data('id');
					console.log('crop', image, width, height);
					$('#image-crop').attr('src', image);
					if ($('#cropModal').hasClass('hidden')) {
						$('#cropModal').removeClass('hidden').addClass('flex');
						// $('.img-container').css('width', width).css('height', height);
						cropper = new Cropper(document.getElementById('image-crop'), {
							dragMode: 'move',
							aspectRatio: width / height,
							autoCropArea: 1,
							// minCropBoxWidth: width,
							// minCropBoxHeight: height,
							restore: false,
							guides: false,
							center: false,
							highlight: false,
							cropBoxMovable: false,
							cropBoxResizable: false,
							toggleDragModeOnDblclick: false,
							zoomable: true,
							rotatable: true,
							responsive: true,
						});
					} else {
						$('#cropModal').removeClass('flex').addClass('hidden');
						cropper.destroy();
					}
				});
				$('body').on('click', 'button#closeCropModal', function (e) {
					e.preventDefault();
					$('#cropModal').removeClass('flex').addClass('hidden');
					cropper.destroy();
				});
				$('body').on('click', 'button.examinar-btn', function (e) {
					e.preventDefault();
					console.log('click')
					$(this).parent().parent().find('input[type=file]').trigger('click');
				});
				new Sortable(document.getElementById('banners-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('colaboradores-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('patrocinadores-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('blog-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('galeria-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('playlist-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('experiencia-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('libres-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('marco-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'horizontal',
				});
				new Sortable(document.getElementById('secciones-container'), {
					handle: '.handler2', // handle's class
					animation: 150,
					direction: 'vertical',
				});
				new Sortable(document.getElementById('menu-container'), {
					handle: '.handler', // handle's class
					animation: 150,
					direction: 'vertical',
				});
				if (document.querySelector('#menu-container #menu-items') !== null) {
					new Sortable(document.querySelector('#menu-container #menu-items'), {
						handle: '.handler2', // handle's class
						animation: 150,
						direction: 'horizontal',
					});
				}
				$('body').on('change', '.file-general', function () {
					const $esto = $(this);
					if (this.files && this.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$esto.parent().parent().find('img.img-general').attr('src', e.target.result);
						}
						reader.readAsDataURL(this.files[0]);
					}
				});
				// agregar categorías cartelera
				$('a#add_cartelera_cat').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-full float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div>
								<input class="input-underline" name="cartelera_cat_nombre[]" type="text" placeholder="Nombre de la categoría" required>
							</div>
							<div id="cartelera-items" class="flex flex-col">
							</div>
							<div class="text-center mt-2">
								<a href="javascript:void(0);" class="btn-pill3 add_cartelera_item">+ Item</a>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#cartelera-container').append(html);
				});
				// agregar item cartelera
				$('body').on('click', '.add_cartelera_item', function(e) {
					e.preventDefault();
					const index = $(this).parent().parent().parent().index();
					const html = `<div class="bg-white item-container mt-2 p-2 flex flex-row h-16 overflow-hidden">
						<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="ml-4 w-1/5">
							<div class="relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img2 absolute top-0 left-0 w-full h-full hidden flex-row items-center justify-center group-hover:flex">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white text-xs px-2 py-1 inline-block">Examinar...</button>
									</div>
									<input type="hidden" name="cartelera_item_old[${index}][]" value="" />
									<input type="file" name="cartelera_item_img[${index}][]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
						</div>
						<div class="ml-2 grow grid grid-cols-2 gap-2">
							<div>
								<input class="input-underline" name="cartelera_item_titulo[${index}][]" type="text" placeholder="Título" required>
							</div>
							<div>
								<input class="input-underline" name="cartelera_item_expositor[${index}][]" type="text" placeholder="Expositor">
							</div>
							<div>
								<input class="input-underline" name="cartelera_item_hora[${index}][]" type="text" placeholder="Hora">
							</div>
							<div>
								<input class="input-underline" name="cartelera_item_fecha[${index}][]" type="date" placeholder="Fecha">
							</div>
							<div>
								<input class="input-underline" name="cartelera_item_lugar[${index}][]" type="text" placeholder="Lugar / Escenario">
							</div>
							<div>
								<input name="cartelera_item_inter[${index}][]" type="checkbox" value="on"> break
							</div>
							<div class="mb-2 col-span-2">
								<textarea class="input-border" name="cartelera_item_descripcion[${index}][]" rows="2" placeholder="Descripción"></textarea>
							</div>
						</div>
						<div class="ml-4">
							<div class="delete-item">
								<a href="javascript:void(0);" class="text-dark"><i class="fas fa-trash-alt"></i></a>
							</div>
							<div class="expand-item">
								<a href="javascript:void(0);" class="text-dark"><i class="fas fa-chevron-down"></i></a>
							</div>
						</div>
					</div>`;
					$(this).parent().parent().find('#cartelera-items').append(html);
					new Sortable(document.querySelector('#cartelera-container #cartelera-items'), {
						handle: '.handler2', // handle's class
						animation: 150,
						direction: 'horizontal',
					});
				});
				// agregar categorías menu
				$('a#add_menu_cat').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-full float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div>
								<input class="input-underline" name="menu_cat_nombre[]" type="text" placeholder="Nombre de la categoría" required>
							</div>
							<div id="menu-items" class="flex flex-col">
							</div>
							<div class="text-center mt-2">
								<a href="" class="btn-pill3 add_menu_item">+ Item</a>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#menu-container').append(html);
				});
				// agregar item menu
				$('body').on('click', '.add_menu_item', function(e) {
					e.preventDefault();
					const index = $(this).parent().parent().parent().index();
					const html = `<div class="bg-white item-container mt-2 p-2 flex flex-row h-16 overflow-hidden">
						<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="ml-4 w-1/5">
							<div class="relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img2 absolute top-0 left-0 w-full h-full hidden flex-row items-center justify-center group-hover:flex">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white text-xs px-2 py-1 inline-block">Examinar...</button>
									</div>
									<input type="hidden" name="menu_item_old[${index}][]" value="" />
									<input type="file" name="menu_item_img[${index}][]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
						</div>
						<div class="ml-2 grow grid grid-cols-2 gap-2">
							<div>
								<input class="input-underline" name="menu_item_nombre[${index}][]" type="text" placeholder="Nombre" required>
							</div>
							<div>
								<input class="input-underline" name="menu_item_cantidad[${index}][]" type="text" placeholder="Cantidad (gr, ml, unidades)">
							</div>
							<div>
								<input class="input-underline" name="menu_item_precio[${index}][]" type="text" placeholder="Precio">
							</div>
							<div>
								<input class="input-underline" name="menu_item_boton_titulo[${index}][]" type="text" placeholder="Título botón">
							</div>
							<div>
								<input class="input-underline" name="menu_item_boton_link[${index}][]" type="url" placeholder="Link">
							</div>
							<div>
								<input class="input-underline" name="menu_item_canje_texto[${index}][]" type="text" placeholder="Etiqueta">
							</div>
							<div class="mb-2 col-span-2">
								<textarea class="input-border" name="menu_item_descripcion[${index}][]" rows="2" placeholder="Descripción"></textarea>
							</div>
						</div>
						<div class="ml-4">
							<div class="delete-item">
								<a href="javascript:void(0);" class="text-dark"><i class="fas fa-trash-alt"></i></a>
							</div>
							<div class="expand-item">
								<a href="javascript:void(0);" class="text-dark"><i class="fas fa-chevron-down"></i></a>
							</div>
						</div>
					</div>`;
					$(this).parent().parent().find('#menu-items').append(html);
					new Sortable(document.querySelector('#menu-container #menu-items'), {
						handle: '.handler2', // handle's class
						animation: 150,
						direction: 'horizontal',
					});
				});
				// agregar banner
				$('a#add_banner').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="banners_old[]" value="" />
									<input type="file" name="banners_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input class="input-underline" name="banners_titulo[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									LINK:
								</label>
								<input class="input-underline" name="banners_link[]" type="url">
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#banners-container').append(html);
				});
				// agregar marco
				$('a#add_marco').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="https://placehold.co/400x400/FFFFFF/acacac/png?text=Cargar%20imagen"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="marco_id[]" value="0" />
									<input type="hidden" name="marco_old[]" value="" />
									<input type="file" name="marco_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título:
								</label>
								<input class="input-underline" name="marco_titulo[]" type="text">
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#marco-container').append(html);
				});
				// agregar banner 2
				$('a#add_banner2').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="banners2_old[]" value="" />
									<input type="file" name="banners2_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input class="input-underline" name="banners2_titulo[]" type="text" >
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									LINK:
								</label>
								<input class="input-underline" name="banners2_link[]" type="url">
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#banners2-container').append(html);
				});
				// agregar flotante
				$('a#add_flotante').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Icono:
								</label>
								<select class="input-underline" name="flotantes_icono[]">
									<option value="">Ninguno</option>
									<option value="fas fa-phone">Teléfono</option>
									<option value="fas fa-envelope">Correo</option>
									<option value="fas fa-map-marker-alt">Ubicación</option>
									<option value="fab fa-whatsapp">Whatsapp</option>
									<option value="fab fa-facebook">Facebook</option>
									<option value="fab fa-instagram">Instagram</option>
									<option value="fab fa-twitter">Twitter</option>
									<option value="fab fa-youtube">Youtube</option>
								</select>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Texto:
								</label>
								<input class="input-underline" name="flotantes_texto[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									LINK:
								</label>
								<input class="input-underline" name="flotantes_link[]" type="url" required>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Target:
								</label>
								<select class="input-underline" name="flotantes_target[]" required>
									<option value="_self">Misma ventana</option>
									<option value="_blank">Nueva ventana</option>
								</select>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Texto:
								</label>
								<input name="flotantes_color[]" value="#000000" type="color" placeholder="#FFFFFF" required>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Posición:
								</label>
								<select class="input-underline" name="flotantes_posicion[]" required>
									<option value="flotante-b-r">Bottom right</option>
									<option value="flotante-b-l">Bottom left</option>
									<option value="flotante-t-r">Top right</option>
									<option value="flotante-t-l">Top left</option>
								</select>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#flotantes-container').append(html);
				});
				// agregar colaborador
				$('a#add_artista').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/artista.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="colaboradores_old[]" value="" />
									<input type="file" name="colaboradores_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Nombre:
								</label>
								<input
									class="input-underline"
									name="colaboradores_titulo[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Talento / Título / Participación:
								</label>
								<input
									class="input-underline"
									name="colaboradores_talento[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Descripción:
								</label>
								<textarea class="input-border" name="colaboradores_descripcion[]"
									rows="5"></textarea>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#colaboradores-container').append(html);
				});
				// agregar patrocinador
				$('a#add_patrocinador').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/patrocinador.png') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="patrocinadores_old[]" value="" />
									<input type="file" name="patrocinadores_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input class="input-underline" name="patrocinadores_titulo[]" type="text" >
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									LINK:
								</label>
								<input class="input-underline" name="patrocinadores_link[]" type="text" required>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#patrocinadores-container').append(html);
				});
				// agregar blog
				$('a#add_blog').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/blog.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="blog_old[]" value="" />
									<input type="file" name="blog_img[]" class="file-general" accept="image/*" style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título:
								</label>
								<input class="input-underline" name="blog_titulo[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Link externo:
								</label>
								<input class="input-underline" name="blog_link[]" type="url">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Descripción:
								</label>
								<textarea class="input-border" name="blog_descripcion[]" rows="5"></textarea>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#blog-container').append(html);
				});
				// agregar galeria
				$('a#add_galeria').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/galeria-1.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="galeria_old[]" value="" />
									<input type="file" name="galeria_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input
									class="input-underline"
									name="galeria_titulo[]" type="text" >
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#galeria-container').append(html);
				});
				// agregar playlist
				$('a#add_playlist').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/spotify.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="playlist_old[]" value="" />
									<input type="file" name="playlist_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Plataforma:
								</label>
								<input
									class="input-underline"
									name="playlist_plataforma[]" type="text">
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Link:
								</label>
								<input
									class="input-underline"
									name="playlist_link[]" type="url">
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#playlist-container').append(html);
				});
				// agregar experiencia
				$('a#add_experiencia').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/experiencia.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="experiencia_old[]" value="" />
									<input type="file" name="experiencia_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título:
								</label>
								<input
									class="input-underline"
									name="experiencia_titulo[]" type="text">
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Link:
								</label>
								<input
									class="input-underline"
									name="experiencia_link[]" type="url">
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Texto botón:
								</label>
								<input
									class="input-underline"
									name="experiencia_btn[]" type="text">
							</div>
							<div class="mb-4">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Instrucciones:
								</label>
								<textarea class="input-border" name="experiencia_instrucciones[]"
									rows="5"></textarea>
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#experiencia-container').append(html);
				});
				// agregar libres
				$('a#add_libres').on('click', function (e) {
					e.preventDefault();
					const html = `<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
						<div class="p-3">
							<div class="mb-2 relative">
								<img src="{{ asset('images/banner.jpg') }}"
									class="img-general object-cover w-100 border border-secondary">
								<div class="examinar-img group-hover:block">
									<div><button type="button"
											class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
									</div>
									<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
									<input type="hidden" name="libres_old[]" value="" />
									<input type="file" name="libres_img[]" class="file-general" accept="image/*"
										style="display:none" />
								</div>
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									Título SEO:
								</label>
								<input class="input-underline" name="libres_titulo[]" type="text" >
							</div>
							<div class="mb-2">
								<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
									LINK:
								</label>
								<input class="input-underline" name="libres_link[]" type="url">
							</div>
							<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
								<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
								<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
											class="fas fa-trash-alt"></i></a></div>
							</div>
						</div>
					</div>`;
					$('#libres-container').append(html);
				});
				// eliminar bloques
				$('body').on('click', 'div.delete-fotometria a', function (e) {
					e.preventDefault();
					const esto = $(this);
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Este cambio se puede deshacer si actualizas la página sin guardar, en el momento que guardes tus cambios ya no podrás recuperar nada.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, eliminar',
						cancelButtonText: 'NO, cancelar'
					}).then((result) => {
						if (result.isConfirmed) {
							esto.parent().parent().parent().remove();
							// recordatorio();
							Swal.fire('Eliminado', 'Recuerda guardar tus cambios para que tengan efecto.', 'success')
						}
					})
				});
				// eliminar items
				$('body').on('click', 'div.delete-item a', function (e) {
					e.preventDefault();
					const esto = $(this);
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Este cambio se puede deshacer si actualizas la página sin guardar, en el momento que guardes tus cambios ya no podrás recuperar nada.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, eliminar',
						cancelButtonText: 'NO, cancelar'
					}).then((result) => {
						if (result.isConfirmed) {
							esto.parent().parent().parent().remove();
							// recordatorio();
							Swal.fire('Eliminado', 'Recuerda guardar tus cambios para que tengan efecto.', 'success')
						}
					})
				});
				// expand items
				$('body').on('click', 'div.expand-item a', function (e) {
					e.preventDefault();
					const esto = $(this);
					console.log(esto.parent().parent().parent())
					if (esto.parent().parent().parent().height() > 100) {
						esto.parent().parent().parent().css('height', '64px');
						return;
					} else {
						esto.parent().parent().parent().css('height', 'auto');
						return;
					}
				});
				$('a.delete-form-producto').on('click', function(e) {
					e.preventDefault();
					const $action = $(this).attr('href');
					const $form = $('form.delete-form-producto');
					Swal.fire({
						title: '¿Estás seguro?',
						text: "Una ves que elimines el producto no podrás recuperar la información.",
						icon: null,
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'SI, eliminarlo',
						cancelButtonText: 'Cancelar',
						allowOutsideClick: false,
					}).then((result) => {
						if (result.isConfirmed) {
							$form.attr('action', $action).submit();
						}
					})
				});
			});
	</script>
	<script type="text/javascript">
        tinymce.init({
          selector: 'textarea.alx-editor',
          plugins: 'link code lists',
          toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code'
        });
    </script>
	@endsection
</x-app-layout>
