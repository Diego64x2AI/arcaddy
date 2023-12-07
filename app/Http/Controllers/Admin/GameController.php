<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Juego;
use App\Models\JuegoCarta;
use App\Models\JuegoCategoria;
use App\Models\JuegoResultado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GameController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	    
	    $clientes = Cliente::orderBy('cliente')->get();
	    
	    $juegoCategorias = JuegoCategoria::where('borrado',0)->orderBy('nombre')->get();
	    
	    $juegos = Juego::where('borrado',0)->orderBy('id','DESC')->paginate(20);
	    
	    $parametros = NULL;
		/*
		


		

		if( isset($_GET['cliente']) ){

			$parametros['cliente'] = $_GET['cliente'];

			$usuarios = DB::table('users')
				->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
				->where('cliente_id',$parametros['cliente'])
				->where('role_id',2)
				->get();
		}*/

		
		return view('dashboard.games.index', compact(
			'clientes',
			'juegoCategorias',
			'juegos',
			'parametros'));
		
	}

	public function create(Request $request)
    {
        $cat = $request->query('cat');
        
        $clientes = Cliente::orderBy('cliente')->get();
	    
	    $juegoCategoria = JuegoCategoria::find($cat);
	    
	    
	    if(!$juegoCategoria){
	         return redirect()->route('games.index');
	    }

    	return view('dashboard.games.nuevo', compact('clientes','juegoCategoria'));
    }

    public function store(Request $request)
    { 
		
		$juegof = new Juego();
		$juegof->juego_categoria_id = $request->categoria_id;
		$juegof->cliente_id = $request->cliente_id;
		$juegof->nombre = $request->nombre;
		$juegof->descripcion = $request->descripcion;
		$juegof->activo = $request->estatus;
		$juegof->save();
		
		$caracteresPermitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cadenaAleatoria = substr(str_shuffle($caracteresPermitidos), 0, 10);
        $juegof->clave = 'gm'.$juegof->id.$cadenaAleatoria;
		$juegof->save();
		
		if ($request->hasFile('images')) {
	        
	        
	        foreach($request->file('images') as $key => $file){
	            
	            $imagen = $file;
                $imagenNombre = $imagen->getClientOriginalName();
                $extension = $imagen->getClientOriginalExtension();
                
				
				$carta = new JuegoCarta();
				$carta->juego_id = $juegof->id;
				$carta->imagen = 'generica.png';
				$carta->frente = 1;
				$carta->save();
				
				
                
                $nuevoNombre = 'card-'.$juegof->id.'-'.$carta->id.'.'.$extension;
                $carta->imagen = $nuevoNombre;
                $carta->save();
                
                $ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
	            
	        }
	    }
	    
	    if ($request->hasFile('imageback')) {
	        
	        
	        foreach($request->file('imageback') as $key => $file){
	            
	            $imagen = $file;
                $imagenNombre = $imagen->getClientOriginalName();
                $extension = $imagen->getClientOriginalExtension();
                
				
				$carta = new JuegoCarta();
				$carta->juego_id = $juegof->id;
				$carta->imagen = 'generica.png';
				$carta->frente = 0;
				$carta->save();
				
				
                
                $nuevoNombre = 'card-'.$juegof->id.'-'.$carta->id.'-back.'.$extension;
                $carta->imagen = $nuevoNombre;
                $carta->save();
                
                $ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
	            
	        }
	    }
	
		$mensaje = 'El juego ha sido creado.';

		return redirect()->route('games.index')->with('success',$mensaje);
		
    }

    public function show()
    {   

    }

    public function edit($id)
    {
        
        $clientes = Cliente::orderBy('cliente')->get();
	    
	    $juego = Juego::find($id);
	    
	    $cartas = JuegoCarta::where('juego_id',$juego->id)->where('frente',1)->where('borrado',0)->get();
	    
	    $cartasBack = JuegoCarta::where('juego_id',$juego->id)->where('frente',0)->where('borrado',0)->get();
	    
	    
	    if(!$juego){
	         return redirect()->route('games.index');
	    }
    	

    	return view('dashboard.games.editar', compact('juego','clientes','cartas','cartasBack'));
    }

    public function update(Request $request)
    {

    	$juegof = Juego::find($request->juegoid);

    	$juegof->update([
			'cliente_id' => $request->cliente_id,
			'nombre' => $request->nombre,
			'descripcion' => $request->descripcion,
			'activo' => $request->estatus,
	    ]);
	    
	    
	    if($request->borradas != ''){
	        $borrar = explode(",", $request->borradas);
	        
	        
	        foreach($borrar as $b){
	            $registroAEliminar = JuegoCarta::find($b);
	            
                if ($registroAEliminar) {
                  $registroAEliminar->borrado = 1;
                  $registroAEliminar->save();
                    
                } 
	        }
	        
	    }
	    
	    
	    
	    if ($request->hasFile('images')) {
	        
	        
	        foreach($request->file('images') as $key => $file){
	            
	            $imagen = $file;
                $imagenNombre = $imagen->getClientOriginalName();
                $extension = $imagen->getClientOriginalExtension();
                
				
				$carta = new JuegoCarta();
				$carta->juego_id = $juegof->id;
				$carta->imagen = 'generica.png';
				$carta->frente = 1;
				$carta->save();
				
				
                
                $nuevoNombre = 'card-'.$juegof->id.'-'.$carta->id.'.'.$extension;
                $carta->imagen = $nuevoNombre;
                $carta->save();
                
                $ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
	            
	        }
	    }
	    
	    
	     if ($request->hasFile('imageback')) {
	        
	       
	        foreach($request->file('imageback') as $key => $file){
	            
	             
	            
	            $imagen = $file;
                $imagenNombre = $imagen->getClientOriginalName();
                $extension = $imagen->getClientOriginalExtension();
                
				
				$carta = new JuegoCarta();
				$carta->juego_id = $juegof->id;
				$carta->imagen = 'generica.png';
				$carta->frente = 0;
				$carta->save();
				
				
                
                $nuevoNombre = 'card-'.$juegof->id.'-'.$carta->id.'-back.'.$extension;
                $carta->imagen = $nuevoNombre;
                $carta->save();
                
                $ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
	            
	        }
	    }
	    
	    
	    /*if (isset($campos['banners_img']) && count($campos['banners_img']) > 0) {
			ClienteBanner::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['banners_img'] as $key => $file) {
				ClienteBanner::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/banners', 'public'),
					'titulo' => $campos['banners_titulo'][$key],
					'link' => $campos['banners_link'][$key],
				]);
			}
		}*/
	    
	    
	    /*if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
             // $uploadsDir = 'uploads/'; // Directorio donde se almacenarán las imágenes
             
             dd($_FILES['images']['tmp_name']);
            
              foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                  
                  
                $uploadFile = $uploadsDir . basename($_FILES['images']['name'][$key]);
            
                if (move_uploaded_file($tmp_name, $uploadFile)) {
                  echo 'Imagen subida con éxito: ' . $uploadFile . '<br>';
                } else {
                  echo 'Error al subir la imagen: ' . $_FILES['images']['error'][$key] . '<br>';
                }
              }
        }*/
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    

	  
	    return redirect()->route('games.index')->with('success','El juego ha sido actualziado.');
    }

    public function destroy()
    {
        
        /*dd('hola');
         $juego = Juego::find($id);
         
         if($juego){
             $juego->borrado = 1;
             $juego->save();
         }
         
         return redirect()->route('games.index')->with('success','El juego ha sido eliminado.');*/
    }
    
    public function borrar($id)
    {
        
        
         $juego = Juego::find($id);
         
         if($juego){
             $juego->borrado = 1;
             $juego->save();
         }
         
         return redirect()->route('games.index')->with('success','El juego ha sido eliminado.');
    }



}