<div id="header" class="fixed top-0 right-0 w-full px-2 py-3 z-50 bg-white shadow-sm">
		<div id="header-back"></div>
		<div class="flex flex-row justify-start items-center gap-5">
			<div class="flex flex-row flex-nowrap items-center">
				@if (Route::currentRouteName() !== 'cliente')
				<a href="{{route('cliente', $cliente->slug)}}">{!! file_get_contents(public_path('images/back.svg')) !!}</a>
				@endif
				<div>
					<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-[40px]" alt="{{ $cliente->cliente }}">
				</div>
			</div>
			@auth
			<div class="font-bold truncate w-2/5 text-center">
				{{ auth()->user()->name }}
			</div>
			<div class="ml-auto">
				@role('admin')
				<a href="{{ route('dashboard') }}">{!! file_get_contents(public_path('images/admin.svg')) !!}</a>
				@endrole
				@role('client')
				<a href="{{ route('my-app-client.home') }}">{!! file_get_contents(public_path('images/admin.svg')) !!}</a>
				@endrole
				@role('user')
				<a href="{{route('registro', ['cliente' => $cliente->id])}}?ver=1">{!!
					file_get_contents(public_path('images/qr.svg')) !!}</a>
				@endrole
			</div>
			@else
			<div class="ml-auto flex flex-row items-center flex-nowrap">
				@if ($cliente->registro)
				@if (Route::has('register'))
				<a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="text-base">Registro</a>
				<div class="ml-2">|</div>
				@endif
				<a href="{{ route('login', ['cliente' => $cliente->id]) }}" class="ml-2 text-base">Login</a>
				@endif
			</div>
			@endauth
		</div>
	</div>
