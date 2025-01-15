<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
  use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'ip',
		'iso_code',
		'country',
		'city',
		'state',
		'state_name',
		'timezone',
		'continent',
		'so',
		'language',
		'browser',
		'lon',
		'lat',
		'url',
		'model',
		'model_id',
		'user_id',
		'cliente_id',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	protected $with = [];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
