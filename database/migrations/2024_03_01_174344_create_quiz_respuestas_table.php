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
		Schema::create('quiz_respuestas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('quiz_id');
			$table->unsignedBigInteger('respuesta_id');
			$table->text('pregunta');
			$table->decimal('puntos', 12, 2)->default(0);
			$table->text('respuesta');
			$table->string('tipo');
			$table->string('archivo')->nullable();
			$table->string('archivo_respuesta')->nullable();
			$table->boolean('correcta')->default(false);
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('quiz_id')->references('id')->on('cliente_quizzes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('quiz_respuestas');
	}
};
