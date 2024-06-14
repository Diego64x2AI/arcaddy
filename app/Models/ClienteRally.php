<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRally extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'titulo',
		'banner',
		'activo',
		'geo_oculto',
		'vista',
	];

	public $timestamps = false;

	protected $casts = [
		'activo' => 'boolean',
		'geo_oculto' => 'boolean',
	];

	protected $with = ['ubicaciones'];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function ubicaciones()
	{
		return $this->hasMany(ClienteRallyUbicacion::class, 'rally_id');
	}
}
