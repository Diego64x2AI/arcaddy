<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cliente;
use App\Models\ClienteQuiz;
use Illuminate\Http\Request;
use App\Models\UserBeneficio;
use App\Models\QuizRespuestas;
use Yajra\Datatables\Datatables;
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

	public function respuestas(Cliente $cliente, ClienteQuiz $quiz, ClienteQuizPregunta $pregunta, $respuesta_id = 0)
	{
		$respuesta_original = ClienteQuizRespuesta::where('pregunta_id', $pregunta->id)->where('id', $respuesta_id)->first();
		// $respuesta = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->id)->where('respuesta_id', $respuesta_id)->first();
		return view('dashboard.quiz.respuestas', compact('cliente', 'quiz', 'pregunta', 'respuesta_original'));
	}

	public function respuestas_ajax(Cliente $cliente, ClienteQuiz $quiz, $respuesta_id = 0, Request $request)
	{
		if ($request->ajax()) {
			$query = QuizRespuestas::query();
			$query->where('quiz_id', $quiz->id);
			$query->where('respuesta_id', $respuesta_id);
			// busqueda
			setlocale(LC_CTYPE, 'es_ES');
			$q = trim($request->input('search.value', ''));
			$q = mb_convert_encoding($q, 'UTF-8', mb_detect_encoding($q));
			$q2 = preg_replace("/[^A-Za-z0-9 ]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $q));
			// dd($q, $q2);
			if ($q !== '') {
				$query->where(function ($query) use ($q, $q2) {
					$query->whereHas('user', function ($query) use ($q, $q2) {
						$query->where('name', 'LIKE', '%'.$q.'%')
							->orWhere('email', 'LIKE', '%'.$q.'%');
					});
					$query->orWhere('respuesta', 'LIKE', '%'.$q.'%');
					$query->orWhere('respuesta', 'LIKE', '%'.$q2.'%');
				});
			}
			// dd($query->toSql());
			$data = $query->get();
			// dd($data);
			return DataTables::of($data)
				->addIndexColumn()
				->setRowId('id')
				->editColumn('name', function (QuizRespuestas $respuesta) {
					return $respuesta->user->name;
				})
				->editColumn('email', function (QuizRespuestas $respuesta) {
					return $respuesta->user->email;
				})
				->editColumn('respuesta', function (QuizRespuestas $respuesta) {
					return $respuesta->respuesta;
				})
				->editColumn('created_at', function (QuizRespuestas $respuesta) {
					return $respuesta->created_at->format('Y-m-d H:i:s');
				})
				->addColumn('action', function (QuizRespuestas $respuesta) use ($cliente, $quiz) {
					$actionBtn = '
					<a href="'. route('clientes.quiz.beneficio', ['cliente' => $cliente->id, 'quiz' => $quiz->id, 'user' => $respuesta->user_id]) .'" class="text-sky-500 regalar-beneficio"><i class="fas fa-gift"></i></a>';
					return $actionBtn;
				})
				->rawColumns(['action'])
				->make(true);
		} else {
			abort(404);
		}
	}

	public function beneficio(Cliente $cliente, ClienteQuiz $quiz, User $user)
	{
		UserBeneficio::create([
			'user_id' => $user->id,
			'cliente_id' => $cliente->id,
		]);
		return redirect()->back()->with('success', 'Beneficio regalado correctamente.');
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
			if ($pregunta->pregunta->tipo === 'open') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', 'pregunta_id', 'id')->get();
			} elseif ($pregunta->pregunta->tipo === 'level') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', 'pregunta_id', 'id')->get();
				// calculate average
				$respuestas[$pregunta->pregunta->id]['promedio'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->avg('puntos');
			} elseif ($pregunta->pregunta->tipo === 'like') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
				// calculate percentage of each answer
				$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
				foreach ($respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
					$respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
				}
			} elseif ($pregunta->pregunta->tipo === 'versus') {
				$respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
				// calculate percentage of each answer
				$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
				foreach ($respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
					$respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
				}
			} elseif ($pregunta->pregunta->tipo === 'option' || $pregunta->pregunta->tipo === 'multi') {
				// $respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
				$respuestas[$pregunta->pregunta->id]['respuestas'] = ClienteQuizRespuesta::where('pregunta_id', $pregunta->pregunta->id)->get();
				$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
				foreach ($respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
					$value->total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->where('respuesta_id', $value->id)->groupBy('respuesta_id')->count();
					$value->porcentaje = ($value->total / $total) * 100;
				}
				$respuestas[$pregunta->pregunta->id]['dataset'] = [
					'labels' => $respuestas[$pregunta->pregunta->id]['respuestas']->pluck('respuesta')->toArray(),
					'data' => $respuestas[$pregunta->pregunta->id]['respuestas']->pluck('total')->toArray(),
				];
			}
		}
		// dd($respuestas[310]);
		return view('dashboard.quiz.stats', compact('cliente', 'respuestas', 'totales', 'quiz'));
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
		$campos['cupon'] = $request->boolean('cupon');
		$campos['login'] = $request->boolean('login');
		if ($campos['cupon']) {
			// force login option
			$campos['login'] = true;
		}
		if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
			$campos['imagen'] = $request->file('imagen')->store('quiz', 'public');
		}
		// if is active, deactivate the others
		if ($campos['activa']) {
			$cliente->quiz()->update(['activa' => false]);
		}
		if (!isset($campos['puntos']) || $campos['puntos'] === NULL) {
			$campos['puntos'] = 0;
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
		if ($request->filled('cupon')) {
			if ($request->boolean('cupon')) {
				// force login option
				$quiz->update(['login' => true]);
			}
			$quiz->update(['cupon' => $request->boolean('cupon')]);
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
		if ($request->filled('puntos')) {
			$quiz->update(['puntos' => $request->puntos]);
		}
		if ($request->filled('felicidades_text')) {
			$quiz->update(['felicidades_text' => $request->felicidades_text]);
		}
		if ($request->filled('boton_text')) {
			$quiz->update(['boton_text' => $request->boton_text]);
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
		// delete questions if not in the list
		$preguntas = ClienteQuizPregunta::whereNotIn('id', $data['pregunta_id'])->where('quiz_id', $quiz->id)->get();
		// walk the list and delete local files
		foreach ($preguntas as $pregunta) {
			if ($pregunta->archivo !== NULL && Storage::exists($pregunta->archivo)) {
				Storage::delete($pregunta->archivo);
			}
			$pregunta->delete();
		}
		// store the questions
		$orden = 0;
		foreach ($data['pregunta'] as $key => $value) {
			$tipo = $data['tipo'][$key];
			$id = (int) $data['pregunta_id'][$key];
			$archivo = NULL;
			$archivov1 = NULL;
			$archivov2 = NULL;
			// validate the file if the question is like or level
			if ($tipo === 'like') {
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
			} elseif ($tipo === 'level') {
				$request->validate([
					'archivo_img.'.$key => 'nullable|sometimes|image',
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
		// delete the image if exists
		if ($quiz->imagen !== NULL && Storage::exists($quiz->imagen)) {
			Storage::delete($quiz->imagen);
		}
		$quiz->delete();
		return redirect()->route('cliente.quiz.index', ['cliente' => $cliente->id])->with('success', 'Quiz eliminado correctamente.');
	}
}
