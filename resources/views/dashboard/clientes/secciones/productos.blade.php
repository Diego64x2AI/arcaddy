<div id="productos" class="bg-white p-3 mt-3 section-box">
	<input type="hidden" name="secciones[]" value="productos">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-5 grow">
			<input class="shadow appearance-none border w-full py-2 px-3 text-gray-700" name="titulos[productos]" type="text"
			value="{{ ($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'productos')->first()->titulo !== NULL) ? $cliente->secciones()->where('seccion', 'productos')->first()->titulo : 'Tienda Online' }}">
		</div>
		<div class="ml-auto">
			<span class="hidden md:inline-block">Mostrar título </span><input type="checkbox" name="productos-activo2" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'productos')->first()->mostrar_titulo) checked @endif>
		</div>
		<div class="ml-5">
			<span class="hidden md:inline-block">Módulo activo </span><input type="checkbox" name="productos-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'productos')->first()->activa) checked @endif>
		</div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	@if($cliente->id !== NULL)
		<div id="productos-container" class="mt-5 flex section-box">
		@foreach ($cliente->productos as $producto)
		<div class="w-2/4 md:w-1/4 bg-white mr-4">
			<div class="relative">
				<img src="{{ asset('storage/'.$producto->imagenes[0]->archivo) }}" class="object-cover w-100 border border-secondary">
				@if ($producto->descuento > 0 && !$producto->digital)
					<div class="absolute bottom-2 left-2 bg-pink-600 text-white py-2 px-4 rounded-t-2xl rounded-br-2xl">{{ $producto->descuento }}% OFF</div>
				@endif
				@if ($producto->digital)
					<div class="absolute bottom-2 left-2 bg-pink-600 text-white py-2 px-4 rounded-t-2xl rounded-br-2xl">CUP&Oacute;N</div>
				@endif
				@if ($producto->regalado)
					<div class="absolute top-2 left-2 bg-pink-600 text-white py-2 px-4 rounded-t-2xl rounded-br-2xl" style="top: 5px;">CANJE</div>
				@endif
			</div>
			<div class="text-center px-2 mt-2">{{ $producto->nombre }}</div>
			<div class="text-center font-bold px-2 mt-2">${{ $producto->precio }}</div>
			<div class="text-center">
				@if ($producto->digital)
					<a href="{{ route('productos.qrcode', ['producto' => $producto->id]) }}" class="btn btn-primary"><i class="fas fa-qrcode"></i></a>
				@endif
				<a href="{{ route('productos.edit', ['cliente' => $cliente->id, 'producto' => $producto->id]) }}" class="text-sky-500"><i class="fa fa-edit"></i></a>
				<a href="{{ route('productos.destroy', ['producto' => $producto->id]) }}" type="button" class="text-red-500 delete-form-producto">
					<i class="fas fa-trash-alt"></i>
				</a>
			</div>
		</div>
		@endforeach
		</div>
		<div class="text-sm text-gray-500 mt-5">
			<span class="font-bold">Cupón:</span> No se muestra en la página, es para generar un cupones que se ganan en el quiz o se asignan manualmente a los usuarios como regalo.
		</div>
		<div class="text-sm text-gray-500 mt-1">
			<span class="font-bold">Canje:</span> Se muestra en la página, con botón para canjear con el QR del usuario.
		</div>
	@else
		<p class="text-center py-10">Para poder agregar productos, guarda primero la información para generar el cliente.</p>
	@endif
	@if($cliente->id !== NULL)
	<div class="text-right mt-5">
		<a href="{{ route('productos.create', ['cliente' => $cliente->id]) }}" class="btn-pill">+ Agregar</a>
	</div>
	@endif
</div>
<!-- /descriptivos -->
