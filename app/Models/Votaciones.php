<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votaciones extends Model
{
	use HasFactory;

	protected $fillable = [
		'nombre',
		'cliente_id',
		'finalistas',
		'votar',
		'activa',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'votar' => 'boolean',
		'activa' => 'boolean',
		'finalistas' => 'boolean',
	];

	protected $with = ['categorias', 'participantes'];

	public function categorias()
	{
		return $this->hasMany(VotacionesCategorias::class, 'votacion_id', 'id');
	}

	public function participantes()
	{
		return $this->hasMany(VotacionesParticipantes::class, 'votacion_id', 'id');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
