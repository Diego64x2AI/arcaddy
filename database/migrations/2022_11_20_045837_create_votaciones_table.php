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
		Schema::create('votaciones', function (Blueprint $table) {
			$table->id();
			$table->string('nombre');
			$table->unsignedBigInteger('cliente_id');
			$table->boolean('votar')->default(0);
			$table->boolean('finalistas')->default(0);
			$table->boolean('activa')->default(1);
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('votaciones');
	}
};
