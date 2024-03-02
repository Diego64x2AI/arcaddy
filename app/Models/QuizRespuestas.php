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
		'pregunta',
		'respuesta_id',
		'puntos',
		'respuesta',
		'tipo',
		'archivo',
		'archivo_respuesta',
		'correcta'
	];

	protected $casts = [
		'correcta' => 'boolean',
		'puntos' => 'decimal:2',
	];

	protected $with = ['quiz', 'user'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quiz()
	{
		return $this->belongsTo(ClienteQuiz::class, 'quiz_id');
	}
}
