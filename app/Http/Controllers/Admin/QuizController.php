<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cliente;
use App\Models\ClienteQuiz;
use Illuminate\Http\Request;
use App\Models\QuizRespuestas;
use Illuminate\Support\Facades\DB;
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
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function stats(Cliente $cliente, ClienteQuiz $quiz)
	{
		$totales = 0;
		if ($quiz->preguntas->first() !== NULL) {
			$totales = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $quiz->preguntas->first()->id)->count();
		}
		$respuestas = [];
		$preguntas = QuizRespuestas::where('quiz_id', $quiz->id)->groupBy('pregunta_id')->select('id', 'user_id', 'pregunta_id', 'tipo', 'respuesta_id')->get();
		foreach ($preguntas as $pregunta) {
			$respuestas[$pregunta->pregunta->id]['pregunta'] = $pregunta->pregunta;
			$respuestas[$pregunta->pregunta->id]['respuesta'] = $pregunta->respuesta;
			if ($pregunta->tipo === 'open') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta')->get();
			} elseif ($pregunta->tipo === 'level') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta')->get();
				// calculate average
				$respuestas[$pregunta->pregunta->id]['promedio'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->avg('puntos');
			} elseif ($pregunta->tipo === 'like') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
				// calculate percentage of each answer
				$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
				foreach ($respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
					$respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
				}
			} elseif ($pregunta->tipo === 'versus') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
				// calculate percentage of each answer
				$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
				foreach ($respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
					$respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
				}
			} elseif ($pregunta->tipo === 'option' || $pregunta->tipo === 'multi') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
				// calculate percentage of each answer
				$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
				foreach ($respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
					$respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
				}
				$respuestas[$pregunta->pregunta->id]['dataset'] = [
					'labels' => $respuestas[$pregunta->pregunta->id]['respuestas']->pluck('respuesta')->toArray(),
					'data' => $respuestas[$pregunta->pregunta->id]['respuestas']->pluck('total')->toArray(),
				];
			}
		}
		// dd($respuestas[6]);
		return view('dashboard.quiz.stats', compact('cliente', 'respuestas', 'totales'));
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
		$campos = $request->safe()->except(['imagen']);
		// $campos['cliente_id'] = $cliente->id;
		$campos['activa'] = $request->boolean('activa');
		$campos['score'] = $request->boolean('score');
		$campos['random'] = $request->boolean('random');
		$campos['calificacion'] = $request->boolean('calificacion');
		$campos['login'] = $request->boolean('login');
		if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
			$campos['imagen'] = $request->file('imagen')->store('quiz', 'public');
		}
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
		if ($request->filled('login')) {
			$quiz->update(['login' => $request->boolean('login')]);
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
		// store the questions
		$orden = 0;
		foreach ($data['pregunta'] as $key => $value) {
			$tipo = $data['tipo'][$key];
			$id = (int) $data['pregunta_id'][$key];
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
			if ($id > 0) {
				$pregunta = ClienteQuizPregunta::findOrFail($id);
			} else {
				$pregunta = new ClienteQuizPregunta;
			}
			$pregunta->fill([
				'quiz_id' => $quiz->id,
				'pregunta' => $value,
				'tipo' => $tipo,
				'orden' => $orden,
				'valor' => (double) $data['valor'][$key] ?? 0,
				'archivo' => $archivo,
				'iconos' => $request->boolean('iconos.'.$key),
			]);
			$pregunta->save();
			$orden++;
			// store the answers
			if ($tipo == 'option') {
				$orden2 = 0;
				// dd($data['respuesta'], $data['respuesta_id']);
				foreach($data['respuesta'][$key] as $k => $v) {
					$id = (int) $data['respuesta_id'][$key][$k];
					if ($id > 0) {
						$respuesta = ClienteQuizRespuesta::findOrFail($id);
					} else {
						$respuesta = new ClienteQuizRespuesta;
					}
					$respuesta->fill([
						'pregunta_id' => $pregunta->id,
						'respuesta' => $v,
						'correcta' => intval($data['correcta'][$key]) === $k,
						'tipo' => $tipo,
						'orden' => $orden2,
					]);
					$respuesta->save();
					$orden2++;
				}
			} elseif ($tipo == 'open') {
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'respuesta' => 'Respuesta abierta',
					'tipo' => $tipo,
				], [
					'correcta' => true,
				]);
			} elseif ($tipo == 'multi') {
				$orden2 = 0;
				// dd($data['respuesta'], $data['respuesta_id']);
				foreach($data['respuesta2'][$key] as $k => $v) {
					$id = (int) $data['respuesta2_id'][$key][$k];
					if ($id > 0) {
						$respuesta = ClienteQuizRespuesta::findOrFail($id);
					} else {
						$respuesta = new ClienteQuizRespuesta;
					}
					$respuesta->fill([
						'pregunta_id' => $pregunta->id,
						'respuesta' => $v,
						'correcta' => in_array($k, array_map('intval', $data['correcta2'][$key])),
						'tipo' => $tipo,
						'orden' => $orden2,
					]);
					$respuesta->save();
					$orden2++;
				}
			} elseif ($tipo == 'like') {
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'tipo' => 'like',
				], [
					'respuesta' => $request->input('like-text.'.$key),
					'correcta' => intval($request->input('like-correcta.'.$key)) === 1,
				]);
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'tipo' => 'dislike',
				], [
					'respuesta' => $request->input('dislike-text.'.$key),
					'correcta' => intval($request->input('like-correcta.'.$key)) === 2,
				]);
			} elseif ($tipo == 'level') {
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'tipo' => 'low',
				], [
					'respuesta' => $request->input('level-low.'.$key),
					'correcta' => false,
				]);
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'tipo' => 'high',
				], [
					'respuesta' => $request->input('level-high.'.$key),
					'correcta' => false,
				]);
			} elseif ($tipo == 'versus') {
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'tipo' => 'versus1',
				], [
					'respuesta' => $request->input('versus1-text.'.$key),
					'correcta' => intval($request->input('versus-correcta.'.$key)) === 1,
					'archivo' => $archivov1,
				]);
				ClienteQuizRespuesta::updateOrCreate([
					'pregunta_id' => $pregunta->id,
					'tipo' => 'versus2',
				], [
					'respuesta' => $request->input('versus2-text.'.$key),
					'correcta' => intval($request->input('versus-correcta.'.$key)) === 2,
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
