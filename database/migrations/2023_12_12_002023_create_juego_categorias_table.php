<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('juego_categorias', function (Blueprint $table) {
			$table->id();
			$table->string('nombre')->nullable();
			$table->string('slug')->nullable();
			$table->boolean('activo')->default(1);
			$table->boolean('borrado')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('juego_categorias');
	}
};
