<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center">
			<div>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Editar {{$juego->nombre}}
				</h2>
			</div>
		</div>
	</x-slot>
	
	
	 <form id="image-form" method="POST" action="{{route('games.update',$juego->id)}}" enctype="multipart/form-data">

    @csrf
     @method('PUT')
     <input type="hidden" name="juegoid" value="{{$juego->id}}">
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100">
            <div class="flexd">
                <!-- Primera Columna -->
                <div class="">
                    <div class="p-3 mt-3" style="max-width: 400px;">
                        
                        

                        <input type="hidden" name="categoria_id" value="{{$juego->juego_categoria_id}}">
                        
                         <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            URL
                        </label>
                        <a href="{{route('cliente.start-game',[$juego->cliente_id, $juego->clave])}}" target="_blank">
                        {{route('cliente.start-game',[$juego->cliente->slug, $juego->clave])}}</a><br><br>

                        <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            Cliente
                        </label>
                        <select name="cliente_id" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6">
                            <option value="">Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{$cliente->id}}" 
                                    {{($juego->cliente_id == $cliente->id)?'selected':''}}>{{$cliente->cliente}} </option>
                            @endforeach
                        </select>

                        <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            Nombre
                        </label>
                         <input value="{{$juego->nombre}}" type="text" name="nombre" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6" required>

                        <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            Descripción
                        </label>
                         <textarea name="descripcion" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6" required>{{$juego->descripcion}}</textarea>

                        <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            Activo
                        </label>
                        <select name="estatus" class="shadow appearance-none border-0 w-full py-2 px-3 text-gray-700 mb-6">
                            <option value="1" {{($juego->activo == 1)?'selected':''}}>Si</option>
                            <option value="0" {{($juego->activo == 0)?'selected':''}}>No</option>
                        </select>

                    </div>
               <?php /* </div>

                <!-- Segunda Columna -->
                <div class="w-full md:w-1/2 px-3 mb-6">*/?>
                    <div class="p-3 mt-3">
                        <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            Cartas
                             <div class="aviso-cartas" id="aviso-cartas-front">Debes guardar para que se reflejen los cambios.</div>
                        </label>
                        
                         <div class="cartas-actuales">
                            
                            @foreach($cartas as $c)
                                <div class="carta" style="background-image: url({{ asset('storage/clientes/games/memory/'.$c->imagen) }});"> 
                                 <div class="carta-delete" data-id="{{$c->id}}" data-aviso="front">X</div>
                                 </div>
                            @endforeach
                            
                            <div class="cartaBase"></div>
                           
                        </div><br>
                        
                        <div id="preview-container"></div>
                        <input type="file" id="image-input" name="images[]" multiple accept="image/*">
                        <br><br><br>
                        
                        
                        <label class="block tracking-wide text-gray-700 text-xl font-bold mb-2" for="slug">
                            Carta vista back
                            <div class="aviso-cartas" id="aviso-cartas-back">Debes guardar para que se reflejen los cambios.</div>
                        </label>
                        
                        
                        <div class="cartas-actuales">
                            
                            @foreach($cartasBack as $c)
                                <div class="carta" style="background-image: url({{ asset('storage/clientes/games/memory/'.$c->imagen) }});"> 
                                <div class="carta-delete" data-id="{{$c->id}}" data-aviso="back">X</div>
                                
                                </div>
                            @endforeach
                            
                            <div class="cartaBase"></div>
                           
                        </div><br>
                        
                        
                        
                        
                        <div id="preview-container-imageback"></div>
                        <input type="file" id="imageback" name="imageback[]" multiple accept="image/*">
                        <br><br><br>
                        
                        <button type="submit" class="bg-pink-600 text-white px-5 py-2 rounded-md">Guardar</button>
                        
                        
                        <br><br><br>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="" id="cartas-borradas" name="borradas">
</form>


	
	
</x-app-layout>
<style>
    #preview-container {
      display: flex;
      flex-wrap: wrap;
    }

    #preview-container img {
      max-width: 100px;
      max-height: 100px;
      margin: 5px;
    }
    #preview-container-imageback {
      display: flex;
      flex-wrap: wrap;
    }

    #preview-container-imageback img {
      max-width: 100px;
      max-height: 100px;
      margin: 5px;
    }
    
    .carta{
        background-size: cover;
        background-position: center;
        height: 150px;
        width: 100px;
        display: block;
        float: left;
        margin-right: 10px;
        position: relative;
    }
    .cartaBase{
        clear: both;
    }
    .carta-delete{
        cursor: pointer;
        position: absolute;
        width: 30px;
        height: 30px;
        background-color: #ff0000;
        text-align: center;
        line-height: 30px;
        color: #FFFFFF;
        top: 0px;
        right: 0px;
    }
    .aviso-cartas{
        color: #FFFFFF;
        background-color: #ff0000;
        padding: 10px;
        display: none;
    }
  </style>
<?php /*<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>*/?>
<script src="{{ asset('build/assets/jquery-3.6.4.min.js') }}"></script>
  
<script>
$(document).ready(function () {
    
    
    $('.carta-delete').on('click', function(){
        let cb = $('#cartas-borradas').val();
        
        
        $('#cartas-borradas').val(cb+''+$(this).data('id')+',');
        
       $(this).parent().remove();
       
       
       $('#aviso-cartas-'+$(this).data('aviso')).fadeIn();
    });
    
    
    
    
  // Función para manejar la carga de imágenes
  window.uploadImages = function () {
    var formData = new FormData($('#image-form')[0]);

    $.ajax({
      url: 'upload.php', // Cambia esto al archivo PHP que manejará la carga de imágenes
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        // Puedes manejar la respuesta del servidor aquí
        console.log(data);
      },
      error: function (error) {
        console.error('Error en la carga de imágenes:', error);
      }
    });
  };

  // Función para mostrar la vista previa de las imágenes seleccionadas
  $('#image-input').on('change', function () {
    var files = this.files;
    var previewContainer = $('#preview-container');
    previewContainer.empty();

    for (var i = 0; i < files.length; i++) {
      var reader = new FileReader();

      reader.onload = function (e) {
        previewContainer.append('<img src="' + e.target.result + '">');
      };

      reader.readAsDataURL(files[i]);
    }
  });
  
  
  $('#imageback').on('change', function () {
    var files = this.files;
    var previewContainer = $('#preview-container-imageback');
    previewContainer.empty();

    for (var i = 0; i < files.length; i++) {
      var reader = new FileReader();

      reader.onload = function (e) {
        previewContainer.append('<img src="' + e.target.result + '">');
      };

      reader.readAsDataURL(files[i]);
    }
  });
  
  
});

</script>
