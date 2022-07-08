@if($cliente->patrocinadores->count() > 0)
<section id="patrocinadores" class="mt-5 py-5 text-center">
	<div class="text-center font-extrabold text-4xl">Patrocinadores</div>
	<div class="color text-center font-extrabold text-4xl">{{ $cliente->titulo }}:</div>
	<div class="flex flex-col flex-wrap items-center justify-center">
		@foreach($cliente->patrocinadores as $patrocinador)
		<div class="w-full md:w-1/2 lg:w-1/3 px-2 mt-10">
			<img src="{{ asset('storage/'.$patrocinador->archivo) }}" class="object-fill w-3/4 h-auto inline">
		</div>
		@endforeach
	</div>
</section>
@endif
