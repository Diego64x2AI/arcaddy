<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style>
#preview{
   width:500px;
   height: 500px;
   margin:0px auto;
}
</style>
</head>
<body>

<div>
	<video id="preview"></video>
</div>

<script src="{{ asset('alx-jquery.js')}}"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script type="text/javascript">
    
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
        alert(content);
        //window.location.href=content;
    });
    
    Instascan.Camera.getCameras().then(function (cameras){
        if(cameras.length>0){
            scanner.start(cameras[0]);
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


   /* $( document ).ready(function() {
	    
	    $('#escanear').on('click', function(){
	    	
	    	scanner.scan();
	    	alert('hola');
	    })
	});*/






     
</script>

<div id="escanear">ESCANER</div>
<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
  </label>
</div>


</body>
</html>