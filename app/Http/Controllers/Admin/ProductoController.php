<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cliente;
use App\Models\ClienteProducto;
use App\Http\Controllers\Controller;
use App\Models\ClienteProductoBanner;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreClienteProductoRequest;
use App\Http\Requests\UpdateClienteProductoRequest;
use App\Models\ClienteProductoDigital;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		return view('dashboard.productos.create', [
			'producto' => new ClienteProducto(),
			'cliente' => $cliente,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteProductoRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreClienteProductoRequest $request)
	{
		// dd($request->all());
		$campos = $request->validated();
		$campos['cliente_id'] = $cliente->id;
		$campos['digital'] = $request->boolean('digital');
		$campos['regalado'] = $request->boolean('regalado');
		$campos['grupos'] = $request->boolean('grupos');
		// dd($campos);
		$producto = ClienteProducto::create($campos);
		// banners
		if (isset($campos['banners_img']) && count($campos['banners_img']) > 0) {
			foreach ($campos['banners_img'] as $key => $file) {
				ClienteProductoBanner::insert([
					'producto_id' => $producto->id,
					'archivo' => $file->store('clientes/banners', 'public'),
					'titulo' => $campos['banners_titulo'][$key],
				]);
			}
		}
		return redirect()->route('clientes.edit', ['cliente' => $cliente->id])->with('success', 'Producto creado correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ClienteProducto  $clienteProducto
	 * @return \Illuminate\Http\Response
	 */
	public function show(ClienteProducto $clienteProducto)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteProducto  $producto
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, ClienteProducto $producto)
	{
		return view('dashboard.productos.create', [
			'producto' => $producto,
			'cliente' => $cliente,
		]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ClienteProducto  $producto
	 * @return \Illuminate\Http\Response
	 */
	public function qrcode(ClienteProducto $producto)
	{
		$cupon = ClienteProductoDigital::create([
			'producto_id' => $producto->id,
		]);
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/digital/' . $cupon->id, storage_path('app/public/qrcodes/' . $cupon->id . '.png'));
		return view('dashboard.productos.qrcode', [
			'producto' => $producto,
			'cupon' => $cupon,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteProductoRequest  $request
	 * @param  \App\Models\ClienteProducto  $producto
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateClienteProductoRequest $request, ClienteProducto $producto)
	{
		$campos = $request->validated();
		$campos['digital'] = $request->boolean('digital');
		$campos['regalado'] = $request->boolean('regalado');
		$campos['grupos'] = $request->boolean('grupos');
		// dd($campos);
		$producto->update($campos);
		// banners
		if (isset($campos['banners_titulo']) && count($campos['banners_titulo']) > 0) {
			ClienteProductoBanner::where('producto_id', $producto->id)->delete();
			foreach ($campos['banners_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('banners_old.' . $key)) {
					$archivo = $request->input('banners_old.' . $key);
				}
				if ($request->hasFile('banners_img.' . $key) && $request->file('banners_img.' . $key)->isValid()) {
					Storage::delete($request->input('banners_old.' . $key));
					$archivo = $request->file('banners_img.' . $key)->store('clientes/banners', 'public');
				}
				ClienteProductoBanner::insert([
					'producto_id' => $producto->id,
					'archivo' => $archivo,
					'titulo' => $campos['banners_titulo'][$key],
				]);
			}
		}
		return redirect()->route('clientes.edit', ['cliente' => $producto->cliente_id])->with('success', 'Producto editado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ClienteProducto  $producto
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ClienteProducto $producto)
	{
		// dd($producto);
		foreach ($producto->imagenes as $imagen) {
			Storage::delete($imagen->archivo);
		}
		ClienteProductoBanner::where('producto_id', $producto->id)->delete();
		$producto->delete();
		return redirect()->route('clientes.edit', ['cliente' => $producto->cliente_id])->with('success', 'Producto eliminado correctamente.');
	}
}
