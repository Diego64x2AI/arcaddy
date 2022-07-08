@if ($cliente->facebook_live !== '' && $cliente->facebook_live !== NULL)
	{{-- https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fcarlos.fusion%2Fvideos%2F386377026809862%2F&width=1280 --}}
	<iframe
		src="https://www.facebook.com/plugins/video.php?href={{ urlencode($cliente->facebook_live) }}"
			frameborder="0"
			allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"
			class="w-full aspect-video"
	></iframe>
@endif
