@if ($cliente->facebook_live !== '' && $cliente->facebook_live !== NULL)
	@php
	@preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $cliente->facebook_live, $result);
	$plataforma = '';
	$plataforma_user = '';
	$video_id = '';
	if (!empty($result)) {
		$video_id = $result[0];
		$plataforma = 'youtube';
	} else {
		@preg_match("/https:\/\/vimeo.com\/event\/([0-9]+)/", $cliente->facebook_live, $result);
		if (!empty($result)) {
			$video_id = $result[1];
			$plataforma = 'vimeo_live';
		} else {
			$response = json_decode(@file_get_contents("https://vimeo.com/api/oembed.json?url=".$cliente->facebook_live));
			// dd($response);
			//@preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/?(showcase\/)*([0-9))([a-z]*\/)*([0-9]{6,11})[?]?.*/', $participante->link, $result);
			$video_id = $response->video_id;
			$plataforma = 'vimeo';
			$plataforma_user = explode(":", $response->uri)[1];
		}
	}
	@endphp
	<div class="aspect-w-16 aspect-h-9">
		@if($plataforma === 'youtube')
		<iframe
			src="https://www.youtube.com/embed/{{ $matches[0] }}?&autoplay=1&mute=1&rel=0"
			frameborder="0"
			allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
			allowfullscreen
		></iframe>
		@elseif($plataforma === 'vimeo_live')
		<iframe
			src="https://vimeo.com/event/{{ $video_id }}/embed"
			frameborder="0"
			allow="autoplay; fullscreen; picture-in-picture"
			webkitallowfullscreen
			mozallowfullscreen
			allowfullscreen
		></iframe>
		@elseif($plataforma === 'vimeo')
		<iframe
			src="https://player.vimeo.com/video/{{ $video_id }}?h={{ $plataforma_user }}&badge=0&autopause=0&player_id=0"
			frameborder="0"
			allow="autoplay; fullscreen; picture-in-picture"
			webkitallowfullscreen
			mozallowfullscreen
			allowfullscreen
		></iframe>
		@endif
	</div>
@endif
