<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Juego extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'juego';

	protected $guarded = [];

	public $timestamps = false;

	protected $casts = [
		'activo' => 'boolean'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function categoria()
	{
		return $this->belongsTo(JuegoCategoria::class, 'juego_categoria_id');
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
