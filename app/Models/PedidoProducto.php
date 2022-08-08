<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
	use HasFactory;

	protected $fillable = [
		'pedido_id',
		'cantidad',
		'producto_id',
	];

	public $timestamps = false;

	protected $with = [
		'producto',
	];

	public function pedido()
	{
		return $this->belongsTo(Pedido::class, 'pedido_id', 'id');
	}

	public function producto()
	{
		return $this->belongsTo(ClienteProducto::class, 'producto_id', 'id');
	}
}
