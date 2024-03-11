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
		Schema::create('cliente_quiz_respuestas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('pregunta_id');
			$table->text('respuesta');
			$table->string('tipo');
			$table->string('archivo')->nullable();
			$table->boolean('correcta')->default(false);

			$table->foreign('pregunta_id')->references('id')->on('cliente_quiz_preguntas')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_quiz_respuestas');
	}
};
