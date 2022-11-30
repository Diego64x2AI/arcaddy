<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Votaciones;
use App\Http\Requests\StoreVotacionesRequest;
use App\Http\Requests\UpdateVotacionesRequest;
use App\Models\Cliente;
use App\Models\User;
use App\Models\VotacionesCategorias;
use App\Models\VotacionesParticipantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VotacionesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('dashboard.votaciones.index', [
			'votaciones' => Votaciones::all(),
			'clientes' => Cliente::all(),
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @return \Illuminate\Http\Response
	 */
	public function participantes(Votaciones $votacione)
	{
		return view('dashboard.votaciones.participantes', [
			'votacion' => $votacione,
			'categorias' => VotacionesCategorias::select('id', 'nombre')->where('votacion_id', $votacione->id)->get(),
			'categorias2' => VotacionesCategorias::select('id as value', 'nombre as label')->where('votacion_id', $votacione->id)->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function participantes_search(Votaciones $votacione, Request $request)
	{
		$validator = Validator::make($request->all(), [
			'q' => 'required|max:255',
		]);

		if ($validator->fails()) {
			return response()->json([
				'data' => [],
			]);
		}

		$query = User::where('cliente_id', $votacione->cliente->id);

		return response()->json([
			'data' => $query->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function participantes_store(Votaciones $votacione, Request $request)
	{
		$validator = Validator::make($request->all(), [
			'user_id' => 'required|numeric|min:1|exists:\App\Models\User,id',
			'categoria_id' => 'required|numeric|min:1|exists:\App\Models\VotacionesCategorias,id',
			'imagen' => 'required|image',
			'link' => 'required|url',
			'activa' => 'sometimes',
			'finalista' => 'sometimes',
		]);
		if ($validator->fails()) {
			return redirect()->route('votaciones.participantes', ['votacione' => $votacione->id])->withErrors($validator)->withInput();
		}
		$campos = $validator->validated();
		unset($campos['imagen']);
		if ($request->hasFile('imagen')) {
			$campos['imagen'] = $request->file('imagen')->store('clientes/participantes', 'public');
		}
		$campos['activa'] = $request->boolean('activa');
		$campos['finalista'] = $request->boolean('finalista');
		$campos['votacion_id'] = $votacione->id;
		VotacionesParticipantes::create($campos);
		return redirect()->back()->with('success', 'Participante agregado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\VotacionesParticipantes  $participante
	 * @return \Illuminate\Http\Response
	 */
	public function participantes_destroy(VotacionesParticipantes $participante)
	{
		Storage::delete($participante->imagen);
		$participante->delete();
		return redirect()->route('votaciones.participantes', ['votacione' => $participante->votacion_id])->with('success', 'Participante eliminado correctamente.');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Models\VotacionesParticipantes  $participante
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function participantes_updatea(VotacionesParticipantes $participante, Request $request)
	{
		if ($request->filled('activa')) {
			$participante->update(['activa' => $request->boolean('activa')]);
		}
		if ($request->filled('finalista')) {
			$participante->update(['finalista' => $request->boolean('finalista')]);
		}
		if ($request->filled('link')) {
			$participante->update(['link' => $request->link]);
		}
		if ($request->filled('categoria_id')) {
			$participante->update(['categoria_id' => $request->categoria_id]);
		}
		return response()->json([
			'result' => true,
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @return \Illuminate\Http\Response
	 */
	public function categorias(Votaciones $votacione)
	{
		return view('dashboard.votaciones.categorias', [
			'votacion' => $votacione,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function categorias_store(Votaciones $votacione, Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nombre' => 'required|max:255',
			'activa' => 'sometimes',
		]);

		if ($validator->fails()) {
			return redirect()->route('votaciones.categorias', ['votacione' => $votacione->id])->withErrors($validator)->withInput();
		}

		// Retrieve the validated input...
		$campos = $validator->validated();
		$campos['activa'] = $request->boolean('activa');
		$campos['votacion_id'] = $votacione->id;
		VotacionesCategorias::create($campos);
		return redirect()->back()->with('success', 'Votación creada correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\VotacionesCategorias  $categoria
	 * @return \Illuminate\Http\Response
	 */
	public function categorias_destroy(VotacionesCategorias $categoria)
	{
		$categoria->delete();
		return redirect()->route('votaciones.categorias', ['votacione' => $categoria->votacion_id])->with('success', 'Categoría eliminada correctamente.');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Models\VotacionesCategorias  $categoria
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function categorias_updatea(VotacionesCategorias $categoria, Request $request)
	{
		if ($request->filled('activa')) {
			$categoria->update(['activa' => $request->boolean('activa')]);
		}
		return response()->json([
			'result' => true,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreVotacionesRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreVotacionesRequest $request)
	{
		$campos = $request->validated();
		// dd($campos);
		$campos['activa'] = $request->boolean('activa');
		$campos['votar'] = $request->boolean('votar');
		$campos['finalistas'] = $request->boolean('finalistas');
		Votaciones::create($campos);
		return redirect()->route('votaciones.index')->with('success', 'Votación creada correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Votaciones  $votaciones
	 * @return \Illuminate\Http\Response
	 */
	public function show(Votaciones $votaciones)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Votaciones  $votaciones
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Votaciones $votaciones)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateVotacionesRequest  $request
	 * @param  \App\Models\Votaciones  $votaciones
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateVotacionesRequest $request, Votaciones $votaciones)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function updatea(Votaciones $votacione, Request $request)
	{
		if ($request->filled('finalistas')) {
			$votacione->update(['finalistas' => $request->boolean('finalistas')]);
		}
		if ($request->filled('votar')) {
			$votacione->update(['votar' => $request->boolean('votar')]);
		}
		if ($request->filled('activa')) {
			$votacione->update(['activa' => $request->boolean('activa')]);
		}
		if ($request->filled('nombre')) {
			$votacione->update(['nombre' => $request->nombre]);
		}
		return response()->json([
			'result' => true,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Votaciones $votacione)
	{
		$votacione->delete();
		return redirect()->route('votaciones.index')->with('success', 'Votación eliminada correctamente.');
	}
}
