<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientePatrocinadores extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente_id',
		'archivo',
		'titulo',
	];

	public $timeStamps = false;

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}
}
