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
		Schema::create('juego_cartas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('juego_id');
			$table->string('imagen')->nullable();
			$table->boolean('frente')->default(1);
			$table->boolean('activo')->default(1);
			$table->boolean('borrado')->default(0);
			$table->timestamps();

			$table->foreign('juego_id')->references('id')->on('juego')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('juego_cartas');
	}
};
