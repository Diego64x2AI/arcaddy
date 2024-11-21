<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealidadAumentada extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'cliente_id',
		'titulo',
		'slug',
		'descripcion',
		'glb',
		'usdz',
		'imagen',
		'texto',
		'boton_texto',
		'lecturas',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [

	];

	protected $with = [
		'cliente',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
