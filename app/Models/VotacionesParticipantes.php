<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotacionesParticipantes extends Model
{
	use HasFactory;

	protected $fillable = [
		'titulo',
		'link',
		'descripcion',
		'imagen',
		'user_id',
		'votacion_id',
		'categoria_id',
		'activa',
		'finalista',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'activa' => 'boolean',
		'finalista' => 'boolean',
	];

	protected $with = ['user'];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function votacion()
	{
		return $this->belongsTo(Votaciones::class, 'votacion_id');
	}
}
