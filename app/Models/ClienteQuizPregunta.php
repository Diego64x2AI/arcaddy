<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteQuizPregunta extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'quiz_id',
		'tipo',
		'pregunta',
		'valor',
		'iconos',
		'archivo',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'iconos' => 'boolean',
	];

	public function quiz()
	{
		return $this->belongsTo(ClienteQuiz::class);
	}

	public function respuestas()
	{
		return $this->hasMany(ClienteQuizRespuesta::class, 'pregunta_id', 'id');
	}
}
