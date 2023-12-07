<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQr extends Model
{
	use HasFactory;

	protected $table = 'user_qrs';

	protected $fillable = [
		'cliente_id',
		'user_id',
		'evento_id',
		'codigo',
		'usado'
	];

	

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}