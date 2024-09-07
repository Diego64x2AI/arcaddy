<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
	use HasFactory;

	protected $fillable = [
		'nombre',
		'logo',
	];

	public $timestamps = true;

	protected $casts = [
		// 'payed_at' => 'datetime',
	];

	protected $with = ['miembros'];

	public function miembros()
	{
		return $this->hasMany(GrupoMiembro::class, 'grupo_id', 'id');
	}
}
