@php
$scores = \App\Models\JuegoResultado::whereIn('juego_id', $cliente->juegos->pluck('id')->toArray())->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->paginate(10);
$scoresAll = \App\Models\JuegoResultado::whereIn('juego_id', $cliente->juegos->pluck('id')->toArray())->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->get();
$mPosicion = -1;
if (auth()->check()) {
	$mPosicion = (array_search(auth()->user()->id, $scoresAll->pluck('user_id')->toArray()) === false) ? -1 : array_search(auth()->user()->id, $scoresAll->pluck('user_id')->toArray());
}
@endphp
@if($scores->total() > 0)
<section id="ranking" class="mt-5 py-5 text-center lg:mt-10 mx-auto w-full max-w-xl">
	<div class="flex flex-row items-center justify-center">
		<div class="text-4xl font-extrabold lg:text-8xl">Ranking</div>
		<div class="color text-2xl font-extrabold lg:text-4xl ml-3 mt-1">Usuarios</div>
	</div>
	<div id="ranking-leaderboard" class="mt-5 lg:mt-10 px-5">
	</div>
	@if($scores->hasMorePages())
	<div id="hasMorePages" class="mt-5">
		<a id="load-ranking" href="#" class="btn-pill">Cargar más</a>
	</div>
	@endif
</section>
<script>
	let currentPage = 0;
	let perPage = {{ $scores->perPage() }};
	let hasMorePages = {{ $scores->hasMorePages() ? 'true' : 'false' }};
	let lastPage = {{ $scores->lastPage() }};
	let rakingLoading = false;
	let rankingFrom = 0;
	let rankingUID = {{ auth()->check() ? auth()->user()->id : '0' }};
	const ranking_url = '{{ route("api.rankings", ["cliente" => $cliente->id]) }}';
	let myUserPositionHtml = '';
	const mPosicion = {{ $mPosicion + 1 }};
	@if ($mPosicion !== -1 && isset($scoresAll[$mPosicion]))
		myUserPositionHtml = `
		<div class="flex flex-row items-center mb-2 tu-ranking-box">
			<div class="color font-bold text-2xl text-center w-5">{{ $mPosicion + 1 }}</div>
			<div class="flex flex-row grow ml-2 items-center px-3 py-2 rounded-3xl" style="background-color: {{ $cliente->color }}; color: {{ $cliente->color_bg }};">
				{{--<div><img src="{{ asset('images/Imagen 73.jpg') }}" class="w-10 h-10 rounded-full" alt="Juan Carlos Perez"></div>--}}
				<div class="grow text-left ml-2 font-semibold text-xs md:text-normal">
					<div>TÚ</div>
					<div>{{ $scoresAll[$mPosicion]['user']['name'] }}</div>
				</div>
				<div class="ml-auto font-extrabold text-xl">{{ $scoresAll[$mPosicion]['tiempo'] }} seg</div>
			</div>
		</div>
		`;
	@endif
	window.addEventListener('load', function() {
		console.log(`ranking load`);
		$('a#load-ranking').click(function(e){
			e.preventDefault();
			if (!hasMorePages || rakingLoading) {
				return
			}
			currentPage++;
			rakingLoading = true;
			$.get(`${ranking_url}?page=${currentPage}`, function(data){
				console.log(data);
				rankingFrom = data.from;
				$('.tu-ranking-box').hide();
				data.data.forEach((item) => {
					console.log(item)
					let style = (rankingFrom === 1) ? ` style="background-color: {{ $cliente->color_base }}; color: {{ $cliente->color_bg }};"` : ``;
					if (rankingUID === item.user.id) {
						style = ` style="background-color: {{ $cliente->color }}; color: {{ $cliente->color_bg }};"`;
					}
					$('#ranking-leaderboard').append(`
					<div class="flex flex-row items-center mb-2">
						<div class="color font-bold text-2xl text-center w-5">${rankingFrom}</div>
						<div class="flex flex-row grow ml-2 items-center px-3 py-2 rounded-3xl"${style}>
							{{--<div><img src="{{ asset('images/Imagen 73.jpg') }}" class="w-10 h-10 rounded-full" alt="Juan Carlos Perez"></div>--}}
							<div class="grow text-left ml-2 font-semibold text-xs md:text-normal">${item.user.name}</div>
							<div class="ml-auto font-extrabold text-xl">${item.tiempo} seg</div>
						</div>
					</div>
					`);
					rankingFrom++;
				});
				if (mPosicion >= rankingFrom) {
					$('#ranking-leaderboard').append(myUserPositionHtml);
				}
				if (data.next_page_url === null) {
					hasMorePages = false;
					$('#hasMorePages').hide(100);
				}
				rakingLoading = false;
			}, 'json');
		}).trigger('click');
	});
</script>
@endif
