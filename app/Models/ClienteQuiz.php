<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteQuiz extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'cliente_id',
		'activa',
		'score',
		'random',
		'calificacion',
		'login',
		'imagen',
		'felicidades_text',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'activa' => 'boolean',
		'random' => 'boolean',
		'calificacion' => 'boolean',
		'score' => 'boolean',
		'login' => 'boolean',
	];

	protected $with = ['preguntas', 'preguntas.respuestas'];

	public function preguntas()
	{
		return $this->hasMany(ClienteQuizPregunta::class, 'quiz_id', 'id')->orderBy('orden');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
