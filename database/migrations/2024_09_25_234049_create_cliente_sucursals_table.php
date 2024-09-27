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
		Schema::create('cliente_sucursals', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->double('lat', 10, 8)->nullable()->default(0);
			$table->double('lng', 11, 8)->nullable()->default(0);
			$table->string('nombre');
			$table->string('telefono')->nullable();
			$table->string('direccion')->nullable();
			$table->string('horario')->nullable();
			$table->string('ciudad')->nullable();
			$table->string('link_titulo')->nullable();
			$table->string('link')->nullable();
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
		Schema::dropIfExists('cliente_sucursals');
	}
};
