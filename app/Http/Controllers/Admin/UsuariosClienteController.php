<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosClienteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$usuarios = [];
		$clientes = Cliente::orderBy('cliente')->get();


		$parametros = NULL;

		if( isset($_GET['cliente']) ){

			$parametros['cliente'] = $_GET['cliente'];

			$usuarios = DB::table('users')
				->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
				->where('cliente_id',$parametros['cliente'])
				->where('role_id',2)
				->get();
		}

		
		return view('dashboard.usuarios-cliente.index', compact(
			'usuarios',
			'clientes',
			'parametros'));
		
	}

	public function create()
    {
    	$clientes = Cliente::orderBy('cliente')->get();

    	return view('dashboard.usuarios-cliente.nuevo', compact('clientes'));
    }

    public function store(Request $request)
    { 

	    $user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'cliente_id' => $request->cliente_id,
			'password' => Hash::make($request->password),
		]);
		$user->assignRole('client');

		$mensaje = 'El Usuario ha sido creado.';

		return redirect()->route('usuarios-cliente.index',['cliente' => $request->cliente_id])->with('success',$mensaje);
		
    }

    public function show()
    {   

    }

    public function edit($id)
    {
    	$clientes = Cliente::orderBy('cliente')->get();
        $usuario = User::find($id);

    	return view('dashboard.usuarios-cliente.editar', compact('usuario','clientes'));
    }

    public function update(Request $request, User $usuario)
    {

    	$usuariof = User::find($request->usuarioid);

    	$usuariof->update([
	        'name' => $request->name,
			'email' => $request->email,
			'cliente_id' => $request->cliente_id,
	    ]);



	    if($request->password != ''){

	    	$usuariof->update([
	    		'password' => Hash::make($request->password)
	    	]);
	    }

	    //return redirect()->back()->with('success', 'El usuario ha sido actualziado.');

	    return redirect()->route('usuarios-cliente.index',['cliente' => $request->cliente_id])->with('success','El usuario ha sido actualziado.');
    }

    public function destroy()
    {
        
    }



}