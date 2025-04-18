<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Juego;
use App\Models\QRLink;
use App\Models\Visita;
use App\Models\Cliente;
use App\Models\ClienteQuiz;
use Illuminate\Http\Request;
use App\Models\JuegoResultado;
use App\Models\QuizRespuestas;
use App\Models\ClienteProducto;
use App\Models\ClienteSucursal;
use App\Models\ProductoCanjeado;
use App\Models\RealidadAumentada;
use Illuminate\Support\Facades\DB;
use App\Models\ClienteMarcoGaleria;
use App\Http\Controllers\Controller;
use App\Models\ClienteQRExperiencia;
use App\Models\ClienteQuizRespuesta;
use App\Models\UserQr;

class ClienteEstadisticas extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Cliente $cliente, Request $request)
	{
		$canjes = ClienteProducto::with(['canjeados'])->where('cliente_id', $cliente->id)->where('regalado', 1)->take(5)->get();
		// dd($canjes);
		$visitas = Visita::select('id', 'url', 'cliente_id', 'model', 'model_id', DB::raw('count(*) as total'))->where('cliente_id', $cliente->id)->groupBy('url')->orderBy('total', 'desc')->take(10)->get();
		// get the top users by visits
		$top_users = Visita::select('user_id', 'cliente_id', DB::raw('count(*) as total'))->with(['user'])->where('cliente_id', $cliente->id)->whereNotNull('user_id')->groupBy('user_id')->orderBy('total', 'desc')->take(10)->get();
		$qrlinks = QRLink::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$realidades = RealidadAumentada::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$sucursales = ClienteSucursal::where('cliente_id', $cliente->id)->orderBy('lecturas', 'desc')->take(5)->get();
		$marcos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->inRandomOrder()->take(9)->get();
		$marcos_compartidos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->where('compartida', 1)->count();
		$marcos_subidos = ClienteMarcoGaleria::where('cliente_id', $cliente->id)->count();
		$totales = [
			'visitas' => Visita::where('cliente_id', $cliente->id)->count(),
			'usuarios' => User::where('cliente_id', $cliente->id)->count(),
			'redenciones' => ProductoCanjeado::where('cliente_id', $cliente->id)->count(),
			'productos' => ClienteProducto::where('cliente_id', $cliente->id)->count(),
			'admisiones' => UserQr::where('cliente_id', $cliente->id)->where('usado', 1)->count(),
			'activaciones' => ClienteQRExperiencia::where('cliente_id', $cliente->id)->sum('visitas'),
		];
		$juegos = Juego::where('cliente_id', $cliente->id)->where('activo', 1)->orderBy('id', 'desc')->get();
		$games = [];
		foreach ($juegos as $juego) {
			$games[] = [
				'id' => $juego->id,
				'nombre' => $juego->nombre,
				'visitas' => Visita::where('cliente_id', $cliente->id)->where('model', '\App\Models\Juego')->where('model_id', $juego->id)->count(),
				'scores' => JuegoResultado::where('juego_id', $juego->id)->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->take(10)->get(),
			];
		}
		$quiz = ClienteQuiz::where('cliente_id', $cliente->id)->where('activa', 1)->orderBy('id', 'desc')->first();
		$quiz_totales = 0;
		$quiz_respuestas = [];
		if ($quiz !== NULL) {
			if ($quiz->preguntas->first() !== NULL) {
				$quiz_totales = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $quiz->preguntas->first()->id)->count();
			}
			$preguntas = QuizRespuestas::where('quiz_id', $quiz->id)->groupBy('pregunta_id')->select('id', 'user_id', 'pregunta_id', 'tipo', 'respuesta_id')->get();
			foreach ($preguntas as $pregunta) {
				$quiz_respuestas[$pregunta->pregunta->id]['pregunta'] = $pregunta->pregunta;
				$quiz_respuestas[$pregunta->pregunta->id]['respuesta'] = $pregunta->respuesta;
				if ($pregunta->pregunta->tipo === 'open') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta')->get();
				} elseif ($pregunta->pregunta->tipo === 'level') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta')->get();
					// calculate average
					$quiz_respuestas[$pregunta->pregunta->id]['promedio'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->avg('puntos');
				} elseif ($pregunta->pregunta->tipo === 'like') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
					// calculate percentage of each answer
					$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
					foreach ($quiz_respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
						$quiz_respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
					}
				} elseif ($pregunta->pregunta->tipo === 'versus') {
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::with([])->where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
					// calculate percentage of each answer
					$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
					foreach ($quiz_respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
						$quiz_respuestas[$pregunta->pregunta->id]['respuestas'][$key]['porcentaje'] = ($value->total / $total) * 100;
					}
				} elseif ($pregunta->pregunta->tipo === 'option' || $pregunta->pregunta->tipo === 'multi') {
					// $quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->groupBy('respuesta')->select('respuesta', 'respuesta_id', DB::raw('count(*) as total'))->get();
					$quiz_respuestas[$pregunta->pregunta->id]['respuestas'] = ClienteQuizRespuesta::where('pregunta_id', $pregunta->pregunta->id)->get();
					$total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->count();
					foreach ($quiz_respuestas[$pregunta->pregunta->id]['respuestas'] as $key => $value) {
						$value->total = QuizRespuestas::where('quiz_id', $quiz->id)->where('pregunta_id', $pregunta->pregunta->id)->where('respuesta_id', $value->id)->groupBy('respuesta_id')->count();
						$value->porcentaje = ($value->total / $total) * 100;
					}
					$quiz_respuestas[$pregunta->pregunta->id]['dataset'] = [
						'labels' => $quiz_respuestas[$pregunta->pregunta->id]['respuestas']->pluck('respuesta')->toArray(),
						'data' => $quiz_respuestas[$pregunta->pregunta->id]['respuestas']->pluck('total')->toArray(),
					];
				}
			}
		}
		return view('dashboard.estadisticas.index', compact('cliente', 'quiz', 'canjes', 'quiz_totales', 'top_users', 'quiz_respuestas', 'totales', 'games', 'visitas', 'qrlinks', 'realidades', 'sucursales', 'marcos', 'marcos_compartidos', 'marcos_subidos'));
	}
}
