<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
	use HasFactory;

	protected $fillable = [
		'payment_id',
		'status',
		'user_id',
		'total',
		'recibido',
		'envio',
		'payed_at',
		'direccion',
		'response',
	];

	public $timestamps = true;

	protected $casts = [
		'payed_at' => 'datetime',
	];

	protected $with = ['user', 'productos'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function productos()
	{
		return $this->hasMany(PedidoProducto::class, 'pedido_id', 'id');
	}
}
