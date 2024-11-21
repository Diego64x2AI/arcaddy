<?php

namespace App\Http\Controllers\Admin;

use App\Models\QRLink;
use App\Models\Cliente;
use Illuminate\Support\Str;
use App\Models\RealidadAumentada;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\StoreRealidadAumentadaRequest;
use App\Http\Requests\UpdateRealidadAumentadaRequest;

class RealidadAumentadaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		$links = RealidadAumentada::where('cliente_id', $cliente->id)->orderBy('id', 'desc')->get();
		// dd($links);
		return view('dashboard.realidad.index', compact('cliente', 'links'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		return view('dashboard.realidad.create', compact('cliente'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreRealidadAumentadaRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreRealidadAumentadaRequest $request)
	{
		$data = $request->except(['imagen', 'glb', 'usdz']);
		$data['cliente_id'] = $cliente->id;
		$data['slug'] = Str::slug($data['slug']);
		$data['texto'] = str_replace(["../../../../storage", "../https"], [url("storage"), "https"], $data['texto']);
		$data['imagen'] = $request->file('imagen')->store('ar', 'public');
		$data['glb'] = $request->file('glb')->storeAs('ar', uniqid()."_{$data['slug']}.glb", 'public');
		$data['usdz'] = $request->file('usdz')->storeAs('ar', uniqid()."_{$data['slug']}.usdz", 'public');
		$pagina = RealidadAumentada::create($data);
		if (!is_dir(storage_path("app/public/qrcodes_ar"))) {
			File::makeDirectory(storage_path("app/public/qrcodes_ar"));
		}
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate("https://ar-caddy.com/{$cliente->slug}/ar/{$pagina->slug}", storage_path("app/public/qrcodes_ar/{$pagina->id}.png"));
		return redirect()->route('cliente.realidad.index', ['cliente' => $cliente->id])->with('success', 'AR creada con éxito');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\RealidadAumentada  $realidad
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente, RealidadAumentada $realidad)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\RealidadAumentada  $realidad
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, RealidadAumentada $realidad)
	{
		return view('dashboard.realidad.edit', compact('cliente', 'realidad'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateRealidadAumentadaRequest  $request
	 * @param  \App\Models\RealidadAumentada  $realidad
	 * @return \Illuminate\Http\Response
	 */
	public function update(Cliente $cliente, UpdateRealidadAumentadaRequest $request, RealidadAumentada $realidad)
	{
		$data = $request->except(['imagen', 'glb', 'usdz']);
		$data['slug'] = Str::slug($data['slug']);
		$data['texto'] = str_replace(["../../../../storage", "../https"], [url("storage"), "https"], $data['texto']);
		if ($request->hasFile('imagen')) {
			Storage::disk('public')->delete($realidad->imagen);
			$data['imagen'] = $request->file('imagen')->store('ar', 'public');
		}
		if ($request->hasFile('glb')) {
			Storage::disk('public')->delete($realidad->glb);
			$data['glb'] = $request->file('glb')->storeAs('ar', uniqid()."_{$data['slug']}.glb", 'public');
		}
		if ($request->hasFile('usdz')) {
			Storage::disk('public')->delete($realidad->usdz);
			$data['usdz'] = $request->file('usdz')->storeAs('ar', uniqid()."_{$data['slug']}.usdz", 'public');
		}
		$realidad->update($data);
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate("https://ar-caddy.com/{$cliente->slug}/ar/{$realidad->slug}", storage_path("app/public/qrcodes_ar/{$realidad->id}.png"));
		return redirect()->route('cliente.realidad.index', ['cliente' => $cliente->id])->with('success', 'AR actualizada con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\RealidadAumentada  $realidad
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente, RealidadAumentada $realidad)
	{
		// delete files
		File::delete(storage_path("app/public/{$realidad->imagen}"));
		File::delete(storage_path("app/public/{$realidad->glb}"));
		File::delete(storage_path("app/public/{$realidad->usdz}"));
		File::delete(storage_path("app/public/qrcodes_ar/{$realidad->id}.png"));
		$realidad->delete();
		return redirect()->route('cliente.realidad.index', ['cliente' => $cliente->id])->with('success', 'AR eliminada con éxito');
	}
}
