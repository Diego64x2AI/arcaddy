<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteExperiencia extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'titulo',
		'link',
		'descripcion',
		'texto_boton',
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo('App\Models\Cliente');
	}
}
