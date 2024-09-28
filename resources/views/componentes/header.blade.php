@php
$sucursal_id = Session::get('sucursal_id');
$sucursal = $cliente->sucursales->where('id', $sucursal_id)->first();
@endphp
<div id="header" class="fixed top-0 right-0 w-full px-2 py-3 z-50 bg-white shadow-sm">
		<div id="header-back"></div>
		@if (!$cliente->registro)
		<div class="flex flex-row justify-center items-center gap-5 relative">
			@if (Route::currentRouteName() !== 'cliente' && $cliente->id !== NULL)
			<a href="{{route('cliente', $cliente->slug)}}" class="absolute top-1 left-0">{!! file_get_contents(public_path('images/back.svg')) !!}</a>
			@endif
			@if ($cliente->id !== NULL)
			<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-[40px]" alt="{{ $cliente->cliente }}">
			@else
			<img src="{{ asset('images/logo@2x.png') }}" class="w-auto h-[40px]" alt="Arcaddy">
			@endif
			@role('admin')
			<a href="{{ route('dashboard') }}" class="absolute top-1 right-0">{!! file_get_contents(public_path('images/admin.svg')) !!}</a>
			@endrole
			@role('client')
			<a href="{{ route('my-app-client.home') }}" class="absolute top-1 right-0">{!! file_get_contents(public_path('images/admin.svg')) !!}</a>
			@endrole
		</div>
		@else
		<div class="flex flex-row justify-start items-center gap-5">
			<div class="flex flex-row flex-nowrap items-center">
				@if (Route::currentRouteName() !== 'cliente' && $cliente->id !== NULL)
				<a href="{{route('cliente', $cliente->slug)}}">{!! file_get_contents(public_path('images/back.svg')) !!}</a>
				@endif
				<div>
				@if ($cliente->id !== NULL)
				<img src="{{ asset('storage/'.$cliente->logo) }}" class="w-auto h-[40px]" alt="{{ $cliente->cliente }}">
				@else
				<img src="{{ asset('images/logo@2x.png') }}" class="w-auto h-[40px]" alt="Arcaddy">
				@endif
				</div>
			</div>
			@auth
			<div class="font-bold truncate w-2/5 md:grow text-center">
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
				@if (Route::has('register'))
				<a href="{{ route('register', ['cliente' => $cliente->id]) }}" class="text-base">{{ __('Register') }}</a>
				<div class="ml-2">|</div>
				@endif
				<a href="{{ route('login', ['cliente' => $cliente->id]) }}" class="ml-2 text-base">{{ __('Login') }}</a>
			</div>
			@endauth
		</div>
		@endif
		@if ($sucursal_id !== NULL && $sucursal !== NULL)
			<div class="flex flex-row items-center justify-center text-xs">
				<div class="font-bold">Sucursal:</div>
				<div class="ml-1">
					<a href="{{ route('cliente.picksucursal', ['slug' => $cliente->slug]) }}" class="underline">{{ $sucursal->nombre }}</a>
				</div>
			</div>
		@endif
	</div>
