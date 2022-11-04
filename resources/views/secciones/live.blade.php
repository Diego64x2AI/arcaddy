@if ($cliente->facebook_live !== '' && $cliente->facebook_live !== NULL)
	@php
	preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $cliente->facebook_live, $matches);
	@endphp
	{{-- https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fcarlos.fusion%2Fvideos%2F386377026809862%2F&width=1280 --}}
	<iframe
		src="https://www.youtube.com/embed/{{ $matches[0] }}?&autoplay=1&mute=1"
		frameborder="0"
		allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
		allowfullscreen
		class="w-full aspect-video"
	></iframe>
@endif
