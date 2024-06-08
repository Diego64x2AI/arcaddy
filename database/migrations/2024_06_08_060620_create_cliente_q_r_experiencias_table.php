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
		Schema::create('cliente_q_r_experiencias', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('titulo');
			$table->string('url')->nullable();
			$table->enum('tipo', ['video', 'imagen', 'link'])->default('link');
			// latitud y longitud
			$table->double('lat', 10, 8)->nullable()->default(0);
			$table->double('lng', 11, 8)->nullable()->default(0);
			$table->string('map_marker')->nullable();
			$table->unsignedBigInteger('visitas')->default(0);

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
		Schema::dropIfExists('cliente_q_r_experiencias');
	}
};
