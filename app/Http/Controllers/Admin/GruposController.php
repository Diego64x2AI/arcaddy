<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grupo;
use App\Models\Cliente;
use App\Models\GrupoMiembro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;

class GruposController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard.grupos.index', [
			'grupos' => Grupo::all(),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('dashboard.grupos.create');
	}

	public function clientes(Request $request)
	{
		$data = $request->validate([
			'q' => 'nullable|sometimes|string',
		]);
		$query = Cliente::select('id', 'cliente as text', 'logo')->orderBy('cliente');
		if (isset($data['q']) && $data['q'] !== NULL && trim($data['q']) !== '') {
			$query->where('cliente', 'like', "%{$data['q']}%");
		}
		return response()->json([
			'results' => $query->get(),
			'pagination' => [
				'more' => false,
			]
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreGrupoRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreGrupoRequest $request)
	{
		$data = $request->safe()->except(['logo']);
		if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
			$data['logo'] = $request->file('logo')->store('grupos', 'public');
		}
		$grupo = Grupo::create($data);
		foreach ($data['miembro'] as $miembro_id) {
			GrupoMiembro::create([
				'grupo_id' => $grupo->id,
				'cliente_id' => $miembro_id,
			]);
		}
		return redirect()->route('grupos.index')->with('success', 'Grupo creado correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Grupo  $grupo
	 * @return \Illuminate\Http\Response
	 */
	public function show(Grupo $grupo)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Grupo  $grupo
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Grupo $grupo)
	{
		return view('dashboard.grupos.edit', compact('grupo'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateGrupoRequest  $request
	 * @param  \App\Models\Grupo  $grupo
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateGrupoRequest $request, Grupo $grupo)
	{
		$data = $request->safe()->except(['logo']);
		if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
			$data['logo'] = $request->file('logo')->store('grupos', 'public');
		}
		$grupo->update($data);
		GrupoMiembro::where('grupo_id', $grupo->id)->delete();
		foreach ($data['miembro'] as $miembro_id) {
			GrupoMiembro::create([
				'grupo_id' => $grupo->id,
				'cliente_id' => $miembro_id,
			]);
		}
		return redirect()->route('grupos.index')->with('success', 'Grupo editado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Grupo  $grupo
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Grupo $grupo)
	{
		// delete the image if exists
		if ($grupo->logo !== NULL && Storage::exists($grupo->logo)) {
			Storage::delete($grupo->logo);
		}
		$grupo->delete();
		return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente.');
	}
}
