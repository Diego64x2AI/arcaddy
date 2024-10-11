<?php

namespace App\Http\Controllers\Admin;

use App\Models\QRLink;
use App\Models\Cliente;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQRLinkRequest;
use App\Http\Requests\UpdateQRLinkRequest;
use App\Models\QRLinkBanner;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class QRLinksController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		$links = QRLink::where('cliente_id', $cliente->id)->orderBy('id', 'desc')->get();
		// dd($links);
		return view('dashboard.qrlinks.index', compact('cliente', 'links'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		return view('dashboard.qrlinks.create', compact('cliente'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreQRLinkRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreQRLinkRequest $request)
	{
		$data = $request->validated();
		$data['banners'] = $request->boolean('banners-activo');
		$data['cliente_id'] = $cliente->id;
		$data['slug'] = Str::slug($data['slug']);
		$data['texto'] = str_replace(["../../../../storage", "../https"], [url("storage"), "https"], $data['texto']);
		$pagina = QRLink::create($data);
		// banners
		if (isset($data['banners_img']) && count($data['banners_img']) > 0) {
			QRLinkBanner::where('qrlink_id', $pagina->id)->delete();
			foreach ($data['banners_img'] as $key => $file) {
				QRLinkBanner::insert([
					'qrlink_id' => $pagina->id,
					'archivo' => $file->store('clientes/banners', 'public'),
					'titulo' => $data['banners_titulo'][$key],
					'link' => $data['banners_link'][$key],
				]);
			}
		}
		if (!is_dir(storage_path('app/public/qrcodes_secciones'))) {
			File::makeDirectory(storage_path('app/public/qrcodes_secciones'));
		}
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/' . $cliente->slug.'/'.$pagina->slug, storage_path('app/public/qrcodes_secciones/' . $pagina->slug . '.png'));
		// dd($data);
		return redirect()->route('cliente.qrlinks.index', ['cliente' => $cliente->id])->with('success', 'Sección creada con éxito');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\QRLink  $qrlink
	 * @return \Illuminate\Http\Response
	 */
	public function show(QRLink $qrlink)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\QRLink  $qrlink
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, QRLink $qrlink)
	{
		return view('dashboard.qrlinks.edit', compact('cliente', 'qrlink'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateQRLinkRequest  $request
	 * @param  \App\Models\QRLink  $qrlink
	 * @return \Illuminate\Http\Response
	 */
	public function update(Cliente $cliente, UpdateQRLinkRequest $request, QRLink $qrlink)
	{
		$data = $request->validated();
		$data['banners'] = $request->boolean('banners-activo');
		$data['cliente_id'] = $cliente->id;
		$data['slug'] = Str::slug($data['slug']);
		$data['texto'] = str_replace(["../../../../storage", "../https"], [url("storage"), "https"], $data['texto']);
		$qrlink->update($data);
		// banners
		if (isset($data['banners_img']) && count($data['banners_img']) > 0) {
			QRLinkBanner::where('qrlink_id', $qrlink->id)->delete();
			foreach ($data['banners_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('banners_old.' . $key)) {
					$archivo = $request->input('banners_old.' . $key);
				}
				if ($request->hasFile('banners_img.' . $key) && $request->file('banners_img.' . $key)->isValid()) {
					$archivo = $request->file('banners_img.' . $key)->store('clientes/banners', 'public');
				}
				QRLinkBanner::insert([
					'qrlink_id' => $qrlink->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
					'link' => $data['banners_link'][$key],
				]);
			}
		}
		if (!is_dir(storage_path('app/public/qrcodes_secciones'))) {
			File::makeDirectory(storage_path('app/public/qrcodes_secciones'));
		}
		QrCode::format('png')->size(500)->merge('/public/images/qr-logo.png', .3)->errorCorrection('H')->generate('https://ar-caddy.com/' . $cliente->slug.'/'.$qrlink->slug, storage_path('app/public/qrcodes_secciones/' . $qrlink->slug . '.png'));
		// dd($data);
		return redirect()->route('cliente.qrlinks.index', ['cliente' => $cliente->id])->with('success', 'Sección actualizada con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\QRLink  $qrlink
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(QRLink $qrlink)
	{
		//
	}
}
