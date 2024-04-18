<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JuegoCategoria extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'juego_categorias';

	protected $guarded = [];

	public $timestamps = false;

	protected $casts = [
		'activo' => 'boolean'
	];

	public function juegos()
	{
		return $this->hasMany(Juego::class, 'juego_categoria_id', 'id');
	}

}
