<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuegoResultado extends Model
{
	use HasFactory;

	protected $table = 'juego_resultados';

	protected $guarded = [];

	public function juego()
	{
		return $this->belongsTo(Juego::class);
	}
	
}