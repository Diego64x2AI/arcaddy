<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteProductoDigital extends Model
{
  protected $fillable = [
		'canjeado',
		'canjeado_at',
		'producto_id',
	];

	public $timestamps = true;

	protected $casts = [
		'canjeado_at' => 'datetime',
		'canjeado' => 'boolean',
	];

	protected $with = ['producto', 'producto.cliente'];

	public function producto()
	{
		return $this->belongsTo(ClienteProducto::class);
	}

}
