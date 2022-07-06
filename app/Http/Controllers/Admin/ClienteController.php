<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cliente;
use App\Models\ClienteBlog;
use Illuminate\Support\Str;
use App\Models\ClienteBanner;
use App\Models\ClienteLibres;
use App\Models\ClienteGaleria;
use App\Models\ClientePlaylist;
use App\Models\ClienteSecciones;
use App\Models\ClienteExperiencia;
use App\Http\Controllers\Controller;
use App\Models\ClienteColaboradores;
use App\Models\ClientePatrocinadores;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard.clientes.index', [
			'clientes' => Cliente::all(),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('dashboard.clientes.create', [
			'cliente' => new Cliente(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreClienteRequest $request)
	{
		$campos = $request->validated();
		unset($campos['logo']);
		$campos['slug'] = Str::slug($campos['slug']);
		$campos['logo'] = $request->file('logo')->store('clientes/images', 'public');
		// dd($campos);
		$cliente = Cliente::create($campos);
		// secciones orden
		if (isset($campos['secciones']) && count($campos['secciones']) > 0) {
			foreach ($campos['secciones'] as $key => $seccion) {
				ClienteSecciones::updateOrCreate(
					[
						'cliente_id' => $cliente->id,
						'seccion' => $seccion,
					],
					[
						'orden' => $key,
						'activa' => $request->boolean($seccion . '-activo'),
					]
				);
			}
		}
		// banners
		if (isset($campos['banners_img']) && count($campos['banners_img']) > 0) {
			ClienteBanner::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['banners_img'] as $key => $file) {
				ClienteBanner::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/banners', 'public'),
					'titulo' => $campos['banners_titulo'][$key],
				]);
			}
		}
		// colaboradores
		if (isset($campos['colaboradores_img']) && count($campos['colaboradores_img']) > 0) {
			ClienteColaboradores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['colaboradores_img'] as $key => $file) {
				ClienteColaboradores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/colaboradores', 'public'),
					'nombre' => $campos['colaboradores_titulo'][$key],
					'talento' => $campos['colaboradores_talento'][$key],
					'descripcion' => $campos['colaboradores_descripcion'][$key],
				]);
			}
		}
		// patrocinadores
		if (isset($campos['patrocinadores_img']) && count($campos['patrocinadores_img']) > 0) {
			ClientePatrocinadores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['patrocinadores_img'] as $key => $file) {
				ClientePatrocinadores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/patrocinadores', 'public'),
					'titulo' => $campos['patrocinadores_titulo'][$key],
				]);
			}
		}
		// galeria
		if (isset($campos['galeria_img']) && count($campos['galeria_img']) > 0) {
			ClienteGaleria::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['galeria_img'] as $key => $file) {
				ClienteGaleria::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/galeria', 'public'),
					'titulo' => $campos['galeria_titulo'][$key],
				]);
			}
		}
		// libres
		if (isset($campos['libres_img']) && count($campos['libres_img']) > 0) {
			ClienteLibres::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['libres_img'] as $key => $file) {
				ClienteLibres::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/libres', 'public'),
					'titulo' => $campos['libres_titulo'][$key],
				]);
			}
		}
		// blog
		if (isset($campos['blog_img']) && count($campos['blog_img']) > 0) {
			ClienteBlog::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['blog_img'] as $key => $file) {
				ClienteBlog::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/blog', 'public'),
					'titulo' => $campos['blog_titulo'][$key],
					'link' => $campos['blog_link'][$key],
					'descripcion' => $campos['blog_descripcion'][$key],
				]);
			}
		}
		// playlist
		if (isset($campos['playlist_img']) && count($campos['playlist_img']) > 0) {
			ClientePlaylist::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['playlist_img'] as $key => $file) {
				ClientePlaylist::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/playlist', 'public'),
					'plataforma' => $campos['playlist_plataforma'][$key],
					'link' => $campos['playlist_link'][$key],
				]);
			}
		}
		// experiencia
		if (isset($campos['experiencia_img']) && count($campos['experiencia_img']) > 0) {
			ClienteExperiencia::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['experiencia_img'] as $key => $file) {
				ClienteExperiencia::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/experiencias', 'public'),
					'titulo' => $campos['experiencia_titulo'][$key],
					'link' => $campos['experiencia_link'][$key],
					'descripcion' => $campos['experiencia_instrucciones'][$key],
				]);
			}
		}
		// dd($campos);
		return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente)
	{
		return view('dashboard.clientes.create', [
			'cliente' => $cliente,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteRequest  $request
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateClienteRequest $request, Cliente $cliente)
	{
		$campos = $request->validated();
		unset($campos['logo']);
		$campos['slug'] = Str::slug($campos['slug']);
		if ($request->hasFile('logo')) {
			if ($cliente->logo !== NULL) {
				Storage::delete($cliente->logo);
			}
			$campos['logo'] = $request->file('logo')->store('clientes/images', 'public');
		}
		$cliente->update($campos);
		// secciones orden
		if (isset($campos['secciones']) && count($campos['secciones']) > 0) {
			foreach ($campos['secciones'] as $key => $seccion) {
				ClienteSecciones::updateOrCreate(
					[
						'cliente_id' => $cliente->id,
						'seccion' => $seccion,
					],
					[
						'orden' => $key,
						'activa' => $request->boolean($seccion . '-activo'),
					]
				);
			}
		}
		// dd($request->all());
		// banners
		if (isset($campos['banners_titulo']) && count($campos['banners_titulo']) > 0) {
			foreach ($cliente->banners as $banner) {
				Storage::delete($banner->archivo);
			}
			ClienteBanner::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['banners_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('banners_old.' . $key)) {
					$archivo = $request->input('banners_old.' . $key);
				}
				if ($request->hasFile('banners_img.' . $key) && $request->file('banners_img.' . $key)->isValid()) {
					$archivo = $request->file('banners_img.' . $key)->store('clientes/banners', 'public');
				}
				ClienteBanner::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
				]);
			}
		}
		// colaboradores
		if (isset($campos['colaboradores_titulo']) && count($campos['colaboradores_titulo']) > 0) {
			foreach ($cliente->colaboradores as $colaborador) {
				Storage::delete($colaborador->archivo);
			}
			ClienteColaboradores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['colaboradores_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('colaboradores_old.' . $key)) {
					$archivo = $request->input('colaboradores_old.' . $key);
				}
				if ($request->hasFile('colaboradores_img.' . $key) && $request->file('colaboradores_img.' . $key)->isValid()) {
					$archivo = $request->file('colaboradores_img.' . $key)->store('clientes/colaboradores', 'public');
				}
				ClienteColaboradores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'nombre' => $titulo,
					'talento' => $campos['colaboradores_talento'][$key],
					'descripcion' => $campos['colaboradores_descripcion'][$key],
				]);
			}
		}
		// patrocinadores
		if (isset($campos['patrocinadores_titulo']) && count($campos['patrocinadores_titulo']) > 0) {
			foreach ($cliente->patrocinadores as $patrocinador) {
				Storage::delete($patrocinador->archivo);
			}
			ClientePatrocinadores::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['patrocinadores_titulo'] as $key => $titulo) {
				// archivo viejo
				if ($request->filled('patrocinadores_old.' . $key)) {
					$archivo = $request->input('patrocinadores_old.' . $key);
				}
				if ($request->hasFile('patrocinadores_img.' . $key) && $request->file('patrocinadores_img.' . $key)->isValid()) {
					$archivo = $request->file('patrocinadores_img.' . $key)->store('clientes/patrocinadores', 'public');
				}
				ClientePatrocinadores::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $archivo,
					'titulo' => $titulo,
				]);
			}
		}
		// galeria
		if (isset($campos['galeria_img']) && count($campos['galeria_img']) > 0) {
			foreach ($cliente->galeria as $galeria) {
				Storage::delete($galeria->archivo);
			}
			ClienteGaleria::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['galeria_img'] as $key => $file) {
				ClienteGaleria::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/galeria', 'public'),
					'titulo' => $campos['galeria_titulo'][$key],
				]);
			}
		}
		// libres
		if (isset($campos['libres_img']) && count($campos['libres_img']) > 0) {
			foreach ($cliente->libres as $libre) {
				Storage::delete($libre->archivo);
			}
			ClienteLibres::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['libres_img'] as $key => $file) {
				ClienteLibres::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/libres', 'public'),
					'titulo' => $campos['libres_titulo'][$key],
				]);
			}
		}
		// blog
		if (isset($campos['blog_img']) && count($campos['blog_img']) > 0) {
			foreach ($cliente->blog as $blog) {
				Storage::delete($blog->archivo);
			}
			ClienteBlog::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['blog_img'] as $key => $file) {
				ClienteBlog::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/blog', 'public'),
					'titulo' => $campos['blog_titulo'][$key],
					'link' => $campos['blog_link'][$key],
					'descripcion' => $campos['blog_descripcion'][$key],
				]);
			}
		}
		// playlist
		if (isset($campos['playlist_img']) && count($campos['playlist_img']) > 0) {
			foreach ($cliente->playlist as $playlist) {
				Storage::delete($playlist->archivo);
			}
			ClientePlaylist::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['playlist_img'] as $key => $file) {
				ClientePlaylist::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/playlist', 'public'),
					'plataforma' => $campos['playlist_plataforma'][$key],
					'link' => $campos['playlist_link'][$key],
				]);
			}
		}
		// experiencia
		if (isset($campos['experiencia_img']) && count($campos['experiencia_img']) > 0) {
			foreach ($cliente->experiencias as $experiencia) {
				Storage::delete($experiencia->archivo);
			}
			ClienteExperiencia::where('cliente_id', $cliente->id)->delete();
			foreach ($campos['experiencia_img'] as $key => $file) {
				ClienteExperiencia::insert([
					'cliente_id' => $cliente->id,
					'archivo' => $file->store('clientes/experiencias', 'public'),
					'titulo' => $campos['experiencia_titulo'][$key],
					'link' => $campos['experiencia_link'][$key],
					'descripcion' => $campos['experiencia_instrucciones'][$key],
				]);
			}
		}
		return redirect()->back()->with('success', 'Cliente editado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Cliente  $cliente
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente)
	{
		foreach ($cliente->patrocinadores as $patrocinador) {
			Storage::delete($patrocinador->archivo);
		}
		foreach ($cliente->galeria as $galeria) {
			Storage::delete($galeria->archivo);
		}
		foreach ($cliente->libres as $libre) {
			Storage::delete($libre->archivo);
		}
		foreach ($cliente->blog as $blog) {
			Storage::delete($blog->archivo);
		}
		foreach ($cliente->playlist as $playlist) {
			Storage::delete($playlist->archivo);
		}
		foreach ($cliente->experiencias as $experiencia) {
			Storage::delete($experiencia->archivo);
		}
		foreach ($cliente->banners as $banner) {
			Storage::delete($banner->archivo);
		}
		foreach ($cliente->colaboradores as $colaborador) {
			Storage::delete($colaborador->archivo);
		}
		Storage::delete($cliente->logo);
		ClienteSecciones::where('cliente_id', $cliente->id)->delete();
		ClienteBanner::where('cliente_id', $cliente->id)->delete();
		ClienteColaboradores::where('cliente_id', $cliente->id)->delete();
		ClientePatrocinadores::where('cliente_id', $cliente->id)->delete();
		ClienteGaleria::where('cliente_id', $cliente->id)->delete();
		ClienteLibres::where('cliente_id', $cliente->id)->delete();
		ClienteBlog::where('cliente_id', $cliente->id)->delete();
		ClientePlaylist::where('cliente_id', $cliente->id)->delete();
		ClienteExperiencia::where('cliente_id', $cliente->id)->delete();
		$cliente->delete();
		return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
	}
}
