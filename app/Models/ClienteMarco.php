<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteMarco extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'titulo'
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
