<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campos extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'nombre',
		'editable',
		'info'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'editable' => 'boolean',
		'deleted_at' => 'datetime',
	];
}
