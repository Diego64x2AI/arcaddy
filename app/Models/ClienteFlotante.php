<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteFlotante extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'icono',
		'texto',
		'link',
		'target',
		'color',
		'posicion',
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo('App\Models\Cliente');
	}
}
