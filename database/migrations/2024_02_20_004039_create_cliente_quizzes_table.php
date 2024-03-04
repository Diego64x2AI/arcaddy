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
		Schema::create('cliente_quizzes', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('nombre')->nullable();
			$table->string('imagen')->nullable();
			$table->boolean('activa')->default(0);
			$table->boolean('score')->default(0);
			$table->boolean('random')->default(0);
			$table->boolean('calificacion')->default(0);
			$table->boolean('login')->default(0);

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_quizzes');
	}
};
