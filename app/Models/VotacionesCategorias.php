<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotacionesCategorias extends Model
{
	use HasFactory;

	protected $fillable = [
		'nombre',
		'votacion_id',
		'activa',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'activa' => 'boolean',
	];

	protected $with = [];

	public $timestamps = false;

}
