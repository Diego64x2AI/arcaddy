<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoMiembro extends Model
{
  use HasFactory;

	protected $fillable = [
		'grupo_id',
		'cliente_id',
	];

	public $timestamps = false;

	protected $casts = [
		// 'payed_at' => 'datetime',
	];

	protected $with = ['cliente'];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class);
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
	}
}
