<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteMenu extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'nombre',
		'cantidad',
		'precio',
		'boton_titulo',
		'boton_link',
		'canje_texto',
		'descripcion',
		'categoria',
		'orden',
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
