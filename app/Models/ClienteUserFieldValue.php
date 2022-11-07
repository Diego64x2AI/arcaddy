<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteUserFieldValue extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'user_id',
		'campo_id',
		'valor',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [

	];
}
