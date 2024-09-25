<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRLink extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'cliente_id',
		'titulo',
		'slug',
		'texto',
		'boton_texto',
		'boton_link',
		'banners',
		'lecturas',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'banners' => 'boolean',
	];

	protected $with = [
		'banners2',
		'cliente',
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function banners2()
	{
		return $this->hasMany(QRLinkBanner::class, 'qrlink_id');
	}
}
