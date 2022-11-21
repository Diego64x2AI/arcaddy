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
		Schema::create('votaciones_categorias', function (Blueprint $table) {
			$table->id();
			$table->string('nombre');
			$table->unsignedBigInteger('votacion_id');
			$table->boolean('activa')->default(1);
			$table->foreign('votacion_id')->references('id')->on('votaciones')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('votaciones_categorias');
	}
};
