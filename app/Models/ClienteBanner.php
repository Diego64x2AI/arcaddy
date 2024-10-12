<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteBanner extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'titulo',
		'link',
		'activo',
	];

	public $timestamps = false;

	protected $with = [
		// 'cliente',
		'sucursales',
	];

	protected $casts = [
		'activo' => 'boolean',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function sucursales()
	{
		return $this->hasMany(ClienteBannerSucursal::class, 'banner_id', 'id');
	}
}
