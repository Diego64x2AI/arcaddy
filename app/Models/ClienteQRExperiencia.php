<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteQRExperiencia extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'titulo',
		'url',
		'tipo',
		'lat',
		'lng',
		'map_marker',
		'visitas',
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
