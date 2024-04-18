<footer class="mt-10">
	<div class="grid grid-cols-2 px-3 items-center">
		<div><img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-12" alt="{{ $cliente->cliente }}"></div>
		<?php /*<div class="ml-auto">{!! file_get_contents(public_path('images/logo.svg')) !!}</div>*/?>
	</div>
	@if ($cliente->secciones()->where('activa', 1)->where('seccion', 'social')->count() > 0)
	<div class="text-center mt-5">
		<div class="text-xl">{{($cliente->id !== 82)?'Síguenos:':'Follow us:'}}</div>
		<div class="text-center mt-3 flex flex-row items-center justify-center">
			@if ($cliente->instagram !== '' && $cliente->instagram !== NULL)
			<a href="{{ $cliente->instagram }}" target="_blank" class="mr-2"><img
					src="{{ asset('images/instagram.png') }}?v=1" class="object-fit w-14 h-auto" alt="Instagram"></a>
			@endif
			@if ($cliente->facebook !== '' && $cliente->facebook !== NULL)
			<a href="{{ $cliente->facebook }}" target="_blank" class="mr-2"><img src="{{ asset('images/facebook.png') }}?v=1"
					class="object-fit w-14 h-auto" alt="Facebook"></a>
			@endif
			@if ($cliente->twitter !== '' && $cliente->twitter !== NULL)
			<a href="{{ $cliente->twitter }}" target="_blank" class="mr-2"><img src="{{ asset('images/twitter.png') }}?v=1"
					class="object-fit w-14 h-auto" alt="Twitter"></a>
			@endif
			@if ($cliente->tiktok !== '' && $cliente->tiktok !== NULL)
			<a href="{{ $cliente->tiktok }}" target="_blank" class="mr-2"><img src="{{ asset('images/tiktok.png') }}?v=1"
					class="object-fit w-14 h-auto" alt="Tiktok"></a>
			@endif
			@if ($cliente->whatsapp !== '' && $cliente->whatsapp !== NULL)
			<a href="{{ $cliente->whatsapp }}" target="_blank"><img src="{{ asset('images/whatsapp.png') }}?v=1"
					class="object-fit w-14 h-auto" alt="Whatsapp"></a>
			@endif
		</div>
	</div>
	@endif
	@auth
	<div class="text-center mt-3 pb-20">
		<!-- Authentication -->
		<form method="POST" action="{{ route('logout', ['cliente' => $cliente->id]) }}">
			@csrf
			<a :href="route('logout', ['cliente' => $cliente->id])"
				class="text-base flex flex-row items-center justify-center"
				onclick="event.preventDefault(); this.closest('form').submit();">
				<div>{!! file_get_contents(public_path('images/salir.svg')) !!}</div>
				<div class="ml-2">{{ __('Log Out') }}</div>
			</a>
		</form>
	</div>
	@endauth
</footer>
