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
		Schema::create('pedido_productos', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('pedido_id');
			$table->unsignedSmallInteger('cantidad')->default(0);
			$table->unsignedBigInteger('producto_id');
			$table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
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
		Schema::dropIfExists('pedido_productos');
	}
};
