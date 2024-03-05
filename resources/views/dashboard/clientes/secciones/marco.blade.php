<div id="marco" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="marco">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[marco]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'marco')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'marco')->first()->titulo : 'Marco / Photoop' }}">
		</div>
		<div class="ml-auto">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="marco-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'marco')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="marco-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'marco')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="mt-10 text-center">
		<span class="font-extrabold">Link</span>: <a href="{{ url("/{$cliente->slug}/marco") }}" target="_blank">{{ url("/{$cliente->slug}/marco") }}</a>
	</div>
	<div id="marco-container" class="container-draggable mt-5 section-box">
		@if ($cliente->id !== NULL)
			@foreach ($cliente->marco as $marco)
			<div class="w-2/4 md:w-1/4 float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
				<div class="p-3">
					<div class="mb-2 relative">
						<img src="{{ asset('storage/'.$marco->archivo) }}"
							class="img-general object-cover w-100 border border-secondary">
						<div class="examinar-img group-hover:block">
							<div><button type="button"
									class="examinar-btn rounded-full bg-pink-600 text-white px-5 py-2 inline-block">Examinar...</button>
							</div>
							<small class="examinar-size text-gray-400">(jpg 1000x1000px)</small>
							<input type="hidden" name="marco_id[]" value="{{ $marco->id }}" />
							<input type="hidden" name="marco_old[]" value="{{$marco->archivo}}" />
							<input type="file" name="marco_img[]" class="file-general" accept="image/*" style="display:none" />
						</div>
					</div>
					<div class="mb-2">
						<label class="block tracking-wide text-gray-700 text-base font-bold mb-1">
							Título:
						</label>
						<input class="input-underline" name="marco_titulo[]" value="{{ $marco->titulo }}" type="text">
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
		</div>
		@endif
	</div>
	<div class="text-right mt-5">
		<a href="" id="add_marco" class="btn-pill">+ Agregar</a>
	</div>
</div>
<!-- /marco -->
