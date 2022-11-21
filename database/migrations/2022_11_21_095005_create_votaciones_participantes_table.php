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
		Schema::create('votaciones_participantes', function (Blueprint $table) {
			$table->id();
			$table->string('titulo')->nullable();
			$table->string('link')->nullable();
			$table->text('descripcion')->nullable();
			$table->string('imagen')->nullable();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('votacion_id');
			$table->unsignedBigInteger('categoria_id');
			$table->boolean('activa')->default(1);
			$table->boolean('finalista')->default(1);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('votacion_id')->references('id')->on('votaciones')->onDelete('cascade');
			$table->foreign('categoria_id')->references('id')->on('votaciones_categorias')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('votaciones_participantes');
	}
};
