<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteQuizRespuesta extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'pregunta_id',
		'respuesta',
		'tipo',
		'archivo',
		'correcta'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'correcta' => 'boolean',
	];

	public function pregunta()
	{
		return $this->belongsTo(ClienteQuizPregunta::class);
	}

}
