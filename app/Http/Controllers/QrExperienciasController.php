<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteQRExperiencia;
use App\Http\Requests\StoreClienteQRExperienciaRequest;
use App\Http\Requests\UpdateClienteQRExperienciaRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrExperienciasController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		$experiencias = ClienteQRExperiencia::where('cliente_id', $cliente->id)->get();
		return view('dashboard.qrexperiencias.index', compact('cliente', 'experiencias'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		return view('dashboard.qrexperiencias.create', compact('cliente'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteQRExperienciaRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreClienteQRExperienciaRequest $request)
	{
		$data = $request->validated();
		$data['cliente_id'] = $cliente->id;
		$qrexperiencia = ClienteQRExperiencia::create($data);
		if (!is_dir(storage_path('app/public/qrexperiencias'))) {
			File::makeDirectory(storage_path('app/public/qrexperiencias'));
		}
		if ($qrexperiencia !== NULL) {
			QrCode::format('png')
			->size(800)
			->merge('/public/images/qr-logo@2x.png', .3)
			->errorCorrection('H')
			->generate("https://ar-caddy.com/{$cliente->slug}/experiencia/{$qrexperiencia->id}", storage_path("app/public/qrexperiencias/{$qrexperiencia->id}.png"));
		}
		return redirect()->route('cliente.qrexperiencias.index', ['cliente' => $cliente->id])->with('success', 'QR creado correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ClienteQRExperiencia  $qrexperiencia
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente, ClienteQRExperiencia $qrexperiencia)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ClienteQRExperiencia  $qrexperiencia
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, ClienteQRExperiencia $qrexperiencia)
	{
		return view('dashboard.qrexperiencias.edit', compact('cliente', 'qrexperiencia'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteQRExperienciaRequest  $request
	 * @param  \App\Models\ClienteQRExperiencia  $qrexperiencia
	 * @return \Illuminate\Http\Response
	 */
	public function update(Cliente $cliente, UpdateClienteQRExperienciaRequest $request, ClienteQRExperiencia $qrexperiencia)
	{
		$data = $request->validated();
		$qrexperiencia->update($data);
		return redirect()->route('cliente.qrexperiencias.index', ['cliente' => $cliente->id])->with('success', 'QR actualizado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ClienteQRExperiencia  $qrexperiencia
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente, ClienteQRExperiencia $qrexperiencia)
	{
		// delete qr image
		Storage::disk('public')->delete("qrexperiencias/{$qrexperiencia->id}.png");
		$qrexperiencia->delete();
		return redirect()->route('cliente.qrexperiencias.index', ['cliente' => $cliente->id])->with('success', 'QR eliminado correctamente.');
	}
}
