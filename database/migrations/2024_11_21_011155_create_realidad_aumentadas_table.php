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
		Schema::create('realidad_aumentadas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('titulo');
			$table->string('slug');
			$table->string('descripcion')->nullable();
			$table->string('glb')->nullable();
			$table->string('usdz')->nullable();
			$table->string('imagen')->nullable();
			$table->longText('texto')->nullable();
			$table->string('boton_texto')->nullable();
			$table->unsignedBigInteger('lecturas')->default(0);

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
		Schema::dropIfExists('realidad_aumentadas');
	}
};
