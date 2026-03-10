<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRallySucursal extends Model
{
	use HasFactory;

	protected $fillable = [
		'rally_id',
		'sucursal_id',
	];

	public $timestamps = false;

	protected $with = [
		'sucursal',
	];

	public function rally()
	{
		return $this->belongsTo(ClienteRally::class);
	}

	public function sucursal()
	{
		return $this->belongsTo(ClienteSucursal::class);
	}
}
