<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\ClienteUserField;
use App\Models\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		return view('dashboard.usuarios.index', [
			'cliente' => $cliente,
			'fields' => ClienteUserField::where('cliente_id', $cliente->id)->where('activo', 1)->get(),
			'usuarios' => User::where('cliente_id', $cliente->id)->get(),
		]);
	}
}
