@php
$scores = \App\Models\JuegoResultado::whereIn('juego_id', $cliente->juegos->pluck('id')->toArray())->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->get();
@endphp
@if($scores->count() > 0)
<section id="ranking" class="mt-5 py-5 text-center lg:mt-10 mx-auto w-full max-w-xl">
	<div class="flex flex-row items-center justify-center">
		<div class="text-4xl font-extrabold lg:text-8xl">Ranking</div>
		<div class="color text-2xl font-extrabold lg:text-4xl ml-3 mt-1">Usuarios</div>
	</div>
	<div id="ranking-leaderboard" class="mt-5 lg:mt-10 px-5">
		@foreach ($scores as $score)
		<div class="flex flex-row items-center mb-2">
			<div class="color font-bold text-2xl text-center w-5">{{ $loop->iteration }}</div>
			<div class="flex flex-row grow ml-2 items-center px-3 py-2 rounded-3xl" @if($loop->iteration === 1) style="background-color: {{ $cliente->color_base }}; color: {{ $cliente->color_bg }};" @endif>
				{{--<div><img src="{{ asset('images/Imagen 73.jpg') }}" class="w-10 h-10 rounded-full" alt="Juan Carlos Perez"></div>--}}
				<div class="grow text-left ml-2 text-normal">{{ $score->user->name }}</div>
				<div class="ml-auto font-extrabold text-xl">{{ $score->tiempo }} seg</div>
			</div>
		</div>
		@endforeach
	</div>
</section>
@endif
