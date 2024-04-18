<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\JuegoCategoria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JuegosCategoriasSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$juegos = [
			'Memory',
			'Shuffle Puzzle',
		];
		foreach ($juegos as $juego) {
			JuegoCategoria::updateOrCreate(
				[
					'slug' => Str::slug($juego),
				],
				[
					'nombre' => $juego,
					'activo' => true,
				]
			);
		}
	}
}
