<?php

namespace App\Http\Controllers\Api;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\JuegoResultado;
use App\Models\QuizRespuestas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RankingsController extends Controller
{
	public function rankings(Cliente $cliente)
	{
		$scores = JuegoResultado::whereIn('juego_id', $cliente->juegos->pluck('id')->toArray())->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->paginate(10);
		return $scores;
	}

	public function rankings_quiz(Cliente $cliente)
	{
		$quiz = $cliente->quiz()->where('activa', true)->orderBy('id', 'desc')->first();
		$scores = QuizRespuestas::select('id', 'user_id', DB::raw('SUM(puntos) as total'))->where('quiz_id', (int) $quiz->id)->whereNotNull('user_id')->orderBy('total', 'desc')->groupBy('user_id')->paginate(10);
		return $scores;
	}
}
