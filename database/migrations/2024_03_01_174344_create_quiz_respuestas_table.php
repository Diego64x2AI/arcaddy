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
			$table->unsignedBigInteger('user_id')->nullable();
			$table->unsignedBigInteger('quiz_id');
			$table->unsignedBigInteger('pregunta_id');
			$table->unsignedBigInteger('respuesta_id');
			$table->decimal('puntos', 12, 2)->default(0);
			$table->text('respuesta');
			$table->string('tipo');
			$table->boolean('correcta')->default(false);
			$table->timestamps();

			$table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
			$table->foreign('quiz_id')->references('id')->on('cliente_quizzes')->onDelete('cascade');
			$table->foreign('pregunta_id')->references('id')->on('cliente_quiz_preguntas')->onDelete('cascade');
			$table->foreign('respuesta_id')->references('id')->on('cliente_quiz_respuestas')->onDelete('cascade');
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
