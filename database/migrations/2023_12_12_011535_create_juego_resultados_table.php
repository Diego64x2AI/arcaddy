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
		Schema::create('juego_resultados', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('juego_id');
			$table->unsignedBigInteger('user_id');
			$table->bigInteger('tiempo')->nullable();
			$table->bigInteger('errores')->nullable();
			$table->bigInteger('aciertos')->nullable();
			$table->bigInteger('puntos')->nullable();
			$table->boolean('activo')->default(1);
			$table->boolean('borrado')->default(0);
			$table->timestamps();

			$table->foreign('juego_id')->references('id')->on('juego')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('juego_resultados');
	}
};
