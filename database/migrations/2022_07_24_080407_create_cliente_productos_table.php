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
		Schema::create('cliente_productos', function (Blueprint $table) {
			$table->id();
			$table->string('nombre');
			$table->string('sku');
			$table->text('descripcion')->nullable();
			$table->decimal('precio', 12, 2)->default(0);
			$table->unsignedTinyInteger('descuento')->default(0);
			$table->unsignedBigInteger('cliente_id');

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
		Schema::dropIfExists('cliente_productos');
	}
};
