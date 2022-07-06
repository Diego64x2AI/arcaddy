<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($slug = '')
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		return view('cliente', [
			'cliente' => $cliente,
		]);
	}
}
