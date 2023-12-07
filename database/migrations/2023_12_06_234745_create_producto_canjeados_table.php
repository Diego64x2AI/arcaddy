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
		Schema::create('producto_canjeados', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('evento_id');
			$table->unsignedBigInteger('producto_id');
			$table->text('codigo');
			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('producto_id')->references('id')->on('cliente_productos')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('producto_canjeados');
	}
};
