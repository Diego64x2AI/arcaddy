@php
	list($r, $g, $b) = sscanf($cliente->color_bg, "#%02x%02x%02x");
	list($r2, $g2, $b2) = sscanf($cliente->color, "#%02x%02x%02x");
	@endphp
	<style>
		.swiper {
			width: 100%;
			height: auto;
			overflow: hidden;
		}

		.swiper-pagination-bullet {
			width: 16px !important;
			height: 16px !important;
			background: #E6E6E6 !important;
			opacity: 1 !important;
		}

		.slide-bg {
			height: calc(100vh - 72px)!important;
		}

		@media (max-width: 800px) {
			.slide-bg {
				height: calc(60vh)!important;
			}
		}

		body {
			background-color: {{ $cliente->color_bg }} !important;
			color: {{ $cliente->color_base }} !important;

			@if($cliente->imagen_background != '')
			background-image: url('{{ asset('storage/'.$cliente->imagen_background) }}');
			background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
			@endif
		}

		#header {
			/*background-color: {{ $cliente->color_bg }} !important;*/
			background-color: transparent !important;
		}
		#header-back{
		    background-color: {{ $cliente->color_bg }};
		    height: 100%;
		    width: 100%;
		    display: block;
		    position: absolute;
		    z-index: -1;
		    opacity: 0.8;
		    left: 0px;
		    top: 0px;
		}
		.swal2-popup {
			background-color: rgba({{ $r }},{{ $g }},{{ $b }},1)!important;
			color: {{ $cliente->color }} !important;
		}
		.swal2-confirm {
			background-color: {{ $cliente->color }} !important;
			color: {{ $cliente->color_bg }} !important;
		}
		.swiper-button-next, .swiper-button-prev {
			background: linear-gradient(270deg, rgba({{ $r }},{{ $g }},{{ $b }},0.5) 0%, rgba({{ $r }},{{ $g }},{{ $b }},1) 100%);
			color: {{ $cliente->color }} !important;
		}
		.swiper-button-next {
			background: linear-gradient(45deg, rgba({{ $r }},{{ $g }},{{ $b }},0.5) 0%, rgba({{ $r }},{{ $g }},{{ $b }},1) 100%);
		}
		.btn-pill {
			background-color: {{ $cliente->color }} !important;
		}
		[type='checkbox'], [type='radio'] {
			color: {{ $cliente->color }} !important;
		}
		select {
			background-color: {{ $cliente->color_bg }} !important;
			border-color: rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},0.5) !important;
			outline-color: transparent !important;
			color: {{ $cliente->color_base }} !important;
		}
		option, option:hover, option:focus, option:active {
			background-color: {{ $cliente->color_bg }} !important;
		}
		option:checked {
			background-color: rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},0.2) !important;
		}
		.btn-pill2 {
			background-color: {{ $cliente->color_base }} !important;
			color: {{ $cliente->color_bg }} !important;
		}
		.isotope-menu-item {
			background-color: {{ $cliente->color_bg }};
			border: 1px solid rgba({{ $r2 }},{{ $g2 }},{{ $b2 }},0.5);
		}
		.color, .swal2-close {
			color: {{ $cliente->color }} !important;
			fill: {{ $cliente->color }} !important;
		}

		.borde {
			border-color: {{ $cliente->color }} !important;
		}

		.color2 {
			color: {{ $cliente->color_base }} !important;
			fill: {{ $cliente->color_base }} !important;
		}

		.bg-client {
			background-color: {{ $cliente->color }} !important;
		}

		.current-cat {
			color: #FFF;
			background-color: {{ $cliente->color }} !important;
		}

		.swiper-pagination-bullet-active {
			background: {{ $cliente->color }} !important;
		}

		.img-votacion-detalle{
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
		}
		.isotope-menu-item:hover{
		    color: #000000;
		}
		@media (min-width: 1024px){
			.lg\:text-8xl {
			    font-size: 3rem;
			}
		}
	</style>
