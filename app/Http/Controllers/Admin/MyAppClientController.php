<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserQr;
use App\Models\User;
use App\Models\Cliente;
use App\Models\ClienteProducto;
use App\Models\ProductoCanjeado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\RegistroCodigo;

class MyAppClientController extends Controller
{
    public function home()
    {
       
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.home', compact('clientedatos'));
    }

    public function homeEscaner()
    {
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.escaner', compact('clientedatos'));
    }

    public function homeQr()
    {
        
        echo QrCode::format('png')
        ->size(500)
        ->margin(1)
        ->color(0,0,0)
        ->backgroundColor(255,255,255)
        ->merge('/public/images/qr-logo.png', .3)
        ->errorCorrection('H')
        ->generate('www.nigmacode.com', public_path('storage/qrregister/alex3.png'));


        //https://www.simplesoftware.io/#/docs/simple-qrcode

        /*echo public_path('storage/qrcodes/alex2.png');
        echo '<br>';
        echo storage_path('app/public/qrcodes');*/

        //storage_path('app/public/qrcodes/' . $cliente->slug . '.png')

        //QrCode::color(255,0,255); //Cambia el color de nuestro codigo
        //QrCode::backgroundColor(255,255,0); //Le añade el color al background del codigo
        //QrCode::margin(100); //Le añade la propiedad margin al codigo
        // /var/www/html/storage/app/public/qrcodes
        /*
        // Path to the project's root folder    
            echo base_path();

            // Path to the 'app' folder    
            echo app_path();        

            // Path to the 'public' folder    
            echo public_path();

            // Path to the 'storage' folder    
            echo storage_path();

            // Path to the 'storage/app' folder    
            echo storage_path('app');
        */
    }

    public function checkIn()
    {
        /*return view('my-app-client.check-in');*/
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.check-in2', compact('clientedatos'));
    }
    
    public function checkIn2()
    {
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.check-in2', compact('clientedatos'));
    }

    public function checkInValidar($codigo){

        $codigo = UserQr::where('codigo',$codigo)->first();

        if($codigo){

            if($codigo->usado == 0){

                $codigo->usado = 1;
                $codigo->save();

                return response([ 
                    'status' => 'ok',
                    'nombre' => $codigo->user->name,
                    'email' => $codigo->user->email,
                ]);

            }
            else{
                return response([ 
                    'status' => 'no',
                    'nombre' => $codigo->user->name,
                    'email' => $codigo->user->email,
                ]);
            }

        }
        else{ /*No exixte en la BD*/
            return response([ 
                'status' => 'no found',
                'nombre' => '',
                'email' => '',
            ]);
        }

         
    }

    public function reporteActivaciones()
    {
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.reporte-activaciones', compact('clientedatos'));
    }

    public function reporteRedenciones()
    {
        
        //echo Auth::user()->name

        $parametros = NULL;

        if( !isset($_GET['buscar']) ){

             $productos = ClienteProducto::where('cliente_id',auth()->user()->cliente_id)
            ->where('regalado',1)
            ->get();

        }
        else{

            $parametros['buscar'] = $_GET['buscar'];

            $productos = ClienteProducto::where('cliente_id',auth()->user()->cliente_id)
            ->where('regalado',1)
            ->where('nombre','like','%'.$_GET['buscar'].'%')
            ->get();

        }

   

        
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.reporte-redenciones',compact('productos','parametros','clientedatos'));
    }

    public function productoRedencion($producto_id){
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.producto-redencion2', compact('clientedatos','producto_id'));
    }

    public function productoRedencionValidar($codigo, $producto_id, $usuario_id){


        $codigoExiste = ProductoCanjeado::where('codigo',$codigo)
            ->where('producto_id',$producto_id)
            ->first();

        $usuario = User::find($usuario_id);

        $producto = ClienteProducto::where('id',$producto_id)
            ->where('regalado',1)
            ->first();

        if($producto){

            if($codigoExiste){

                return response([ 
                    'status' => 'no',
                    'nombre' => $usuario->name,
                    'nombre_producto' => $producto->name,
                ]);
                

            }
            else{ 

                $canje = ProductoCanjeado::create([
                    'cliente_id' => $producto->cliente_id,
                    'user_id' => $usuario->id,
                    'evento_id' => 1,
                    'codigo' => $codigo,
                    'producto_id'  => $producto_id,
                ]);



                return response([ 
                    'status' => 'ok',
                    'nombre' => $usuario->name,
                    'nombre_producto' => $producto->name,
                    'precio_producto' => $producto->precio,
                    'img_producto' => asset('storage/'.$producto->imagenes[0]->archivo)
                ]);
            }
        }
        else{
            return response([ 
                    'status' => 'no found',
                    'nombre' => $usuario->name
                ]);
        }
        
    }

    public function reporteBaseUsuarios()
    {
        $parametros = NULL;

        if( !isset($_GET['buscar']) ){

             $usuarios = DB::table('users')
                ->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
                ->where('cliente_id', auth()->user()->cliente_id)
                ->where('role_id', 3)
                ->get();

        }
        else{

            $parametros['buscar'] = $_GET['buscar'];

            $usuarios = DB::table('users')
                ->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
                ->where('cliente_id', auth()->user()->cliente_id)
                ->where('role_id', 3)
                ->where(function ($query) {
                        $query->where('name', 'like', '%'.$_GET['buscar'].'%')
                              ->orWhere('email','like', '%'.$_GET['buscar'].'%');
                    })
                ->get();

        }

        $cliente_id = auth()->user()->cliente_id;
        
       
        
        $usuariosTotales = DB::table('users')
                ->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
                ->where('cliente_id', auth()->user()->cliente_id)
                ->where('role_id', 3)
                ->count();

        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.reporte-base-usuarios', compact('usuarios','parametros','cliente_id','clientedatos','usuariosTotales'));
    }


    public function reenviarAcceso($clienteid, $usuarioid){

        $user = User::find($usuarioid);
        $cliente = Cliente::find($clienteid);
        $userQr = UserQr::where('cliente_id',$clienteid)
            ->where('user_id',$user->id)
            ->first();

        try {
                $user->notify(new RegistroCodigo($user, $cliente, $userQr->codigo));
            } catch(\Exception $e) {
            }

        return response([ 
                    'status' => 'ok',
                    'email' => $user->email
                ]);
    }



    public function reporteEstadisticas()
    {
        $clientedatos = Cliente::find(auth()->user()->cliente_id);
        return view('my-app-client.reporte-estadisticas', compact('clientedatos'));
    }
    
}
