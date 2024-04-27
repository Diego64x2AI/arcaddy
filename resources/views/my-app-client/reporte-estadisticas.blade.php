@extends('my-app-client.layout')

@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-estadisticas">
			Estadísticas <br>generales
		</div>
	</div>
</div>
<div class="alx-section">
	<div class="container alx-mobile">



		<div class="alx-table-txt">



			<div class="row">
				<div class="col-xs-6">
					<div class="alx-estadistica-cuadro">
						<div class="alx-icon-estadistica icon-www"></div>
						<div class="alx-table-super-title alx-txt-pink">
							VISITAS WEB:
						</div>
						<div class="alx-table-super-title">
							13,000
						</div>
					</div>
				</div>
				<div class="col-xs-6 alx-line-v-left">
					<div class="alx-estadistica-cuadro">
						<div class="alx-icon-estadistica icon-regitros"></div>
						<div class="alx-table-super-title alx-txt-pink">
							REGISTROS:
						</div>
						<div class="alx-table-super-title">
							4,500
						</div>
					</div>
				</div>
			</div>
			<div class="alx-line-h"></div>
			<div class="row">
				<div class="col-xs-6">
					<div class="alx-estadistica-cuadro">
						<div class="alx-icon-estadistica icon-acceso"></div>
						<div class="alx-table-super-title alx-txt-pink">
							ACCESO A <br>EVENTOS:
						</div>
						<div class="alx-table-super-title">
							2,700
						</div>
					</div>
				</div>
				<div class="col-xs-6 alx-line-v-left">
					<div class="alx-estadistica-cuadro">
						<div class="alx-icon-estadistica icon-activaciones"></div>
						<div class="alx-table-super-title alx-txt-pink">
							ACTIVACIONES <br>AR/QR:
						</div>
						<div class="alx-table-super-title">
							14,600
						</div>
					</div>
				</div>
			</div>
			<div class="alx-line-h"></div>
			<div class="row">
				<div class="col-xs-6">
					<div class="alx-estadistica-cuadro">
						<div class="alx-icon-estadistica icon-canjes"></div>
						<div class="alx-table-super-title alx-txt-pink">
							CANJES EN <br>EVENTO:
						</div>
						<div class="alx-table-super-title">
							3,600
						</div>
					</div>
				</div>
				<div class="col-xs-6 alx-line-v-left">
					<div class="alx-estadistica-cuadro">
						<div class="alx-icon-estadistica icon-ganancia"></div>
						<div class="alx-table-super-title alx-txt-pink">
							RETORNO <br>CANJES:
						</div>
						<div class="alx-table-super-title">
							$116,000
						</div>
					</div>
				</div>
			</div>
			<div class="alx-line-h"></div>



			<br><br><br>



			<div class="row">
				<div class="col-xs-6">
					<div class="alx-table-super-title alx-txt-pink">
						FUENTE DE <br>TRÁFICO:
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row alx-table-row">
						<div class="col-xs-6 alx-table-dato">
							Facebook
						</div>
						<div class="col-xs-6">
							7,000
						</div>
					</div>
					<div class="row alx-table-row">
						<div class="col-xs-6 alx-table-dato">
							IG
						</div>
						<div class="col-xs-6">
							4,000
						</div>
					</div>
					<div class="row alx-table-row">
						<div class="col-xs-6 alx-table-dato">
							Búsqueda
						</div>
						<div class="col-xs-6">
							1,000
						</div>
					</div>
					<div class="row alx-table-row">
						<div class="col-xs-6 alx-table-dato">
							Mail
						</div>
						<div class="col-xs-6">
							2,000
						</div>
					</div>
					<div class="row alx-table-row">
						<div class="col-xs-6 alx-table-dato">
							Directo
						</div>
						<div class="col-xs-6">
							5,000
						</div>
					</div>
				</div>
			</div>
			<br><br>




			<div class="alx-table-row-border"></div>
			<br>

			<div class="row">
				<div class="col-xs-12">
					<div class="alx-table-super-title alx-txt-pink">
						GEO LOCALIZACIÓN/IP:
					</div>
				</div>
			</div>
			<br>

			<div class="row alx-table-row-title">
				<div class="col-xs-3">
					<div class="alx-table-title-col"></div>
				</div>
				<div class="col-xs-3  alx-table-no-padding text-center">
					<div class="alx-table-title-col-black">Visitas</div>
				</div>
				<div class="col-xs-3  alx-table-no-padding text-center">
					<div class="alx-table-title-col-black">Registro</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding-left text-center">
					<div class="alx-table-title-col-black">Activaciones</div>
					<div class="alx-table-txt-min">AR/QR</div>
				</div>
			</div>



			<div class="row alx-table-row">
				<div class="col-xs-3">
					<div class="alx-table-dato-min">Guadalajara</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3 alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3 alx-table-no-padding-left text-center">
					7,000
				</div>
			</div>
			<div class="row alx-table-row">
				<div class="col-xs-3">
					<div class="alx-table-dato-min">CDMX</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3  text-center alx-table-no-padding-left text-center">
					7,000
				</div>
			</div>
			<div class="row alx-table-row">
				<div class="col-xs-3">
					<div class="alx-table-dato-min">Yucatán</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3  text-center alx-table-no-padding-left text-center">
					7,000
				</div>
			</div>
			<div class="row alx-table-row">
				<div class="col-xs-3">
					<div class="alx-table-dato-min">Nuevo León</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3  text-center alx-table-no-padding-left text-center">
					7,000
				</div>
			</div>
			<div class="row alx-table-row">
				<div class="col-xs-3">
					<div class="alx-table-dato-min">Guadalajara</div>
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3 text-center alx-table-no-padding text-center">
					7,000
				</div>
				<div class="col-xs-3  text-center alx-table-no-padding-left text-center">
					7,000
				</div>
			</div>







		</div>



		<div class="row">
			<div class="col-xs-12">
				<a class="alx-btn alx-btn-cerrar" href="{{route('my-app-client.home')}}">{{ __('arcaddy.close') }}</a>
			</div>
		</div>
	</div>
</div>
@endsection
