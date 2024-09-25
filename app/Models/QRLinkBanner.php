<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRLinkBanner extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'qrlink_id',
		'archivo',
		'titulo',
		'link',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [

	];
}
