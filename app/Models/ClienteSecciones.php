<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteSecciones extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'seccion',
		'titulo',
		'mostrar_titulo',
		'orden',
		'activa',
		'login',
		'timer',
	];

	public $timestamps = false;

	protected $casts = [
		'activa' => 'boolean',
		'mostrar_titulo' => 'boolean',
		'login' => 'boolean',
		'timer' => 'integer',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
