<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteCartelera extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'categoria',
		'titulo',
		'expositor',
		'descripcion',
		'hora',
		'fecha',
		'lugar',
		'archivo',
		'inter',
	];

	public $timestamps = false;

	protected $casts = [
		'fecha' => 'date',
		'inter' => 'boolean',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
