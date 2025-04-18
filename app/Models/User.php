<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;
use function Illuminate\Events\queueable;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'cliente_id',
		'nacimiento',
		'sucursal_id',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function campos() {
		return $this->hasMany(ClienteUserFieldValue::class,  'user_id', 'id');
	}

	// user qr
	public function qr() {
		return $this->hasOne(UserQr::class, 'user_id', 'id');
	}

	public function sucursal() {
		return $this->belongsTo(ClienteSucursal::class, 'sucursal_id', 'id');
	}

	public function canjeados($cliente_id = 0) {
		return ProductoCanjeado::where('user_id', $this->id)->where('cliente_id', $cliente_id)->count();
	}

	public function beneficios($cliente_id = 0) {
		return [
			'ganados' => UserBeneficio::where('user_id', $this->id)->where('cliente_id', $cliente_id)->count(),
			'canjeados' => UserBeneficio::where('user_id', $this->id)->where('cliente_id', $cliente_id)->whereNotNull('fecha_canje')->where('canjeado', 1)->count(),
			'redimidos' => UserBeneficio::where('user_id', $this->id)->where('cliente_id', $cliente_id)->whereNotNull('fecha_canje')->where('canjeado', 0)->count(),
		];
	}

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	/*
	protected static function booted()
	{
		static::updated(queueable(function ($customer) {
			if ($customer->hasStripeId()) {
				$customer->syncStripeCustomerDetails();
			}
		}));
	}
	*/
}
