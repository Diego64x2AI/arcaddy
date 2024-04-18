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
		Schema::create('cliente_carteleras', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('categoria');
			$table->string('titulo')->nullable();
			$table->string('expositor')->nullable();
			$table->string('descripcion')->nullable();
			$table->string('hora')->nullable();
			$table->string('fecha')->nullable();
			$table->string('lugar')->nullable();
			$table->string('archivo')->nullable();
			$table->boolean('inter')->default(false);

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
		Schema::dropIfExists('cliente_carteleras');
	}
};
