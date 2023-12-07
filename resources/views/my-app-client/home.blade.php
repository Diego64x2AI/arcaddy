@extends('my-app-client.layout')

@section('content')
<div class="alx-body-padding">
	<div class="alx-mobile-int" style="padding-left: 5px;padding-right: 5px;">
		<a class="alx-home-btn" id="alx-btn-ingreso"  href="{{route('my-app-client.check-in')}}">
			Ingreso de <br>usuarios a evento
		</a>
	</div>	
	<div class="alx-mobile-int">
		
<?php /*
		<a class="alx-home-btn" id="alx-btn-activaciones" href="{{route('my-app-client.reporte-activaciones')}}">
			Activaciones AR <br>y códigos QR
		</a>*/?>

		<a class="alx-home-btn" id="alx-btn-redenciones" href="{{route('my-app-client.reporte-redenciones')}}">
			Redenciones <br>digitales

		</a>

		<a class="alx-home-btn" id="alx-btn-usuarios" href="{{route('my-app-client.reporte-base-usuarios')}}">
			Base de datos <br>de usuarios
		</a>
<?php /*
		<a class="alx-home-btn" id="alx-btn-estadisticas" href="{{route('my-app-client.reporte-estadisticas')}}">
			Estadísticas <br>generales
		</a>*/?>
	</div>
</div>
@endsection