<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBeneficio extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'producto_id',
		'cliente_id',
		'fecha_canje',
		'quiz_id',
		'canjeado',
		'codigo',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [

	];
	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'fecha_canje' => 'datetime',
		'canjeado' => 'boolean',
	];

	public function producto() {
		return $this->belongsTo(ClienteProducto::class, 'producto_id', 'id');
	}
	public function cliente() {
		return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
	}
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	public function quiz() {
		return $this->belongsTo(ClienteQuiz::class, 'quiz_id', 'id');
	}
}
