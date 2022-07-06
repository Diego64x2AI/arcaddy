<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientePlaylist extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'plataforma',
		'link',
	];

	public $timestamps = false;

	public function cliente()
	{
		return $this->belongsTo('App\Models\Cliente');
	}
}
