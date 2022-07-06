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
		'logo',
		'titulo',
		'subtitulo',
		'descripcion',
		'fecha',
		'facebook_live',
		'facebook',
		'instagram',
		'twitter',
	];

	protected $with = [
		'banners',
		'colaboradores',
		'secciones',
		'patrocinadores',
		'galeria',
		'libres',
		'blog',
		'playlist',
		'experiencias',
	];

	public function banners()
	{
		return $this->hasMany(ClienteBanner::class, 'cliente_id', 'id');
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
}
