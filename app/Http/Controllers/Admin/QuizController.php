<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cliente;
use App\Models\ClienteQuiz;
use Illuminate\Http\Request;
use App\Models\ClienteQuizPregunta;
use App\Http\Controllers\Controller;
use App\Models\ClienteQuizRespuesta;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreClienteQuizRequest;
use App\Http\Requests\UpdateClienteQuizRequest;

class QuizController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente)
	{
		return view('dashboard.quiz.index', compact('cliente'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Cliente $cliente)
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreClienteQuizRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Cliente $cliente, StoreClienteQuizRequest $request)
	{
		$campos = $request->validated();
		// $campos['cliente_id'] = $cliente->id;
		$campos['activa'] = $request->boolean('activa');
		$campos['score'] = $request->boolean('score');
		$campos['random'] = $request->boolean('random');
		$campos['calificacion'] = $request->boolean('calificacion');
		// if is active, deactivate the others
		if ($campos['activa']) {
			$cliente->quiz()->update(['activa' => false]);
		}
		ClienteQuiz::create($campos);
		return redirect()->route('cliente.quiz.index', ['cliente' => $cliente->id])->with('success', 'Quiz creado correctamente.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ClienteQuiz  $quiz
	 * @return \Illuminate\Http\Response
	 */
	public function show(Cliente $cliente, ClienteQuiz $quiz)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ClienteQuiz  $quiz
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Cliente $cliente, ClienteQuiz $quiz)
	{
		// dd($quiz->preguntas);
		return view('dashboard.quiz.edit', compact('cliente', 'quiz'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Models\Votaciones  $votacione
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function updatea(Cliente $cliente, ClienteQuiz $quiz, Request $request)
	{
		if ($request->filled('random')) {
			$quiz->update(['random' => $request->boolean('random')]);
		}
		if ($request->filled('score')) {
			$quiz->update(['score' => $request->boolean('score')]);
		}
		if ($request->filled('calificacion')) {
			$quiz->update(['calificacion' => $request->boolean('calificacion')]);
		}
		if ($request->filled('activa')) {
			// if is active, deactivate the others
			if ($request->boolean('activa')) {
				$cliente->quiz()->update(['activa' => false]);
			}
			$quiz->update(['activa' => $request->boolean('activa')]);
		}
		if ($request->filled('nombre')) {
			$quiz->update(['nombre' => $request->nombre]);
		}
		return response()->json([
			'result' => true,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateClienteQuizRequest  $request
	 * @param  \App\Models\ClienteQuiz  $quiz
	 * @return \Illuminate\Http\Response
	 */
	public function update(Cliente $cliente, UpdateClienteQuizRequest $request, ClienteQuiz $quiz)
	{
		$data = $request->safe()->except(['archivo_img']);
		// dd($data);
		// delete the questions
		$quiz->preguntas()->delete();
		// store the questions
		foreach ($data['pregunta'] as $key => $value) {
			$tipo = $data['tipo'][$key];
			$archivo = NULL;
			$archivov1 = NULL;
			$archivov2 = NULL;
			// validate the file if the question is like or level
			if (in_array($tipo, ['like', 'level'])) {
				$request->validate([
					'archivo_img.'.$key => 'required_without:archivo_old.'.$key.'|file|mimes:jpeg,png,jpg,gif',
				], [
					'archivo_img.'.$key.'.required_without' => 'La imagen es requerida.',
					'archivo_img.'.$key.'.file' => 'La imagen no es válida.',
					'archivo_img.'.$key.'.mimes' => 'La imagen no es válida.',
				]);
				// archivo viejo
				if ($request->filled('archivo_old.' . $key)) {
					$archivo = $request->input('archivo_old.' . $key);
				}
				if ($request->hasFile('archivo_img.' . $key) && $request->file('archivo_img.' . $key)->isValid()) {
					// delete the old file
					if ($archivo !== NULL && Storage::exists($archivo)) {
						Storage::delete($archivo);
					}
					$archivo = $request->file('archivo_img.' . $key)->store('quiz', 'public');
				}
			} elseif ($tipo == 'versus') {
				$request->validate([
					'versus1_img.'.$key => 'required_without:versus1_old.'.$key.'|file|mimes:jpeg,png,jpg,gif',
				], [
					'versus1_img.'.$key.'.required_without' => 'La imagen 1 es requerida.',
					'versus1_img.'.$key.'.file' => 'La imagen 1 no es válida.',
					'versus1_img.'.$key.'.mimes' => 'La imagen 1 no es válida.',
				]);
				$request->validate([
					'versus2_img.'.$key => 'required_without:versus2_old.'.$key.'|file|mimes:jpeg,png,jpg,gif',
				], [
					'versus2_img.'.$key.'.required_without' => 'La imagen 2 es requerida.',
					'versus2_img.'.$key.'.file' => 'La imagen 2 no es válida.',
					'versus2_img.'.$key.'.mimes' => 'La imagen 2 no es válida.',
				]);
				// archivo viejo
				if ($request->filled('versus1_old.' . $key)) {
					$archivov1 = $request->input('versus1_old.' . $key);
				}
				if ($request->hasFile('versus1_img.' . $key) && $request->file('versus1_img.' . $key)->isValid()) {
					// delete the old file
					if ($archivov1 !== NULL && Storage::exists($archivov1)) {
						Storage::delete($archivov1);
					}
					$archivov1 = $request->file('versus1_img.' . $key)->store('quiz', 'public');
				}
				// archivo viejo
				if ($request->filled('versus2_old.' . $key)) {
					$archivov2 = $request->input('versus2_old.' . $key);
				}
				if ($request->hasFile('versus2_img.' . $key) && $request->file('versus2_img.' . $key)->isValid()) {
					// delete the old file
					if ($archivov2 !== NULL && Storage::exists($archivov2)) {
						Storage::delete($archivov2);
					}
					$archivov2 = $request->file('versus2_img.' . $key)->store('quiz', 'public');
				}
			}
			$pregunta = ClienteQuizPregunta::create([
				'quiz_id' => $quiz->id,
				'pregunta' => $value,
				'tipo' => $tipo,
				'valor' => (double) $data['valor'][$key] ?? 0,
				'archivo' => $archivo,
				'iconos' => $request->boolean('iconos.'.$key),
			]);
			// store the answers
			if ($tipo == 'option') {
				foreach($data['respuesta'][$key] as $k => $v) {
					$pregunta->respuestas()->create([
						'respuesta' => $v,
						'correcta' => intval($data['correcta'][$key]) === $k,
						'tipo' => $tipo,
					]);
				}
			} elseif ($tipo == 'open') {
				$pregunta->respuestas()->create([
					'respuesta' => 'Respuesta abierta',
					'correcta' => true,
					'tipo' => $tipo,
				]);
			} elseif ($tipo == 'multi') {
				// dd(array_map('intval', $data['correcta2'][$key]));
				foreach($data['respuesta2'][$key] as $k => $v) {
					$pregunta->respuestas()->create([
						'respuesta' => $v,
						'correcta' => in_array($k, array_map('intval', $data['correcta2'][$key])),
						'tipo' => $tipo,
					]);
				}
			} elseif ($tipo == 'like') {
				$pregunta->respuestas()->create([
					'respuesta' => $request->input('like-text.'.$key),
					'correcta' => intval($request->input('like-correcta.'.$key)) === 1,
					'tipo' => 'like',
				]);
				$pregunta->respuestas()->create([
					'respuesta' => $request->input('dislike-text.'.$key),
					'correcta' => intval($request->input('like-correcta.'.$key)) === 2,
					'tipo' => 'dislike',
				]);
			} elseif ($tipo == 'level') {
				$pregunta->respuestas()->create([
					'respuesta' => $request->input('level-low.'.$key),
					'correcta' => false,
					'tipo' => 'low',
				]);
				$pregunta->respuestas()->create([
					'respuesta' => $request->input('level-high.'.$key),
					'correcta' => true,
					'tipo' => 'high',
				]);
			} elseif ($tipo == 'versus') {
				$pregunta->respuestas()->create([
					'respuesta' => $request->input('versus1-text.'.$key),
					'correcta' => intval($request->input('versus-correcta.'.$key)) === 1,
					'tipo' => 'versus',
					'archivo' => $archivov1,
				]);
				$pregunta->respuestas()->create([
					'respuesta' => $request->input('versus2-text.'.$key),
					'correcta' => intval($request->input('versus-correcta.'.$key)) === 2,
					'tipo' => 'versus',
					'archivo' => $archivov2,
				]);
			}
		}
		// dd($data);
		return redirect()->route('cliente.quiz.edit', ['cliente' => $cliente->id, 'quiz' => $quiz->id])->with('success', 'Quiz actualizado correctamente.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ClienteQuiz  $quiz
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Cliente $cliente, ClienteQuiz $quiz)
	{
		//
	}
}
