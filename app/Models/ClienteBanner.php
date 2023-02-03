<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteBanner extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'titulo',
		'link'
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
