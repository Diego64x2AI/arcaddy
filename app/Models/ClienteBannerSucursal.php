<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteBannerSucursal extends Model
{
	use HasFactory;

	protected $fillable = [
		'banner_id',
		'sucursal_id',
	];

	public $timestamps = false;

	protected $with = [
		// 'cliente',
		// 'banner',
		'sucursal',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function banner()
	{
		return $this->belongsTo(ClienteBanner::class);
	}

	public function sucursal()
	{
		return $this->belongsTo(ClienteSucursal::class);
	}
}
