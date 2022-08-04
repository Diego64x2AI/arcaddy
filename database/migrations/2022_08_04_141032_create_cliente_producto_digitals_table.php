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
		Schema::create('cliente_producto_digitals', function (Blueprint $table) {
			$table->id();
			$table->boolean('canjeado')->default(false);
			$table->timestamp('canjeado_at')->nullable();
			$table->timestamps();
			$table->unsignedBigInteger('producto_id');

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
		Schema::dropIfExists('cliente_producto_digitals');
	}
};
