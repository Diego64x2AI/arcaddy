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
		Schema::create('user_beneficios', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('producto_id')->nullable();
			$table->unsignedBigInteger('cliente_id')->nullable();
			$table->unsignedBigInteger('quiz_id')->nullable();
			$table->timestamps();
			$table->timestamp('fecha_canje')->nullable();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('producto_id')->references('id')->on('cliente_productos')->onDelete('cascade');
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
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
		Schema::dropIfExists('user_beneficios');
	}
};
