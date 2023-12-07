@extends('my-app-client.layout')

@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-redenciones">
			Redenciones <br>digitales
		</div>
	</div>
</div>
<div class="alx-section">
	<div class="container alx-mobile">
		
		<div class="row alx-mb-20">
			<div class="col-xs-12">
				<div class="input-container">
					<div class="alx-btn-search"></div>
					<input class="alx-input-search" type="text" name="search" placeholder="Buscar" autocomplete="off">
				</div>
			</div>
		</div>

		<div class="alx-table-txt">

			<div class="row alx-table-row-title">
				<div class="col-xs-6"></div>
				<div class="col-xs-3 alx-table-no-padding">
					<div class="alx-table-title-col">Desempeño</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding">
					<div class="alx-table-title-col">Total $</div>
				</div>
			</div>


			@foreach($productos as $producto)
			<div class="row alx-table-row">
				<div class="col-xs-6">
					<div class="alx-table-producto">
						<a class="alx-table-producto-img" href="{{route('my-app-client.producto-redencion',$producto->id)}}">
							<img src="{{asset('storage/'.$producto->imagenes[0]->archivo)}}">
						</a>
						<div>{!! $producto->nombre !!}</div>
						<div class="alx-table-txt-min">Valor: ${!! $producto->precio !!}</div>
					</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					<div class="alx-table-dato">300</div>
					<div class="alx-table-txt-min">Redenciones</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					<div class="alx-table-dato-min">18,000</div>
					<div class="alx-table-txt-min">Pesos</div>
				</div>
			</div>
			<div class="alx-table-row-border"></div>
			@endforeach


<?php /*
			<div class="row alx-table-row">
				<div class="col-xs-6">
					<div class="alx-table-producto">
						<div class="alx-table-producto-img">
							<img src="{{asset('/images-my-app/refresco.png')}}">
						</div>
						<div>Refresco Coca</div>
						<div class="alx-table-txt-min">Valor: $18</div>
					</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					<div class="alx-table-dato">580</div>
					<div class="alx-table-txt-min">Redenciones</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					<div class="alx-table-dato-min">10,440</div>
					<div class="alx-table-txt-min">Pesos</div>
				</div>
			</div>
			<div class="alx-table-row-border"></div>

			<div class="row alx-table-row">
				<div class="col-xs-6">
					<div class="alx-table-producto">
						<div class="alx-table-producto-img">
							<img src="{{asset('/images-my-app/cerveza.png')}}">
						</div>
						<div>Cerveza corona</div>
						<div class="alx-table-txt-min">Valor: $25</div>
					</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					<div class="alx-table-dato">800</div>
					<div class="alx-table-txt-min">Redenciones</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					<div class="alx-table-dato-min">20,000</div>
					<div class="alx-table-txt-min">Pesos</div>
				</div>
			</div>
			<div class="alx-table-row-border"></div>
			*/?>


			

			
		</div>



		<div class="row">
			<div class="col-xs-12">
				<a class="alx-btn alx-btn-cerrar" href="{{route('my-app-client.home')}}">CERRAR</a>
			</div>
		</div>
	</div>
</div>
@endsection