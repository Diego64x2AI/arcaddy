@extends('my-app-client.layout')



@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-redenciones">
			{{ __('arcaddy.admin1') }}<br>{{ __('arcaddy.admin2') }}
		</div>
	</div>
</div>

<div id="alx-super-cont-scaner" class="alx-back-black">
	<div class="alx-cont-scaner">
		<video id="preview"></video>
		<div class="alx-escaner-lt"></div>
		<div class="alx-escaner-rt"></div>
		<div class="alx-escaner-lb"></div>
		<div class="alx-escaner-rb"></div>
	</div>

	<div class="alx-section">
		<div class="container alx-mobile">
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
				<div class="alx-w-extrabold alx-txt-super">{{ __('arcaddy.admin7') }}</div>
				<br>
				<div class="alx-w-extrabold alx-txt-pink alx-txt-ch">{{ __('arcaddy.welcome') }}</div>
			</div>

			<div id="alx-info-scaner-no" class="alx-info-scaner-ocultar">
				<img src="{{asset('/images-my-app/qrno.png')}}" class="alx-info-img-scaner">
				<br>
				<div class="alx-w-extrabold alx-txt-super">
					{{ __('arcaddy.admin8') }}<br>{{ __('arcaddy.admin9') }}
			    </div>
				<br>
			</div>

			<div id="alx-info-scaner-no-found" class="alx-info-scaner-ocultar">
				<img src="{{asset('/images-my-app/qrno.png')}}" class="alx-info-img-scaner">
				<br>
				<div class="alx-w-extrabold alx-txt-super">
					{{ __('arcaddy.user') }}<br>{{ __('arcaddy.admin10') }}
			    </div>
				<br>
			</div>

			<div class="alx-w-extrabold" id="alx-info-scaner-nombre"></div>

			<div class="alx-txt-min" id="alx-info-scaner-correo"></div>

			<div>
				<div class="alx-btn alx-btn-cerrar" id="alx-cerrar-scaner">{{ __('arcaddy.close') }}</div>
			</div>

		</div>
	</div>
	<input type="hidden" id="url-ajax" value="https://ar-caddy.com/my-app-client/check-in-validar/">
</div>

@endsection

@section('js')
	<!--<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>-->
	<script src="{{ asset('js/instascan.min.js')}}"></script>
<script type="text/javascript">

$( document ).ready(function() {
    let scanner = new Instascan.Scanner({
    		/*video: document.getElementById('preview'),
    		scanPeriod: 5,
    		mirror: false */
             mirror: false,
    		video: document.getElementById('preview'),
    		//continuous: false,
    		scanPeriod: 5,
    		backgroundScan: false
    	});

    scanner.addListener('scan',function(content){
        //alert(content);
        //window.location.href=content;
        let route = $('#url-ajax').val();
        $.ajax({
            url: route + content,
            type: 'GET',
            dataType: 'json',
            success: function (json) {
                if (json.status == 'ok') {
                 	$('#alx-info-scaner-ok').removeClass('alx-info-scaner-ocultar');
                }
                else if(json.status == 'no'){
                	$('#alx-info-scaner-no').removeClass('alx-info-scaner-ocultar');
                }
                else{
                	$('#alx-info-scaner-no-found').removeClass('alx-info-scaner-ocultar');
                }
                $('#alx-info-scaner-nombre').html(json.nombre);
                $('#alx-info-scaner-correo').html(json.email);
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

    Instascan.Camera.getCameras().then(function (cameras){
        if(cameras.length>0){
            if(cameras.length == 2){
                scanner.start(cameras[1]);
            }
            else if(cameras.length > 2){
                scanner.start(cameras[2]);
            }
            else{
                scanner.start(cameras[0]);
            }
            $('[name="options"]').on('change',function(){
                if($(this).val()==1){
                    if(cameras[0]!=""){
                        scanner.start(cameras[0]);
                    }else{
                        alert('No Front camera found!');
                    }
                }else if($(this).val()==2){
                    if(cameras[1]!=""){
                        scanner.start(cameras[1]);
                    }else{
                        alert('No Back camera found!');
                    }
                }
            });
        }else{
            console.error('No cameras found.');
            alert('No cameras found.');
        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });

    $('#alx-cerrar-scaner').on('click', function(){
    	$('#alx-capa-scaner').removeClass('mostrar-info-scaner');
    	$('#alx-info-scaner-ok').addClass('alx-info-scaner-ocultar');
    	$('#alx-info-scaner-no').addClass('alx-info-scaner-ocultar');
    	$('#alx-info-scaner-no-found').addClass('alx-info-scaner-ocultar');
    	$('#alx-info-scaner-nombre').html('');
        $('#alx-info-scaner-correo').html('');
    });
	    /*  $('#escanear').on('click', function(){

	    	scanner.scan();
	    	alert('hola');
	    })*/
});

</script>
@endsection
