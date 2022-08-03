<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteProductoBanner extends Model
{
	use HasFactory;

	protected $fillable = [
		'producto_id',
		'archivo',
		'titulo',
	];

	public $timeStamps = false;

	public function producto()
	{
		return $this->belongsTo(ClienteProducto::class);
	}
}
