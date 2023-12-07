@extends('my-app-client.layout')



@section('content')
<div class="alx-section-title">
	<div class="alx-mobile-int">
		<div class="alx-section-title-txt" id="alx-title-redenciones">
			Canje <br> de producto 
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
					<a class="alx-btn alx-btn-cerrar" href="{{route('my-app-client.reporte-redenciones')}}">CERRAR</a>
				</div>
			</div>
		</div>
	</div>

	<div id="alx-capa-scaner">
	
		<div id="alx-info-scaner" class="text-center">
			
			<div id="alx-info-scaner-ok" class="alx-info-scaner-ocultar">
				<img src="{{asset('/build/assets/images-my-app/qrok.png')}}" class="alx-info-img-scaner">
				<br>
				<div class="alx-w-extrabold alx-txt-super">Canje exitoso!</div>
				<br>
				<img src="{{asset('/build/assets/images-my-app/qrno.png')}}" class="alx-info-img-scaner" id="alx-info-scaner-img-prodcuto">
				
			
				<div class="alx-w-extrabold alx-txt-pink alx-txt-ch" id="alx-info-scaner-nombre-producto"></div>
				<div class="alx-w-extrabold" id="alx-info-scaner-precio-producto"></div>
			</div>

			<div id="alx-info-scaner-no" class="alx-info-scaner-ocultar">
				<img src="{{asset('/build/assets/images-my-app/qrno.png')}}" class="alx-info-img-scaner">
				<br>
				<div class="alx-w-extrabold alx-txt-super">
					Ya canjeaste<br> este beneficio
			    </div>
				<br>
			</div>

			

			<div class="alx-w-extrabold" id="alx-info-scaner-nombre"></div>
			
			<div>
				<div class="alx-btn alx-btn-cerrar" id="alx-cerrar-scaner">CERRAR</div>
			</div>

		</div>
	</div>
	<input type="hidden" id="url-ajax" value="https://ar-caddy.com/my-app-client/producto-redencion-validar/">
	<input type="hidden" id="productoid" value="{!! $producto_id !!}">

</div>

@endsection

@section('js')
	<!--<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>-->

	<script src="{{ asset('/build/assets/instascan.min.js')}}"></script>

<script type="text/javascript">

$( document ).ready(function() { 
    
    let scanner = new Instascan.Scanner({ 
            mirror: false,
    		/*video: document.getElementById('preview'), 
    		scanPeriod: 5, 
    		mirror: false */

    		video: document.getElementById('preview'), 
    		//continuous: false,
    		scanPeriod: 5,
    		backgroundScan: false

    	});

    scanner.addListener('scan',function(content){
        //alert(content);
        //window.location.href=content;

        let route = $('#url-ajax').val();
        let arr = content.split('-'); 


       

      
       
        
        $.ajax({
            url: route + content+'/'+$('#productoid').val()+'/'+arr[2],
            type: 'GET',
            dataType: 'json',
            success: function (json) {
                if (json.status == 'ok') {
                 	$('#alx-info-scaner-ok').removeClass('alx-info-scaner-ocultar');
                 	$('#alx-info-scaner-nombre-producto').html(json.nombre_producto);
                 	
                 	if(json.precio_producto != '0'){
                 	    	$('#alx-info-scaner-precio-producto').html(json.precio_producto);
                 	}
                 	else{
                 	    	$('#alx-info-scaner-precio-producto').html('');
                 	}
                 
                 	
                 	$('#alx-info-scaner-img-prodcuto').attr('src', json.img_producto);
                }
                else{
                	$('#alx-info-scaner-no').removeClass('alx-info-scaner-ocultar');
                }
                $('#alx-info-scaner-nombre').html(json.nombre);
                
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
    	$('#alx-info-scaner-nombre').html('');
        
    });


  
	    
	    /*  $('#escanear').on('click', function(){
	    	
	    	scanner.scan();
	    	alert('hola');
	    })*/
});
     
</script>
@endsection