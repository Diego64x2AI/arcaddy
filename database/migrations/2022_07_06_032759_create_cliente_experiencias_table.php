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
		Schema::create('cliente_experiencias', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('archivo');
			$table->string('titulo')->nullable();
			$table->string('link')->nullable();
			$table->text('descripcion')->nullable();

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
		Schema::dropIfExists('cliente_experiencias');
	}
};
