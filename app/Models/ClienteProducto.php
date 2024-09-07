<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteProducto extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'nombre',
		'sku',
		'descripcion',
		'precio',
		'descuento',
		'digital',
		'regalado',
		'grupos',
	];

	public $timestamps = false;

	protected $casts = [
		'precio' => 'float',
		'descuento' => 'float',
		'digital' => 'boolean',
		'grupos' => 'boolean',
		'regalado' => 'boolean',
	];

	protected $with = ['imagenes'];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function imagenes()
	{
		return $this->hasMany(ClienteProductoBanner::class, 'producto_id', 'id');
	}
}
