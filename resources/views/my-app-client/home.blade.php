@extends('my-app-client.layout')

@section('content')
@if(isset($clientedatos))
<div class="alx-body-padding">
<?php /*
		<a class="alx-home-btn" id="alx-btn-activaciones" href="{{route('my-app-client.reporte-activaciones')}}">
			Activaciones AR <br>y códigos QR
		</a>*/?>
	@if($clientedatos->id !== 86)
	<div class="alx-mobile-int" style="padding-left: 5px;padding-right: 5px;">
		<a class="alx-home-btn" id="alx-btn-ingreso"  href="{{route('my-app-client.check-in')}}">
			{{ __('arcaddy.admin1') }}<br>{{ __('arcaddy.admin2') }}
		</a>
	</div>
	<div class="alx-mobile-int">
		<a class="alx-home-btn" id="alx-btn-redenciones" href="{{route('my-app-client.reporte-redenciones')}}">
			{{ __('arcaddy.admin3') }}<br>{{ __('arcaddy.admin4') }}
		</a>
	</div>
	@endif
	<div class="alx-mobile-int">
		<a class="alx-home-btn" id="alx-btn-usuarios" href="{{route('my-app-client.reporte-base-usuarios')}}">
			{{ __('arcaddy.admin5') }}<br>{{ __('arcaddy.admin6') }}
		</a>
	</div>
<?php /*
		<a class="alx-home-btn" id="alx-btn-estadisticas" href="{{route('my-app-client.reporte-estadisticas')}}">
			Estadísticas <br>generales
		</a>*/?>

</div>
@endif
@endsection
