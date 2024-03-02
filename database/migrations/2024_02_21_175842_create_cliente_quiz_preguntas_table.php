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
		Schema::create('cliente_quiz_preguntas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('quiz_id');
			$table->text('pregunta');
			$table->string('tipo')->default('open');
			$table->decimal('valor', 12, 2)->default(0);
			$table->string('archivo')->nullable();
			$table->boolean('iconos')->default(false);

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
		Schema::dropIfExists('cliente_quiz_preguntas');
	}
};
