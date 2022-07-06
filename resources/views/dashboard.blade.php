<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white">
				<div class="pl-5 mb-4">
					<h1 class="font-extrabold text-base md:text-4xl">Clientes</h1>
				</div>
				<div class="p-6 bg-white border border-white">
					<div class="grid grid-cols-5 gap-5">
						<x-cliente name="VIBRA" slug="vibra" :logo="asset('images/cliente-1@2x.png')" />
						<x-cliente name="red bull" slug="redbull" :logo="asset('images/cliente-2@2x.png')" />
						<x-cliente name="VOLKSWAGEN" slug="vw" :logo="asset('images/cliente-3@2x.png')" />
						<div class="flex flex-col justify-center items-center">
							<a href="" class="rounded-full bg-pink-600 text-white text-center overflow-hidden flex flex-col justify-center items-center p-5 w-[9rem] h-[9rem]">
								<div class="text-5xl font-bold">+</div>
								<div>Agregar</div>
								<div>cliente</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@section('js')
		<script>
			window.addEventListener('load', function() {
				console.log(Sortable());
			});
		</script>
	@endsection
</x-app-layout>
