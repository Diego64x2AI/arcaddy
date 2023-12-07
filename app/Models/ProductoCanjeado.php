<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCanjeado extends Model
{
	use HasFactory;

	protected $table = 'producto_canajeados';

	protected $fillable = [
		'cliente_id',
		'user_id',
		'evento_id',
		'producto_id',
		'codigo',
	];

	

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function producto()
	{
		return $this->belongsTo(ClienteProducto::class);
	}
}