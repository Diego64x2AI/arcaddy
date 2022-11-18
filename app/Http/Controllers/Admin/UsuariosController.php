<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\ClienteUserField;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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

	public function export(Cliente $cliente)
	{
		// dd($cliente);
		return Excel::download(new UsersExport($cliente), 'usuarios.xlsx');
	}
}
