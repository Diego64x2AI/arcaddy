<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use App\Models\ClienteSecciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FillModulos extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$clientes = Cliente::all();
		$secciones = [
			'banners',
			'descriptivos',
			'colaboradores',
			'patrocinadores',
			'blog',
			'galeria',
			'playlist',
			'experiencia',
			'libres',
			'live',
			'social',
			'productos',
			'banners2',
			'menu',
			'ranking',
			'quiz',
			'marco',
			'cartelera',
			'galeriamarcos',
			'rally',
		];
		$titulos = [
			'banners' => 'Banners',
			'descriptivos' => 'Descriptivos',
			'colaboradores' => 'Colaboradores',
			'patrocinadores' => 'Patrocinadores',
			'blog' => 'Blog',
			'galeria' => 'Galería',
			'playlist' => 'Playlist',
			'experiencia' => 'Experiencia',
			'libres' => 'Libres',
			'live' => 'Live',
			'social' => 'Social',
			'productos' => 'Productos',
			'banners2' => 'Banners 2',
			'menu' => 'Menú / Catálogo / Producto o servicio',
			'ranking' => 'Ranking',
			'quiz' => 'Quiz',
			'marco' => 'Marco / Photoop',
			'cartelera' => 'Cartelera / Temario',
			'galeriamarcos' => 'Galería de Marcos',
			'rally' => 'Rally',
		];
		foreach ($clientes as $cliente) {
			foreach ($secciones as $seccion) {
				if (ClienteSecciones::where('cliente_id', $cliente->id)->where('seccion', $seccion)->count() === 0) {
					$cliente->secciones()->create([
						'cliente_id' => $cliente->id,
						'seccion' => $seccion,
						'titulo' => $titulos[$seccion],
						'mostrar_titulo' => true,
						'orden' => ClienteSecciones::where('cliente_id', $cliente->id)->count(),
						'activa' => false,
					]);
				}
			}
		}
	}
}
