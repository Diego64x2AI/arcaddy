<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\ClienteSucursal;
use App\Http\Requests\StoreClienteSucursalRequest;
use App\Http\Requests\UpdateClienteSucursalRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SucursalesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		$sucursales = $cliente->sucursales;
		// dd($sucursales);
		return view('dashboard.sucursales.index', compact('cliente', 'sucursales'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		return view('dashboard.sucursales.create', compact('cliente'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteSucursalRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreClienteSucursalRequest $request)
	{
		$data = $request->validated();
		$data['cliente_id'] = $cliente->id;
		$sucursal = ClienteSucursal::create($data);
		if (!is_dir(storage_path('app/public/sucursales'))) {
			File::makeDirectory(storage_path('app/public/sucursales'));
		}
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/' . $cliente->slug.'/sucursales/'.$sucursal->id, storage_path('app/public/sucursales/' . $sucursal->id . '.png'));
		// dd($data);
		return redirect()->route('cliente.sucursales.index', ['cliente' => $cliente->id])->with('success', 'Sucursal creada con éxito');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ClienteSucursal  $sucursale
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente, ClienteSucursal $sucursale)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ClienteSucursal  $sucursale
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, ClienteSucursal $sucursale)
	{
		return view('dashboard.sucursales.edit', [
			'sucursal' => $sucursale,
			'cliente' => $sucursale->cliente,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteSucursalRequest  $request
	 * @param  \App\Models\ClienteSucursal  $sucursale
	 * @return \Illuminate\Http\Response
	 */
	public function update(Cliente $cliente, UpdateClienteSucursalRequest $request, ClienteSucursal $sucursale)
	{
		$data = $request->validated();
		$sucursale->update($data);
		// dd($data);
		return redirect()->route('cliente.sucursales.index', ['cliente' => $cliente->id])->with('success', 'Sucursal actualizada con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ClienteSucursal  $sucursale
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente, ClienteSucursal $sucursale)
	{
		// delete qr code
		Storage::delete('sucursales/' . $sucursale->id . '.png');
		$sucursale->delete();
		return redirect()->route('cliente.sucursales.index', ['cliente' => $cliente->id])->with('success', 'Sucursal eliminada con éxito');
	}
}
