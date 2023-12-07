<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuegoCategoria extends Model
{
	use HasFactory;

	protected $table = 'juego_categorias';

	protected $guarded = [];
	
	public function juegos()
	{
		return $this->hasMany(Juego::class, 'juego_categoria_id', 'id');
	}

	
}