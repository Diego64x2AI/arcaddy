<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
	use HasFactory;

	protected $table = 'juego';

	protected $guarded = [];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
	
	public function categoria()
	{
		return $this->belongsTo(JuegoCategoria::class,'juego_categoria_id');
	}
	
	public function cartas()
	{
		return $this->hasMany(JuegoCarta::class, 'juego_id', 'id');
	}
	
	public function resultados()
	{
		return $this->hasMany(JuegoResultado::class, 'juego_id', 'id');
	}

	
}