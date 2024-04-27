@extends('my-app-client.layout')

@section('content')
<style>
#btn-nuevo-usuario{
    position: absolute;
    left: 80px;
    top: -15px;
}
#alx-ususario-totales{
    background-color: #F70BA5;
    max-width: max-content;
    padding: 5px;
    border-radius: 24px;
    line-height: 15px;
    position: absolute;
    left: 20px;
    top: 46px;
    font-size: 12px;
}
</style>
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-usuarios">
			{{ __('arcaddy.admin5') }}<br>{{ __('arcaddy.admin6') }} <div id="alx-ususario-totales">{{$usuariosTotales}}</div>
		</div>


	</div>
</div>





<div style="position: relative;">


<div class="alx-section">
	<div class="container alx-mobile">

		<div class="row alx-mb-20">
			<div class="col-xs-12">
				<form method="GET" action="{{route('my-app-client.reporte-base-usuarios')}}">
					<div class="input-container">
						<button type="submit" class="alx-btn-search"></button>
						<input class="alx-input-search" type="text" name="buscar" placeholder="{{ __('arcaddy.search') }} {{ __('Name') }} / {{ __('Email') }}" autocomplete="off" value="{{(!isset($parametros['buscar']))?'':$parametros['buscar'] }}">
					</div>
				</form>
			</div>
		</div>
		<br>


		<div class="alx-table-txt">

			<div class="row alx-table-row-title">
				<div class="col-xs-10">
					<div class="alx-table-title-col-right">{{ __('arcaddy.user') }}</div>
					<a class="alx-btn" href="{{route('registro-interno-de-usuario',$cliente_id)}}" id="btn-nuevo-usuario">{{ __('arcaddy.new') }}</a>
				</div>
				<?php /*
				<div class="col-xs-2 alx-table-no-padding">
					<div class="alx-table-title-col">ID</div>
				</div>
				<div class="col-xs-3 alx-table-no-padding">
					<div class="alx-table-title-col">Registro</div>
				</div>*/?>
				<div class="col-xs-2 alx-table-no-padding-left">
					<div class="alx-table-title-col">{{ __('arcaddy.resend') }}<br>{{ __('arcaddy.access') }}</div>
				</div>
			</div>




			@foreach($usuarios as $usuario)
			<div class="row alx-table-row">
				<div class="col-xs-10">
					{!! $usuario->name !!}
					<div class="alx-table-txt-min">
						{!! $usuario->email !!}
					</div>
					<div class="alx-table-dato-min"></div>
					<div class="alx-table-txt-min-black">

						{!! substr($usuario->created_at, 8, 2) !!}-{!! substr($usuario->created_at, 5, 2) !!}-{!! substr($usuario->created_at, 0, 4) !!}
						<br>
						{{substr($usuario->created_at, 11, 5)}}
					</div>
				</div>

				<div class="col-xs-2  text-center alx-table-no-padding-left text-center">
					<div class="alx-table-icon-reenviar btn-reenviar-acceso" data-usuarioid="{{$usuario->id}}" data-clienteid="{{$cliente_id}}"></div>
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



<div id="alx-capa-scaner">

	<div id="alx-info-scaner" class="text-center">

		<div id="alx-info-scaner-ok" class="alx-info-scaner-ocultar">
			<img src="{{asset('/images-my-app/qrok.png')}}" class="alx-info-img-scaner">
			<br>
			<div class="alx-w-extrabold alx-txt-super">¡Acceso enviado!</div>
			<br>
			<div class="alx-w-extrabold alx-txt-pink alx-txt-ch" id="alx-email-reenviado"></div>
		</div>

		<div>
			<div class="alx-btn alx-btn-cerrar" id="alx-cerrar-scaner">{{ __('arcaddy.close') }}</div>
		</div>

	</div>
</div>
</div>

<input type="hidden" id="url-ajax" value="https://ar-caddy.com/my-app-client/reenviar-acceso/">
@endsection


@section('js')
<script type="text/javascript">

	$( document ).ready(function() {

		$('#alx-cerrar-scaner').on('click', function(){

	    	$('#alx-capa-scaner').removeClass('mostrar-info-scaner');
	    	$('#alx-info-scaner-ok').addClass('alx-info-scaner-ocultar');
	        $('#alx-email-reenviado').html('');

	    });

		$('.btn-reenviar-acceso').on('click', function(){
			let usuarioid = $(this).data('usuarioid');
			let clienteid = $(this).data('clienteid');
			let route = $('#url-ajax').val();



			$.ajax({
	            url: route + clienteid +'/'+usuarioid,
	            type: 'GET',
	            dataType: 'json',
	            success: function (json) {
	                if (json.status == 'ok') {
	                 	$('#alx-info-scaner-ok').removeClass('alx-info-scaner-ocultar');
	                }
	                else{
	                	alert('Hubo un error.');
	                }

                	$('#alx-email-reenviado').html(json.email);
                	$('#alx-capa-scaner').addClass('mostrar-info-scaner');
	            },

	  			error: function( jqXHR, textStatus, errorThrown ) {

		          if (jqXHR.status === 0) {

		            alert('Not connect: Verify Network.');

		          } else if (jqXHR.status == 404) {

		            alert('Requested page not found [404]');

		          } else if (jqXHR.status == 500) {

		            alert('Internal Server Error [500].');

		          } else if (textStatus === 'parsererror') {

		            alert('Requested JSON parse failed.');

		          } else if (textStatus === 'timeout') {

		            alert('Time out error.');

		          } else if (textStatus === 'abort') {

		            alert('Ajax request aborted.');

		          } else {

		            alert('Uncaught Error: ' + jqXHR.responseText);

		          }

	        	}
	        });


		});
	});

</script>
@endsection
