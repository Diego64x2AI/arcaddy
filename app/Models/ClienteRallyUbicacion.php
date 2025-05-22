<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRallyUbicacion extends Model
{
	use HasFactory;

	protected $fillable = [
		'rally_id',
		'titulo',
		'descripcion',
		'fuera_rango',
		'btn_titulo',
		'btn_link',
		'distancia',
		'lat',
		'lng',
		'imagen',
		'marker',
		'ver_mapa',
		'completados',
		'cupon',
	];

	public $timestamps = false;

	protected $casts = [
		'ver_mapa' => 'boolean',
		'cupon' => 'boolean',
	];

	public function rally()
	{
		return $this->belongsTo(ClienteRally::class);
	}

	public function completados()
	{
		return $this->hasMany(ClienteRallyUbicacionCompletados::class);
	}
}
