<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClienteMarcoGaleria;
use App\Models\ClienteProducto;
use App\Models\ClienteSucursal;
use App\Models\Juego;
use App\Models\JuegoResultado;
use App\Models\ProductoCanjeado;
use App\Models\QRLink;
use App\Models\RealidadAumentada;
use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\DB;

class ClienteEstadisticas extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente, Request $request)
	{
		$visitas = Visita::select('id', 'url', 'cliente_id', 'model', 'model_id', DB::raw('count(*) as total'))->where('cliente_id', $cliente->id)->groupBy('url')->orderBy('total', 'desc')->take(10)->get();
		$qrlinks = QRLink::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$realidades = RealidadAumentada::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$sucursales = ClienteSucursal::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$marcos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->inRandomOrder()->take(9)->get();
		$marcos_compartidos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->where('compartida', 1)->count();
		$marcos_subidos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->count();
		$totales = [
			'visitas' => Visita::where('cliente_id', $cliente->id)->count(),
			'usuarios' => User::where('cliente_id', $cliente->id)->count(),
			'redenciones' => ProductoCanjeado::where('cliente_id', $cliente->id)->count(),
			'productos' => ClienteProducto::where('cliente_id', $cliente->id)->count(),
		];
		$juegos = Juego::where('cliente_id', $cliente->id)->where('activo', 1)->get();
		$games = [];
		foreach ($juegos as $juego) {
			$games[] = [
				'id' => $juego->id,
				'nombre' => $juego->nombre,
				'visitas' => Visita::where('cliente_id', $cliente->id)->where('model', '\App\Models\Juego')->where('model_id', $juego->id)->count(),
				'scores' => JuegoResultado::where('juego_id', $juego->id)->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->take(10)->get(),
			];
		}
		// dd($games);
		return view('dashboard.estadisticas.index', compact('cliente', 'totales', 'games', 'visitas', 'qrlinks', 'realidades', 'sucursales', 'marcos', 'marcos_compartidos', 'marcos_subidos'));
	}
}
