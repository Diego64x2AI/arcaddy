<div id="header" class="fixed top-0 right-0 w-full px-2 py-3 z-50 bg-white shadow-sm">
		<div id="header-back"></div>
		<div class="flex flex-row justify-center items-center">
			<div class="mr-auto">
				&nbsp;
			</div>
			<div class="flex flex-col md:flex-row items-center justify-center">
				<img src="{{ asset('storage/'.$cliente->logo) }}" style="height: 40px; width:auto" alt="{{ $cliente->cliente }}">
			</div>
			@auth
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
			<div class="ml-auto"><span class="w-10 h-auto inline-block">&nbsp;</span></div>
			@endauth
		</div>
		<div class="text-center mt-2 font-normal flex flex-row items-center justify-center">
			@auth
			{{ auth()->user()->name }}
			@else
			@if ($cliente->registro)
			@if (Route::has('register'))
			<a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="text-base">{{ __('Register') }}</a>
			<div class="ml-2">|</div>
			@endif
			<a href="{{ route('login', ['cliente' => $cliente->id]) }}" class="ml-2 text-base">{{ __('Login') }}</a>
			@endif
			@endauth
		</div>
	</div>
