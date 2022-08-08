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
		'orden',
		'activa',
	];

	public $timestamps = false;

	protected $casts = [
		'activa' => 'boolean',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
