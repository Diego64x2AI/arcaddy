<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PedidoProducto;

class PedidosController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard.pedidos.index', [
			'pedidos' => Pedido::paginate(20),
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Pedido  $pedido
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Pedido $pedido)
	{
		PedidoProducto::where('pedido_id', $pedido->id)->delete();
		$pedido->delete();
		return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
	}
}
