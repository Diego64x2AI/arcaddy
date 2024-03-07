<div id="menu" class="bg-white p-3 mt-3">
	<input type="hidden" name="secciones[]" value="menu">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[menu]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'menu')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'menu')->first()->titulo : 'Menú / Catálogo / Producto o servicio' }}">
		</div>
		<div class="ml-auto">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="menu-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'menu')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="menu-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'menu')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div id="menu-container" class="container-draggable mt-5 section-box">
		@if ($cliente->id !== NULL)
			@foreach ($cliente->menu()->orderBy('id', 'asc')->groupBy('categoria')->pluck('categoria') as $key => $menu_categoria)
			<div class="w-full float-left bg-white hover:bg-gray-100 hover:shadow fotometria-box group">
				<div class="p-3">
					<div>
						<input class="input-underline" name="menu_cat_nombre[]" value="{{ ucwords($menu_categoria) }}" type="text" placeholder="Nombre de la categoría" required>
					</div>
					<div id="menu-items" class="flex flex-col">
						@foreach ($cliente->menu->where('categoria', $menu_categoria) as $menu)
						<div class="bg-white item-container mt-2 p-2 flex flex-row h-20 overflow-hidden">
							<div class="handler2 cursor-move"><i class="fas fa-ellipsis-v"></i></div>
							<div class="ml-4 w-1/5">
								<div class="relative">
									<img src="{{ ($menu->archivo !== NULL && trim($menu->archivo) !== '') ? asset('storage/'.$menu->archivo) : asset('images/blank.png') }}"
										class="img-general object-cover w-100 border border-secondary">
									<div class="examinar-img2 absolute top-0 left-0 w-full h-full hidden flex-row items-center justify-center group-hover:flex">
										<div><button type="button"
												class="examinar-btn rounded-full bg-pink-600 text-white text-xs px-2 py-1 inline-block">Examinar...</button>
										</div>
										<input type="hidden" name="menu_item_old[{{ $key }}][]" value="{{$menu->archivo}}" />
										<input type="file" name="menu_item_img[{{ $key }}][]" class="file-general" accept="image/*" style="display:none" />
									</div>
								</div>
							</div>
							<div class="ml-2 grow grid grid-cols-2 gap-2">
								<div>
									<input class="input-underline" name="menu_item_nombre[{{ $key }}][]" value="{{$menu->nombre}}" type="text" placeholder="Nombre" required>
								</div>
								<div>
									<input class="input-underline" name="menu_item_cantidad[{{ $key }}][]" value="{{$menu->cantidad}}" type="text" placeholder="Cantidad (gr, ml, unidades)">
								</div>
								<div>
									<input class="input-underline" name="menu_item_precio[{{ $key }}][]" value="{{$menu->precio}}" type="text" placeholder="Precio">
								</div>
								<div>
									<input class="input-underline" name="menu_item_boton_titulo[{{ $key }}][]" value="{{$menu->boton_titulo}}" type="text" placeholder="Título botón">
								</div>
								<div>
									<input class="input-underline" name="menu_item_boton_link[{{ $key }}][]" value="{{$menu->boton_link}}" type="url" placeholder="Link">
								</div>
								<div>
									<input class="input-underline" name="menu_item_canje_texto[{{ $key }}][]" value="{{$menu->canje_texto}}" type="text" placeholder="Etiqueta">
								</div>
								<div class="mb-2 col-span-2">
									<textarea class="input-border" name="menu_item_descripcion[{{ $key }}][]" rows="2" placeholder="Descripción">{{$menu->descripcion}}</textarea>
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
						</div>
						@endforeach
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
			</div>
			@endforeach
		@endif
	</div>
	<div class="text-right mt-5">
		<a href="" id="add_menu_cat" class="btn-pill">+ Categoría</a>
	</div>
</div>
<!-- /menu -->
