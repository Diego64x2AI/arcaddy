@extends('my-app-client.layout')

@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-activaciones">
			Activaciones AR <br>y códigos QR
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
				<div class="col-xs-5"></div>
				<div class="col-xs-3 alx-table-no-padding">
					<div class="alx-table-title-col">Actividad</div>
				</div>
				<div class="col-xs-2 alx-table-no-padding">
					<div class="alx-table-title-col">Descarga</div>
				</div>
				<div class="col-xs-2 alx-table-no-padding-left">
					<div class="alx-table-title-col">Link</div>
				</div>
			</div>



			<div class="row alx-table-row">
				<div class="col-xs-5">
					<div class="alx-table-icon-qr">
						<div>Landing page</div>
						<div class="alx-table-txt-min">Link web</div>
					</div>

				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					<div class="alx-table-dato">14,325</div>
					<div class="alx-table-txt-min">Views</div>
				</div>
				<div class="col-xs-2  text-center alx-table-no-padding text-center">
					<div class="alx-table-icon-descargar"></div>
				</div>
				<div class="col-xs-2  text-center alx-table-no-padding-left text-center">
					<div class="alx-table-icon-ver"></div>
				</div>
			</div>
			<div class="alx-table-row-border"></div>


			<div class="row alx-table-row">
				<div class="col-xs-5">
					<div class="alx-table-icon-img">
						<div>Familia Selfie</div>
						<div class="alx-table-txt-min">Realidad aumentada</div>
					</div>

				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					<div class="alx-table-dato">1,325</div>
					<div class="alx-table-txt-min">Views</div>
				</div>
				<div class="col-xs-2  text-center alx-table-no-padding text-center">
					<div class="alx-table-icon-descargar"></div>
				</div>
				<div class="col-xs-2  text-center alx-table-no-padding-left text-center">
					<div class="alx-table-icon-ver"></div>
				</div>
			</div>
			<div class="alx-table-row-border"></div>

			<div class="row alx-table-row">
				<div class="col-xs-5">
					<div class="alx-table-icon-geo">
						<div>Mapa virtual locales</div>
						<div class="alx-table-txt-min">Realidad aumentada GPS</div>
					</div>

				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					<div class="alx-table-dato">1,325</div>
					<div class="alx-table-txt-min">Views</div>
				</div>
				<div class="col-xs-2  text-center alx-table-no-padding text-center">
					<div class="alx-table-icon-descargar"></div>
				</div>
				<div class="col-xs-2  text-center alx-table-no-padding-left text-center">
					<div class="alx-table-icon-ver"></div>
				</div>
			</div>
			<div class="alx-table-row-border"></div>


		</div>



		<div class="row">
			<div class="col-xs-12">
				<a class="alx-btn alx-btn-cerrar" href="{{route('my-app-client.home')}}">{{ __('arcaddy.close') }}</a>
			</div>
		</div>
	</div>
</div>
@endsection
