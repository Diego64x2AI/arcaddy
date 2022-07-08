<x-guest-layout>
	<div class="min-h-screen flex flex-col justify-center items-center pt-6">
		<div>
			<a href="/">
				<x-application-logo class="w-auto h-20 fill-current text-gray-500" />
			</a>
		</div>
	</div>
	<div class="fixed top-0 right-0 px-6 py-4">
		@auth
		<a href="{{ url('/dashboard') }}" class="text-base text-white">Dashboard</a>
		@else
		<a href="{{ route('login') }}" class="text-base text-white">Log in</a>

		@if (Route::has('register'))
		<a href="{{ route('register') }}" class="ml-4 text-base text-white">Register</a>
		@endif
		@endauth
	</div>
</x-guest-layout>
