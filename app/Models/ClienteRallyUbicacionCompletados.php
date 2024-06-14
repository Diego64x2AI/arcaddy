<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRallyUbicacionCompletados extends Model
{
	use HasFactory;

	protected $fillable = [
		'ubicacion_id',
		'user_id',
		'distancia',
		'lat',
		'lng',
		'ip',
		'referer',
		'user_agent',
	];

	public $timestamps = true;

	protected $casts = [
		'ver_mapa' => 'boolean',
	];

	public function ubicacion()
	{
		return $this->belongsTo(ClienteRallyUbicacion::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
