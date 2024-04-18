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
		Schema::create('cliente_marco_galerias', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			// optional user id
			$table->unsignedBigInteger('user_id')->nullable();
			$table->string('archivo');
			$table->string('titulo')->nullable();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
			$table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_marco_galerias');
	}
};
