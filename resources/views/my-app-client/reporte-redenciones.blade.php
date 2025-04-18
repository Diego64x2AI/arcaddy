@extends('my-app-client.layout')

@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-redenciones">
			{{ __('arcaddy.admin3') }}<br>{{ __('arcaddy.admin4') }}
		</div>
	</div>
</div>
<div class="alx-section">
	<div class="container alx-mobile">

		<div class="row alx-mb-20">
			<div class="col-xs-12">
				<form method="POST" action="{{route('my-app-client.reporte-redenciones')}}">
					@csrf
					<div class="input-container">
						<button type="submit" class="alx-btn-search"></button>
						<input class="alx-input-search" type="text" name="buscar" placeholder="{{ __('arcaddy.search') }}" autocomplete="off" value="{{ $busqueda }}">
					</div>
				</form>
			</div>
		</div>

		<div class="alx-table-txt">

			<div class="row alx-table-row-title">
				<div class="col-xs-12"></div>

			</div>


			@foreach($productos as $producto)
			<div class="row alx-table-row">
				<div class="col-xs-12">
					<div class="alx-table-producto">
						<a class="alx-table-producto-img" href="{{route('my-app-client.producto-redencion',$producto->id)}}">
							<img src="{{asset('storage/'.$producto->imagenes[0]->archivo)}}">
						</a>
						<div class="font-bold">{!! $producto->nombre !!}</div>
						@if ($producto->digital)
						<div class="text-sm">
							Stock: {{ ($producto->cantidad === -1) ? 'Ilimitado' : $producto->cantidad }}
						</div>
						@else
						@if($producto->precio != '0')
						<div class="alx-table-txt-min">Valor: ${!! $producto->precio !!}</div>
						@endif
						@endif
					</div>
				</div>

			</div>
			<div class="alx-table-row-border"></div>
			@endforeach





		</div>



		<div class="row">
			<div class="col-xs-12">
				<a class="alx-btn alx-btn-cerrar" href="{{route('my-app-client.home')}}">{{ __('arcaddy.close') }}</a>
			</div>
		</div>
	</div>
</div>
@endsection
