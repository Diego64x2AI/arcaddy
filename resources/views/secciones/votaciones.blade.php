@if($cliente->votaciones->count() > 0)
<section id="votaciones" class="py-10 px-5">
	@foreach ($cliente->votaciones as $votacion)
		{{--<div class="text-center px-5 color text-4xl font-extrabold lg:text-8xl">Votación</div> --}}
		<div class="titulo-modulo">{{ $votacion->nombre }}</div>
		<div class="flex flex-row justify-evenly py-5 filter-button-group">
			@foreach ($votacion->categorias as $categoria)
				<button class="btn-pill2 @if($loop->index === 0) current-cat @endif" data-filter=".cat-{{ $categoria->id }}"">{{ $categoria->nombre }}</button>
			@endforeach
		</div>
		<div class="isotope-votaciones grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
			@php
			$participantes = ($votacion->finalistas) ? $votacion->participantes()->where('finalista', 1)->get() : $votacion->participantes;
			@endphp
			@foreach ($participantes as $participante)
				@php
				$plataforma = '';
				$plataforma_user = '';
				$video_id = '';

				$link = $participante->link;

				if($participante->link == ''){


					$plataforma = 'imagen';

				}
				else{ /*INICIO CON con LINK*/
				@preg_match('~/d/\K[^/]+(?=/)~', $participante->link, $result);
				if (!empty($result)) {
					$video_id = $result[0];
					$plataforma = 'google';
				}
				else {
				        $host = parse_url($link, PHP_URL_HOST);

                        if ($host === "youtube.com" || $host === "www.youtube.com") {

                        	// Obtener los par��metros de la URL
                        	$queryParams = parse_url($link, PHP_URL_QUERY);

                        	// Parsear los par��metros en un array
                        	parse_str($queryParams, $params);

                        	// Obtener el valor de la variable 'v'
                        	$vValue = $params['v'];

                        	$video_id = $vValue;
            				$plataforma = 'youtube';

                        }
                        else {

                            	$response = json_decode(@file_get_contents("https://vimeo.com/api/oembed.json?url=".$participante->link));

            					$video_id = $response->video_id;
            					$plataforma = 'vimeo';

                        }

				}
				}/*FIn con LINK*/
				@endphp
				<div
					class="isotope-item isotope-votaciones-item border-4 border-transparent w-1/3 md:w-1/4 lg:w-1/6 mb-2 participante-{{ $participante->id }} cat-{{ $participante->categoria_id }}"
					data-video-id="{{ $video_id }}"
					data-plataforma="{{ $plataforma }}"
					data-plataforma-user="{{ $plataforma_user }}"
					data-categoria="{{ $votacion->categorias->where('id', $participante->categoria_id)->first()->nombre }}"
					data-nombre="{{ $participante->user->name }}"
					data-votos="{{ $participante->votos }}"
					data-id="{{ $participante->id }}"
					data-votaciones="{{ $votacion->votar ? 'Y' : 'N' }}"
					data-imagen="{{ asset('storage/'.$participante->imagen) }}"
				>
					<div>
						<img src="{{ asset('storage/'.$participante->imagen) }}" class="img-general inline-block object-cover w-full h-auto" alt="{{ $participante->user->name }}">
					</div>
					<div class="text-center text-sm font-bold uppercase mt-2">{{ $participante->user->name }}</div>
					@if($votacion->votar)
					<div class="text-center text-sm font-bold color votos-{{ $participante->id }} uppercase">{{ $participante->votos }} votos</div>
					@endif
				</div>
			@endforeach
		</div>
	@endforeach
</section>
@endif
