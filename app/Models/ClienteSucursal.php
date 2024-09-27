<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteSucursal extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'cliente_id',
		'nombre',
		'telefono',
		'direccion',
		'ciudad',
		'horario',
		'link_titulo',
		'link',
		'lat',
		'lng',
		'lecturas',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [

	];

	protected $with = [];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
