<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteColaboradores extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'nombre',
		'talento',
		'descripcion',
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo('App\Models\Cliente');
	}
}
