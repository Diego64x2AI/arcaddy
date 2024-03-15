<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Juego;
use App\Models\JuegoCarta;
use App\Models\JuegoCategoria;
use App\Models\JuegoResultado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GameController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$clientes = Cliente::orderBy('cliente')->get();
		$juegoCategorias = JuegoCategoria::all();
		$juegos = Juego::orderBy('id', 'DESC')->paginate(20);
		$parametros = NULL;
		/*
		if( isset($_GET['cliente']) ){
			$parametros['cliente'] = $_GET['cliente'];
			$usuarios = DB::table('users')
				->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
				->where('cliente_id',$parametros['cliente'])
				->where('role_id',2)
				->get();
		}*/
		return view('dashboard.games.index', compact(
			'clientes',
			'juegoCategorias',
			'juegos',
			'parametros'
		));
	}

	public function create(Request $request)
	{
		$data = $request->validate([
			'cat' => 'required|numeric|exists:\App\Models\JuegoCategoria,id',
		]);
		$clientes = Cliente::orderBy('cliente')->get();
		$juegoCategoria = JuegoCategoria::find($data['cat']);
		return view('dashboard.games.nuevo', compact('clientes', 'juegoCategoria'));
	}

	public function store(Request $request)
	{
		// leer los datos directamente por slug por si el id es diferente en localhost y en el servidor
		$suffle_puzzle = JuegoCategoria::where('slug', 'shuffle-puzzle')->firstOrFail();
		$data = $request->validate([
			'categoria_id' => 'required|numeric|exists:\App\Models\JuegoCategoria,id',
			'cliente_id' => 'required|numeric|exists:\App\Models\Cliente,id',
			'nombre' => 'required|string',
			'descripcion' => 'required|string',
			'estatus' => 'required|numeric',
			'dificultad' => 'required_if:categoria_id,'.$suffle_puzzle->id,
			'images' => 'required|array',
			'images.*' => 'required|image',
		], [
			'dificultad.required_if' => 'La dificultad es requerida para este tipo de juego.',
			'imagen.required_if' => 'La imagen es requerida para este tipo de juego.',
		]);
		$data['categoria_id'] = (int) $data['categoria_id'];
		$juegof = new Juego();
		$juegof->juego_categoria_id = $data['categoria_id'];
		$juegof->cliente_id = $data['cliente_id'];
		$juegof->nombre = $data['nombre'];
		$juegof->descripcion = $data['descripcion'];
		if ($data['categoria_id'] === $suffle_puzzle->id) {
			$juegof->dificultad = $data['dificultad'];
		}
		$juegof->activo = $request->boolean('estatus');
		$caracteresPermitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$cadenaAleatoria = substr(str_shuffle($caracteresPermitidos), 0, 10);
		$juegof->clave = 'gm' . $juegof->id . $cadenaAleatoria;
		$juegof->save();
		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $file) {
				if ($data['categoria_id'] === $suffle_puzzle->id) {
					$imagen = $file->store('clientes/games/shuffle-puzzle', 'public');
					$carta = new JuegoCarta();
					$carta->juego_id = $juegof->id;
					$carta->imagen = $imagen;
					$carta->frente = 1;
					$carta->save();
				} else {
					$imagen = $file;
					$imagenNombre = $imagen->getClientOriginalName();
					$extension = $imagen->getClientOriginalExtension();
					$carta = new JuegoCarta();
					$carta->juego_id = $juegof->id;
					$carta->imagen = 'generica.png';
					$carta->frente = 1;
					$carta->save();
					$nuevoNombre = 'card-' . $juegof->id . '-' . $carta->id . '.' . $extension;
					$carta->imagen = $nuevoNombre;
					$carta->save();
					$ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
				}
			}
		}
		if ($request->hasFile('imageback')) {
			foreach ($request->file('imageback') as $key => $file) {
				$imagen = $file;
				$imagenNombre = $imagen->getClientOriginalName();
				$extension = $imagen->getClientOriginalExtension();
				$carta = new JuegoCarta();
				$carta->juego_id = $juegof->id;
				$carta->imagen = 'generica.png';
				$carta->frente = 0;
				$carta->save();
				$nuevoNombre = 'card-' . $juegof->id . '-' . $carta->id . '-back.' . $extension;
				$carta->imagen = $nuevoNombre;
				$carta->save();
				$ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
			}
		}
		return redirect()->route('games.index')->with('success', 'El juego ha sido creado.');
	}

	public function show()
	{
	}

	public function edit($id)
	{
		$clientes = Cliente::orderBy('cliente')->get();
		$juego = Juego::with(['categoria'])->findOrFail($id);
		$cartas = JuegoCarta::where('juego_id', $juego->id)->where('frente', 1)->where('borrado', 0)->get();
		$cartasBack = JuegoCarta::where('juego_id', $juego->id)->where('frente', 0)->where('borrado', 0)->get();
		if (!$juego) {
			return redirect()->route('games.index');
		}
		return view('dashboard.games.editar', compact('juego', 'clientes', 'cartas', 'cartasBack'));
	}

	public function update(Juego $game, Request $request)
	{
		// leer los datos directamente por slug por si el id es diferente en localhost y en el servidor
		$suffle_puzzle = JuegoCategoria::where('slug', 'shuffle-puzzle')->firstOrFail();
		$data = $request->validate([
			'cliente_id' => 'required|numeric|exists:\App\Models\Cliente,id',
			'nombre' => 'required|string',
			'descripcion' => 'required|string',
			'estatus' => 'required|numeric',
			'dificultad' => 'required_if:categoria_id,'.$suffle_puzzle->id,
			'images' => 'nullable|sometimes|array',
			'images.*' => 'nullable|sometimesimage',
		], [
			'dificultad.required_if' => 'La dificultad es requerida para este tipo de juego.',
			'imagen.required_if' => 'La imagen es requerida para este tipo de juego.',
		]);
		$fields = [
			'cliente_id' => $data['cliente_id'],
			'nombre' => $data['nombre'],
			'descripcion' => $data['descripcion'],
			'activo' => $request->boolean('estatus'),
		];
		if ($game->juego_categoria_id === $suffle_puzzle->id) {
			$fields['dificultad'] = $data['dificultad'];
		}
		$game->update($fields);
		if ($request->borradas !== '') {
			$borrar = explode(",", $request->borradas);
			foreach ($borrar as $b) {
				$registroAEliminar = JuegoCarta::find($b);
				if ($registroAEliminar) {
					/*$registroAEliminar->borrado = 1;
                  $registroAEliminar->save();*/
					$registroAEliminar->delete();
				}
			}
		}
		if ($request->hasFile('images')) {
			foreach ($request->file('images') as $key => $file) {
				if ($game->juego_categoria_id === $suffle_puzzle->id) {
					$imagen = $file->store('clientes/games/shuffle-puzzle', 'public');
					$carta = new JuegoCarta();
					$carta->juego_id = $game->id;
					$carta->imagen = $imagen;
					$carta->frente = 1;
					$carta->save();
				} else {
					$imagen = $file;
					$imagenNombre = $imagen->getClientOriginalName();
					$extension = $imagen->getClientOriginalExtension();
					$carta = new JuegoCarta();
					$carta->juego_id = $game->id;
					$carta->imagen = 'generica.png';
					$carta->frente = 1;
					$carta->save();
					$nuevoNombre = 'card-' . $game->id . '-' . $carta->id . '.' . $extension;
					$carta->imagen = $nuevoNombre;
					$carta->save();
					$ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
				}
			}
		}
		if ($request->hasFile('imageback')) {
			foreach ($request->file('imageback') as $key => $file) {
				$imagen = $file;
				$imagenNombre = $imagen->getClientOriginalName();
				$extension = $imagen->getClientOriginalExtension();
				$carta = new JuegoCarta();
				$carta->juego_id = $game->id;
				$carta->imagen = 'generica.png';
				$carta->frente = 0;
				$carta->save();
				$nuevoNombre = 'card-' . $game->id . '-' . $carta->id . '-back.' . $extension;
				$carta->imagen = $nuevoNombre;
				$carta->save();
				$ruta = $imagen->storeAs('clientes/games/memory', $nuevoNombre, 'public');
			}
		}
		return redirect()->route('games.edit', ['game' => $game->id])->with('success', 'El juego ha sido actualizado.');
	}

	public function destroy(Juego $game)
	{
		$game->delete();
		// TODO: Eliminar archivos cuando se borre de la papelera
		return redirect()->route('games.index')->with('success', 'El juego ha sido eliminado.');
	}

}
