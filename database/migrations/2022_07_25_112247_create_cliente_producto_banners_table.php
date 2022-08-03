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
		Schema::create('cliente_producto_banners', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('producto_id');
			$table->string('archivo');
			$table->string('titulo')->nullable();

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
		Schema::dropIfExists('cliente_producto_banners');
	}
};
