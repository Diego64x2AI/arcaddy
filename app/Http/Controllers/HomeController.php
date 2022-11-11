<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteProductoDigital;
use Illuminate\Http\Request;

class HomeController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('welcome');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cliente($slug = '')
	{
		$cliente = Cliente::where('slug', $slug)->firstOrFail();
		return view('cliente', [
			'cliente' => $cliente,
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function registro(Cliente $cliente)
	{
		return view('registro', [
			'cliente' => $cliente,
		]);
	}

	/**
	 * Show the form reedem cuopons.
	 *
	 * @param  \App\Models\ClienteProducto  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function digital(ClienteProductoDigital $cupon)
	{
		// dd($cupon);
		return view('digital', [
			'cupon' => $cupon,
		]);
	}

	/**
	 * Show the share reedem cuopons.
	 *
	 * @param  \App\Models\ClienteProducto  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function digital_share(ClienteProductoDigital $cupon)
	{
		// dd($cupon);
		return view('digital_share', [
			'cupon' => $cupon,
		]);
	}

	/**
	 * reedem cuopons.
	 *
	 * @param  \App\Models\ClienteProducto  $cupon
	 * @return \Illuminate\Http\Response
	 */
	public function canjear(ClienteProductoDigital $cupon)
	{
		$cupon->update([
			'canjeado' => true,
			'canjeado_at' => now(),
		]);
		return redirect()->back()->with('success', 'Cupón canjeado con éxito');
	}
}
