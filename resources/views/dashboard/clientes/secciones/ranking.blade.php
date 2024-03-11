<div id="ranking" class="bg-white p-3 mt-3 section-box">
	<input type="hidden" name="secciones[]" value="ranking">
	<div class="flex flex-row items-center font-bold">
		<div class="text-xl md:text-3xl truncate mr-1">Ranking Usuarios</div>
		<div class="ml-auto"><span class="hidden md:inline-block">Activar / Desactivar </span><input type="checkbox" name="ranking-activo" value="on" @if($cliente->id !== NULL && $cliente->secciones()->where('seccion', 'ranking')->first()->activa) checked @endif></div>
		<div class="ml-5 cursor-move handler2">Mover <i class="fas fa-ellipsis-v"></i></div>
	</div>
	<div class="text-center flex flex-row justify-center items-center">
    <dotlottie-player src="https://lottie.host/8098cf36-fe3e-4181-b9f5-1bf97918a3ee/9KuD05DkOl.json" background="transparent" speed="1" style="width: 150px; height: auto;" loop autoplay></dotlottie-player>
	</div>
</div>
<!-- /descriptivos -->
