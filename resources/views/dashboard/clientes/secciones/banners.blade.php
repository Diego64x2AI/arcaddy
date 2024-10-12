<div id="banners" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="banners">
	<div class="flex flex-row flex-wrap items-center justify-evenly font-bold gap-3 md:gap-5">
		<div class="text-xl lg:text-3xl basis-full lg:basis-0 lg:grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[banners]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'banners')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'banners')->first()->titulo : 'Banners Home' }}">
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="banners-activo2">Título</label></div>
			<div><input type="checkbox" id="banners-activo2" name="banners-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'banners')->first()->mostrar_titulo) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="banners-activo">Activo</label></div>
			<div><input type="checkbox" id="banners-activo" name="banners-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'banners')->first()->activa) checked @endif></div>
		</div>
		<div class="flex flex-col gap-1 items-center">
			<div class="text-sm lg:text-base"><label for="banners-timer">Timer</label></div>
			<div><input type="number" min="0" id="banners-timer" class="!text-center w-24 !text-xs !px-2 !py-1" name="banners-timer" value="{{ $cliente->secciones()->where('seccion', 'banners')->first()->timer }}" required></div>
		</div>
		<div class="flex flex-col gap-1 items-center cursor-move handler2">
			<div class="text-sm lg:text-base">Mover</div>
			<div><i class="fas fa-ellipsis-v"></i></div>
		</div>
	</div>
	<div id="banners-container" class="container-draggable mt-5 section-box">
		@if ($cliente->id !== NULL)
			@foreach ($cliente->banners as $key => $banner)
			<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
				<div class="p-3">
					<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
						<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="grow text-center text-sm">
							Activo: <input type="checkbox" name="banners_activo[{{ $key }}]" value="on" @if($banner->activo) checked @endif>
						</div>
						<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
									class="fas fa-trash-alt"></i></a></div>
					</div>
					<div class="mb-2 relative">
						<div class="w-full pb-[56.25%] h-0 relative">
							@if (pathinfo($banner->archivo, PATHINFO_EXTENSION) == 'mp4')
							<video id="banners-{{ $banner->id }}" class="img-general absolute object-cover w-full h-full border border-secondary" controls>
								<source src="{{ asset('storage/'.$banner->archivo) }}" type="video/mp4">
								Your browser does not support the video tag.
							</video>
							@else
							<img id="banners-{{ $banner->id }}" src="{{ asset('storage/'.$banner->archivo) }}" class="img-general absolute object-cover w-full h-full border border-secondary">
							@endif
						</div>
						<div class="examinar-img group-hover:block">
							<div>
								<button type="button" class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">
									Examinar...
								</button>
							</div>
							<div class="mt-2 text-center text-xs">
								<a href="javascript:void(0);" class="text-dark crop-image" data-id="{{ $banner->id }}" data-tipo="banners" data-image="{{ asset('storage/'.$banner->archivo) }}" data-width="1903" data-height="1008">
									<i class="fas fa-crop"></i> Recortar
								</a>
							</div>
							<input type="hidden" name="banners_old[{{ $key }}]" value="{{$banner->archivo}}" />
							<input type="file" name="banners_img[{{ $key }}]" class="file-general" accept="image/*,.mp4" style="display:none" />
						</div>
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							Título SEO:
						</label>
						<input class="input-underline" name="banners_titulo[{{ $key }}]" value="{{ $banner->titulo }}" type="text" >
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							LINK:
						</label>
						<input class="input-underline" name="banners_link[{{ $key }}]" value="{{ $banner->link }}" type="url">
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							SUCURSALES:
						</label>
						<div class="!h-20">
							<select class="js-example-basic-multiple input-underline" name="banners_sucursales[{{ $key }}][]" multiple>
								@foreach ($cliente->sucursales as $sucursal)
								<option value="{{ $sucursal->id }}" @selected(in_array($sucursal->id, $banner->sucursales->pluck('sucursal_id')->toArray()))>{{ $sucursal->nombre }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		@else
		<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
			<div class="p-3">
				<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
					<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
					<div class="grow text-center text-sm">
						Activo: <input type="checkbox" name="banners_activo[0]" value="on" checked>
					</div>
					<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
								class="fas fa-trash-alt"></i></a></div>
				</div>
				<div class="mb-2 relative">
					<div class="w-full pb-[56.25%] h-0 relative">
						<img src="{{ asset('images/banner.jpg') }}"
							class="img-general absolute object-cover w-full h-full border border-secondary">
						<div class="examinar-img group-hover:block">
							<div><button type="button"
									class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
							</div>
							<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
							<input type="hidden" name="banners_old[0]" value="" />
							<input type="file" name="banners_img[0]" class="file-general" accept="image/*" style="display:none" />
						</div>
					</div>
				</div>
				<div class="mb-2">
					<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
						Título SEO:
					</label>
					<input class="input-underline" name="banners_titulo[0]" type="text" >
				</div>
				<div class="mb-2">
					<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
						LINK:
					</label>
					<input class="input-underline" name="banners_link[0]" type="url">
				</div>
				<div class="mb-2">
					<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
						SUCURSALES:
					</label>
					<div class="!h-20">
						<select class="js-example-basic-multiple input-underline" name="banners_sucursales[0][]" multiple>
							@foreach ($cliente->sucursales as $sucursal)
							<option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="text-right mt-5">
		<a href="" id="add_banner" class="btn-pill">+ Agregar</a>
	</div>
</div>
<!-- /banners -->
