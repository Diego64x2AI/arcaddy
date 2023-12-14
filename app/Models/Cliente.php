<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	use HasFactory;

	protected $fillable = [
		'cliente',
		'slug',
		'color',
		'color_base',
		'color_bg',
		'logo',
		'titulo',
		'subtitulo',
		'descripcion',
		'fecha',
		'facebook_live',
		'facebook',
		'instagram',
		'twitter',
		'tiktok',
		'whatsapp',
		'registro',
		'registro_descripcion',
		'registro_img',
		'password',
		'password_titulo',
		'password_descripcion',
		'geo_bloqueo',
		'geo_codes',
		'idioma',
		'imagen_background',
		'metadescription',
		'login_bloqueo',
		'btn_registro_en_login',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'registro' => 'boolean',
		'geo_bloqueo' => 'integer',
	];

	protected $with = [
		'banners',
		'banners2',
		'colaboradores',
		'secciones',
		'patrocinadores',
		'galeria',
		'libres',
		'blog',
		'playlist',
		'experiencias',
		'productos',
		'campos',
		'votaciones',
		'flotantes',
		'menu',
		'juegos',
	];

	public function menu()
	{
		return $this->hasMany(ClienteMenu::class, 'cliente_id', 'id');
	}

	public function flotantes()
	{
		return $this->hasMany(ClienteFlotante::class, 'cliente_id', 'id');
	}

	public function votaciones()
	{
		return $this->hasMany(Votaciones::class, 'cliente_id', 'id')->where('activa', 1);
	}

	public function campos()
	{
		return $this->hasMany(ClienteUserField::class, 'cliente_id', 'id');
	}

	public function productos()
	{
		return $this->hasMany(ClienteProducto::class, 'cliente_id', 'id');
	}

	public function banners()
	{
		return $this->hasMany(ClienteBanner::class, 'cliente_id', 'id');
	}

	public function banners2()
	{
		return $this->hasMany(ClienteBanner2::class, 'cliente_id', 'id');
	}

	public function colaboradores()
	{
		return $this->hasMany(ClienteColaboradores::class, 'cliente_id', 'id');
	}

	public function secciones()
	{
		return $this->hasMany(ClienteSecciones::class, 'cliente_id', 'id')->orderBy('orden', 'asc');
	}

	public function patrocinadores()
	{
		return $this->hasMany(ClientePatrocinadores::class, 'cliente_id', 'id');
	}

	public function galeria()
	{
		return $this->hasMany(ClienteGaleria::class, 'cliente_id', 'id');
	}

	public function libres()
	{
		return $this->hasMany(ClienteLibres::class, 'cliente_id', 'id');
	}

	public function blog()
	{
		return $this->hasMany(ClienteBlog::class, 'cliente_id', 'id');
	}

	public function playlist()
	{
		return $this->hasMany(ClientePlaylist::class, 'cliente_id', 'id');
	}

	public function experiencias()
	{
		return $this->hasMany(ClienteExperiencia::class, 'cliente_id', 'id');
	}

	public function juegos()
	{
		return $this->hasMany(Juego::class, 'cliente_id', 'id')->where('activo', 1);
	}
}
