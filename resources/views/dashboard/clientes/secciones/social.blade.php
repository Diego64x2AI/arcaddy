<div id="social" class="bg-white p-3 mt-3 section-box">
	<input type="hidden" name="secciones[]" value="social">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-1">Social Media</div>
		<div class="ml-auto"><span class="hidden md:inline-block">Activar / Desactivar </span><input type="checkbox" name="social-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'social')->first()->activa) checked @endif></div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="flex flex-wrap items-center -mx-3 mt-5">
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<div class="flex flex-row items-center">
				<div>
					<img src="{{ asset('images/facebook.png') }}" class="object-fit w-12 h-auto" alt="Facebook">
				</div>
				<div class="ml-3 grow">
					<label class="block tracking-wide text-gray-900 text-base font-bold" for="facebook">
						Link
					</label>
					<input class="input-underline" name="facebook" id="facebook" value="{{ ($cliente->id !== NULL) ? $cliente->facebook : old('facebook') }}"
						type="url">
				</div>
			</div>
		</div>
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<div class="flex flex-row items-center">
				<div>
					<img src="{{ asset('images/instagram.png') }}" class="object-fit w-12 h-auto" alt="Instagram">
				</div>
				<div class="ml-3 grow">
					<label class="block tracking-wide text-gray-900 text-base font-bold" for="instagram">
						Link
					</label>
					<input class="input-underline" name="instagram" id="instagram" value="{{ ($cliente->id !== NULL) ? $cliente->instagram : old('instagram') }}"
						type="url">
				</div>
			</div>
		</div>
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<div class="flex flex-row items-center">
				<div>
					<img src="{{ asset('images/twitter.png') }}" class="object-fit w-12 h-auto" alt="Twitter">
				</div>
				<div class="ml-3 grow">
					<label class="block tracking-wide text-gray-900 text-base font-bold" for="twitter">
						Link
					</label>
					<input class="input-underline" name="twitter" id="twitter" value="{{ ($cliente->id !== NULL) ? $cliente->twitter : old('twitter') }}"
						type="url">
				</div>
			</div>
		</div>
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<div class="flex flex-row items-center">
				<div>
					<img src="{{ asset('images/tiktok.png') }}" class="object-fit w-12 h-auto" alt="Tiktok">
				</div>
				<div class="ml-3 grow">
					<label class="block tracking-wide text-gray-900 text-base font-bold" for="tiktok">
						Link
					</label>
					<input class="input-underline" name="tiktok" id="tiktok" value="{{ ($cliente->id !== NULL) ? $cliente->tiktok : old('tiktok') }}"
						type="url">
				</div>
			</div>
		</div>
		<div class="w-full md:w-1/3 px-3 mb-6 md:mb-2">
			<div class="flex flex-row items-center">
				<div>
					<img src="{{ asset('images/whatsapp.png') }}" class="object-fit w-12 h-auto" alt="Whatsapp">
				</div>
				<div class="ml-3 grow">
					<label class="block tracking-wide text-gray-900 text-base font-bold" for="whatsapp">
						Link
					</label>
					<input class="input-underline" name="whatsapp" id="whatsapp" value="{{ ($cliente->id !== NULL) ? $cliente->whatsapp : old('whatsapp') }}"
						type="url">
				</div>
			</div>
		</div>

	</div>

</div>
<!-- /descriptivos -->
