<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuegoCarta extends Model
{
	use HasFactory;

	protected $table = 'juego_cartas';

	protected $guarded = [];

	public function juego()
	{
		return $this->belongsTo(Juego::class);
	}
	
}