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
		Schema::create('cliente_rally_sucursals', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('rally_id');
			$table->unsignedBigInteger('sucursal_id');

			$table->foreign('rally_id')->references('id')->on('cliente_rallies')->onDelete('cascade');
			$table->foreign('sucursal_id')->references('id')->on('cliente_sucursals')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_rally_sucursals');
	}
};
