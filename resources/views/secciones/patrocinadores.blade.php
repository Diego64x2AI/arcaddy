@if($cliente->patrocinadores->count() > 0)
<section id="patrocinadores" class="mt-5 p-5 text-center max-w-5xl mx-auto lg:px-8 lg:mt-10">
	<div class="text-center font-extrabold text-4xl lg:text-8xl">Patrocinadores</div>
	{{--  <div class="color text-center font-extrabold text-4xl lg:text-8xl">{{ $cliente->titulo }}:</div>--}}
	<div class="flex flex-col flex-wrap lg:flex-row items-center">
		@foreach($cliente->patrocinadores as $patrocinador)
		<div class="w-full md:w-1/2 px-2 mt-10">
			@if ($patrocinador->link !== NULL && trim($patrocinador->link) !== '')
				<a href="{{ $patrocinador->link }}" target="_blank"><img src="{{ asset('storage/'.$patrocinador->archivo) }}" class="object-fill w-3/4 h-auto inline"></a>
			@else
			<img src="{{ asset('storage/'.$patrocinador->archivo) }}" class="object-fill w-3/4 h-auto inline">
			@endif
		</div>
		@endforeach
	</div>
</section>
@endif
