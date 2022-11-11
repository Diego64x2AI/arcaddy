<div id="patrocinadores" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="patrocinadores">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-1">Patrocinadores:</div>
		<div class="ml-auto"><span class="hidden md:inline-block">Activar / Desactivar </span><input type="checkbox" name="patrocinadores-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'patrocinadores')->first()->activa) checked @endif></div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div id="patrocinadores-container" class="container-draggable mt-5 section-box">
		@if ($cliente->id !== NULL)
			@foreach ($cliente->patrocinadores as $patrocinador)
			<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
				<div class="p-3">
					<div class="mb-2 relative">
						<img src="{{ asset('storage/'.$patrocinador->archivo) }}"
							class="img-general object-cover w-100 border border-secondary">
						<div class="examinar-img group-hover:block">
							<div><button type="button"
									class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
							</div>
							<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
							<input type="hidden" name="patrocinadores_old[]" value="{{ $patrocinador->archivo }}" />
							<input type="file" name="patrocinadores_img[]" class="file-general" accept="image/*" style="display:none" />
						</div>
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							Título SEO:
						</label>
						<input class="input-underline" name="patrocinadores_titulo[]" value="{{ $patrocinador->titulo }}" type="text" required>
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							LINK:
						</label>
						<input class="input-underline" name="patrocinadores_link[]" value="{{ $patrocinador->link }}" type="text">
					</div>
					<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
						<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
						<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
									class="fas fa-trash-alt"></i></a></div>
					</div>
				</div>
			</div>
			@endforeach
		@else
		<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
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
					<input class="input-underline" name="patrocinadores_titulo[]" type="text" required>
				</div>
				<div class="mb-2">
					<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
						LINK:
					</label>
					<input class="input-underline" name="patrocinadores_link[]" type="text">
				</div>
				<div class="invisible group-hover:visible flex flex-row fotometria-acciones justify-between">
					<div class="handler cursor-move"><i class="fas fa-ellipsis-v"></i></div>
					<div class="delete-fotometria"><a href="javascript:void(0);" class="text-dark"><i
								class="fas fa-trash-alt"></i></a></div>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="text-right mt-5">
		<a href="" id="add_patrocinador" class="btn-pill">+ Agregar</a>
	</div>
</div>
<!-- /patrocinadores -->
