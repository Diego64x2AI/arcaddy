<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteMarcoGaleria extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'user_id',
		'archivo',
		'titulo',
		'aprobada',
		'compartida',
	];

	public $timestamps = false;

	protected $casts = [
		'aprobada' => 'boolean',
		'compartida' => 'boolean',
	];

	protected $with = ['user'];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
