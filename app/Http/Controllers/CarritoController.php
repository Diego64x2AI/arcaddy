<?php

namespace App\Http\Controllers;

use App\Models\ClienteProducto;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use App\Notifications\PedidoCreado;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
	/**
	 * Completar pago del carrito de compras.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function pagar()
	{
		$carrito = \Cart::getContent();
		return view('pagar', [
			'carrito' => $carrito,
		]);
	}

	/**
	 * add a producto.
	 *
	 * @param  \App\Models\ClienteProducto  $producto
	 * @return \Illuminate\Http\Response
	 */
	public function agregar(ClienteProducto $producto)
	{
		// dd($producto);
		$precio = $producto->precio;
		if ($producto->descuento > 0 && !$producto->digital) {
			$precio = $producto->precio - ($producto->precio * ($producto->descuento / 100));
		}
		\Cart::add([
			'id' => $producto->id,
			'name' => $producto->nombre,
			'price' => $precio,
			'quantity' => 1,
			'attributes' => [
				'imagen' => $producto->imagenes[0]->archivo,
				'descuento' => $producto->descuento,
				'cliente_id' => $producto->cliente_id,
				'slug' => $producto->cliente()->first()->slug,
			],
		]);
		return redirect()->route('carrito')->with('success', 'Producto agregado al carrito');
	}

	/**
	 * delete a producto.
	 *
	 * @param  \App\Models\ClienteProducto  $producto
	 * @return \Illuminate\Http\Response
	 */
	public function eliminar(ClienteProducto $producto)
	{
		\Cart::remove($producto->id);
		return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito');
	}

	public function carrito()
	{
		// \Cart::clear();
		$carrito = \Cart::getContent();
		// dd($carrito);
		return view('carrito', [
			'carrito' => $carrito,
		]);
	}

	public function actualizar(Request $request)
	{
		$carrito = \Cart::getContent();
		foreach ($carrito as $item) {
			$cantidad = (int) $request->input('cantidad.' . $item->id);
			if ($cantidad > 0) {
				\Cart::update($item->id, [
					'quantity' => [
						'relative' => false,
						'value' => $cantidad,
					],
				]);
			} else {
				\Cart::remove($item->id);
			}
		}
		return redirect()->route('carrito')->with('success', 'Carrito actualizada');
	}

	public function gracias()
	{
		return view('gracias');
	}

	public function charge(Request $request)
	{
		$request->validate([
			'payment_id' => 'required|string',
		]);
		if (\Cart::isEmpty()) {
			return response()->json([
				'result' => false,
				'message' => 'Tu carrito está vacío',
			], 500);
		}
		$user = auth()->user();
		$carrito = \Cart::getContent();
		$total = 0;
		foreach ($carrito as $item) {
			$total += ($item->price * $item->quantity);
		}
		try {
			$stripeCharge = $request->user()->charge($total * 100, $request->payment_id);
			$pedido = Pedido::create([
				'payment_id' => $stripeCharge->id,
				'status' => $stripeCharge->status,
				'user_id' => $user->id,
				'total' => $total,
				'recibido' => $stripeCharge->amount_received / 100,
				'envio' => 0,
				'payed_at' => now(),
				'direccion' => null,
				'response' => serialize($stripeCharge),
			]);
			foreach($carrito as $item) {
				PedidoProducto::create([
					'pedido_id' => $pedido->id,
					'producto_id' => $item->id,
					'cantidad' => $item->quantity,
					'precio' => $item->price,
				]);
			}
			$user->notify(new PedidoCreado(Pedido::find($pedido->id)));
			return response()->json([
				'result' => true,
				'message' => 'El pago se ha realizado correctamente, pronto enviaremos tu pedido.',
			]);
			// dd($stripeCharge);
		} catch (\Exception $e) {
			return response()->json([
				'result' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}
}
