<?php

namespace App\Http\Controllers\Api;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\JuegoResultado;
use App\Http\Controllers\Controller;

class RankingsController extends Controller
{
	public function rankings(Cliente $cliente)
	{
		$scores = JuegoResultado::whereIn('juego_id', $cliente->juegos->pluck('id')->toArray())->orderBy('tiempo', 'asc')->orderBy('errores', 'asc')->paginate(10);
		return $scores;
	}
}
