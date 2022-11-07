<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteUserField extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'cliente_id',
		'campo_id',
		'nombre',
		'activo'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'activo' => 'boolean',
	];
}
