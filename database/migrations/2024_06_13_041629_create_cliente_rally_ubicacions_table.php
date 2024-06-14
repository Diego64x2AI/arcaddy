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
		Schema::create('cliente_rally_ubicacions', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('rally_id');
			$table->string('titulo');
			$table->string('descripcion')->nullable();
			$table->string('fuera_rango')->nullable();
			$table->string('btn_titulo')->nullable();
			$table->string('btn_link')->nullable();
			$table->unsignedSmallInteger('distancia')->default(0);
			$table->double('lat', 10, 8)->nullable()->default(0);
			$table->double('lng', 11, 8)->nullable()->default(0);
			$table->string('imagen')->nullable();
			$table->string('marker')->nullable();

			$table->foreign('rally_id')->references('id')->on('cliente_rallies')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_rally_ubicacions');
	}
};
