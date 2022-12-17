<div id="experiencia" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="experiencia">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[experiencia]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'experiencia')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'experiencia')->first()->titulo : 'Experiencia inversiva link' }}">
		</div>
		<div class="ml-auto">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="experiencia-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'experiencia')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="experiencia-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'experiencia')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div id="experiencia-container" class="container-draggable mt-5 section-box">
		@if ($cliente->id !== NULL)
			@foreach ($cliente->experiencias as $entry)
			<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
				<div class="p-3">
					<div class="mb-2 relative">
						<img src="{{ asset('storage/'.$entry->archivo) }}"
							class="img-general object-cover w-100 border border-secondary">
						<div class="examinar-img group-hover:block">
							<div><button type="button"
									class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
							</div>
							<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
							<input type="hidden" name="experiencia_old[]" value="{{ $entry->archivo }}" />
							<input type="file" name="experiencia_img[]" class="file-general" accept="image/*"
								style="display:none" />
						</div>
					</div>
					<div class="mb-4">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							Título:
						</label>
						<input
							class="input-underline" value="{{ $entry->titulo }}"
							name="experiencia_titulo[]" type="text">
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							Link:
						</label>
						<input
							class="input-underline" value="{{ $entry->link }}"
							name="experiencia_link[]" type="url">
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							Instrucciones:
						</label>
						<textarea class="input-border" name="experiencia_instrucciones[]"
							rows="5">{{ $entry->descripcion }}</textarea>
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
				<div class="mb-2">
					<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
						Link:
					</label>
					<input
						class="input-underline"
						name="experiencia_link[]" type="url">
				</div>
				<div class="mb-2">
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
		</div>
		@endif
	</div>
	<div class="text-right mt-5">
		<a href="" id="add_experiencia" class="btn-pill">+ Agregar</a>
	</div>
</div>
<!-- /experiencia -->
