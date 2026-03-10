<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use App\Models\Cliente;
use App\Models\ClienteRally;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClienteRallyUbicacion;
use App\Models\ClienteRallySucursal;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreClienteRallyRequest;
use App\Http\Requests\UpdateClienteRallyRequest;

class RallyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		$rallys = ClienteRally::where('cliente_id', $cliente->id)->withCount('ubicaciones')->orderBy('id', 'desc')->get();
		return view('dashboard.rally.index', compact('cliente', 'rallys'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		return view('dashboard.rally.create', compact('cliente'))
			->with('sucursales', $cliente->sucursales);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteRally  $rally
	 * @return \Illuminate\Http\Response
	 */
	public function markers(Cliente $cliente, ClienteRally $rally)
	{
		return view('dashboard.rally.markers', compact('cliente', 'rally'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteRally  $rally
	 * @return \Illuminate\Http\Response
	 */
	public function marker_create(Cliente $cliente, ClienteRally $rally)
	{
		return view('dashboard.rally.marker_create', compact('cliente', 'rally'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteRally  $rally
	 * @param  \App\Models\ClienteRallyUbicacion  $ubicacion
	 * @return \Illuminate\Http\Response
	 */
	public function marker_edit(Cliente $cliente, ClienteRally $rally, ClienteRallyUbicacion $ubicacion)
	{
		return view('dashboard.rally.marker_edit', compact('cliente', 'rally', 'ubicacion'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Http\Requests\StoreClienteRallyRequest  $request
	 * @param  \App\Models\ClienteRallyUbicacion  $ubicacion
	 * @return \Illuminate\Http\Response
	 */
	public function marker_destroy(Cliente $cliente, ClienteRally $rally, ClienteRallyUbicacion $ubicacion, Request $request)
	{
		// delete from storage
		Storage::delete($ubicacion->imagen);
		Storage::delete($ubicacion->marker);
		$ubicacion->delete();
		return redirect()->route('cliente.rally.markers', ['cliente' => $cliente->id, 'rally' => $rally->id])->with('success', 'Ubicación eliminada con éxito');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Http\Requests\StoreClienteRallyRequest  $request
	 * @param  \App\Models\ClienteRallyUbicacion  $ubicacion
	 * @return \Illuminate\Http\Response
	 */
	public function marker_update(Cliente $cliente, ClienteRally $rally, ClienteRallyUbicacion $ubicacion, Request $request)
	{
		$data = $request->validate([
			'titulo' => 'required|string',
			'fuera_rango' => 'required|string',
			'descripcion' => 'required|string',
			'btn_titulo' => 'required|string',
			'btn_link' => 'required|string',
			'distancia' => 'required|numeric',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
			'imagen' => 'nullable|sometimes|image',
			'marker' => 'nullable|sometimes|image',
		]);
		unset($data['imagen'], $data['marker']);
		if ($request->hasFile('imagen')) {
			Storage::disk('public')->delete($ubicacion->imagen);
			$data['imagen'] = $request->file('imagen')->store('rally', 'public');
		}
		if ($request->hasFile('marker')) {
			Storage::disk('public')->delete($ubicacion->marker);
			$data['marker'] = $request->file('marker')->store('rally', 'public');
		}
		$data['ver_mapa'] = $request->boolean('ver_mapa', false);
		$data['cupon'] = $request->boolean('cupon', false);
		$ubicacion->update($data);
		return redirect()->route('cliente.rally.markers', ['cliente' => $cliente->id, 'rally' => $rally->id])->with('success', 'Ubicación actualizada con éxito');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Http\Requests\StoreClienteRallyRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function marker_store(Cliente $cliente, ClienteRally $rally, Request $request)
	{
		$data = $request->validate([
			'titulo' => 'required|string',
			'fuera_rango' => 'required|string',
			'descripcion' => 'required|string',
			'btn_titulo' => 'required|string',
			'btn_link' => 'required|string',
			'distancia' => 'required|numeric',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
			'imagen' => 'required|image',
			'marker' => 'required|image',
		]);
		unset($data['imagen'], $data['marker']);
		$data['imagen'] = $request->file('imagen')->store('rally', 'public');
		$data['marker'] = $request->file('marker')->store('rally', 'public');
		$data['ver_mapa'] = $request->boolean('ver_mapa', false);
		$data['cupon'] = $request->boolean('cupon', false);
		$rally->ubicaciones()->create($data);
		return redirect()->route('cliente.rally.markers', ['cliente' => $cliente->id, 'rally' => $rally->id])->with('success', 'Ubicación creada con éxito');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Http\Requests\StoreClienteRallyRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreClienteRallyRequest $request)
	{
		$data = $request->safe()->except('imagen');
		$data['cliente_id'] = $cliente->id;
		$data['activo'] = $request->boolean('activo', false);
		$data['geo_oculto'] = $request->boolean('geo_oculto', false);
		$data['banner'] = $request->file('imagen')->store('rally', 'public');
		$rally = ClienteRally::create($data);
		if ($request->filled('sucursales')) {
			foreach ($request->input('sucursales') as $sucursalId) {
				ClienteRallySucursal::create([
					'rally_id' => $rally->id,
					'sucursal_id' => $sucursalId,
				]);
			}
		}
		return redirect()->route('cliente.rally.index', ['cliente' => $cliente->id])->with('success', 'Rally creado con éxito');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteRally  $rally
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente, ClienteRally $rally)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteRally  $rally
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, ClienteRally $rally)
	{
		return view('dashboard.rally.edit', compact('cliente', 'rally'))
			->with('sucursales', $cliente->sucursales)
			->with('sucursalesAsignadas', $rally->sucursales->pluck('sucursal_id')->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Http\Requests\UpdateClienteRallyRequest  $request
	 * @param  \App\Models\ClienteRally  $rally
	 * @return \Illuminate\Http\Response
	 */
	public function update(Cliente $cliente, UpdateClienteRallyRequest $request, ClienteRally $rally)
	{
		$data = $request->safe()->except('imagen');
		$data['activo'] = $request->boolean('activo', false);
		$data['geo_oculto'] = $request->boolean('geo_oculto', false);
		if ($request->hasFile('imagen')) {
			Storage::disk('public')->delete($rally->banner);
			$data['banner'] = $request->file('imagen')->store('rally', 'public');
		}
		ClienteRallySucursal::where('rally_id', $rally->id)->delete();
		if ($request->filled('sucursales')) {
			foreach ($request->input('sucursales') as $sucursalId) {
				ClienteRallySucursal::create([
					'rally_id' => $rally->id,
					'sucursal_id' => $sucursalId,
				]);
			}
		}
		$rally->update($data);
		return redirect()->route('cliente.rally.index', ['cliente' => $cliente->id])->with('success', 'Rally actualizado con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @param  \App\Models\ClienteRally  $rally
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente, ClienteRally $rally)
	{
		foreach ($rally->ubicaciones as $ubicacion) {
			Storage::disk('public')->delete($ubicacion->imagen);
			Storage::disk('public')->delete($ubicacion->marker);
			// $ubicacion->delete();
		}
		Storage::disk('public')->delete($rally->banner);
		$rally->delete();
		return redirect()->route('cliente.rally.index', ['cliente' => $cliente->id])->with('success', 'Rally eliminado con éxito');
	}
}
