<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizRespuestas extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'quiz_id',
		'pregunta_id',
		'respuesta_id',
		'puntos',
		'respuesta',
		'tipo',
		'correcta',
	];

	protected $casts = [
		'correcta' => 'boolean',
		'puntos' => 'decimal:2',
	];

	protected $with = ['quiz', 'user', 'pregunta', 'respuesta'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quiz()
	{
		return $this->belongsTo(ClienteQuiz::class, 'quiz_id');
	}

	public function pregunta()
	{
		return $this->belongsTo(ClienteQuizPregunta::class, 'pregunta_id');
	}

	public function respuesta()
	{
		return $this->belongsTo(ClienteQuizRespuesta::class, 'respuesta_id');
	}
}
